<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\RouteHandle;

use App\Traits\NotificationTrait;

class ProjectController extends Controller
{
    use RouteHandle, NotificationTrait;

    public function index()
    {
        $role = strtolower(auth()->user()->getRoleNames()->first());
        $user = auth()->user();

        $query = Project::with('lead');

        if ($role == 'dealer') {
            $query->where('dealer_id', $user->id);
        } elseif ($role == 'accounts' || $role == 'employee') {
            $query->whereHas('lead', function($q) use ($user) {
                $q->where('assigned_employee_id', $user->id);
            });
        }

        $projects = $query->latest()->get();
        return view($this->getRoutePrefix() . '.projects.index', compact('projects'));
    }

    public function create()
    {
        $leads = Lead::orderBy('created_at','desc')->get();
        return view($this->getRoutePrefix() . '.projects.create', compact('leads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id'       => 'required|exists:leads,id',
            'customer_name' => 'required',
            'base_amount'   => 'required|numeric|min:0',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value'=> 'nullable|numeric|min:0',
            'subsidy_amount'=> 'nullable|numeric',
            'part_payment_amount' => 'nullable|numeric',
        ]);

        $code = 'PRJ-' . str_pad(Project::count() + 1, 4, '0', STR_PAD_LEFT);
        $startStage = $request->start_stage ?? 'kyc_complete';

        $baseAmount = $request->base_amount;
        $discountValue = $request->discount_value ?? 0;
        $discountAmount = 0;

        if ($request->discount_type === 'percentage') {
            $discountAmount = ($baseAmount * $discountValue) / 100;
        } else {
            $discountAmount = $discountValue;
        }

        $totalAmount = $baseAmount - $discountAmount;

        $lead = Lead::find($request->lead_id);
        $role = auth()->user()->getRoleNames()->first();
        
        // If created by dealer/sales or lead belongs to them, discount needs approval if > 0
        $discountStatus = 'none';
        if ($discountAmount > 0) {
            if ($role === 'dealer' || $role === 'sales' || $lead->dealer_id) {
                $discountStatus = 'pending';
            } else {
                $discountStatus = 'approved';
            }
        }

        $project = Project::create([
            'project_code'         => $code,
            'lead_id'              => $request->lead_id,
            'dealer_id'            => $lead->dealer_id ?? auth()->id(),
            'customer_name'        => $request->customer_name,
            'system_type'          => $request->system_type,
            'kw_capacity'          => $request->kw_capacity,
            'address'              => $request->address,
            'base_amount'          => $baseAmount,
            'discount_type'        => $request->discount_type,
            'discount_value'       => $discountValue,
            'discount_amount'      => $discountAmount,
            'discount_status'      => $discountStatus,
            'payment_mode'         => $request->payment_mode ?? 'pending',
            'current_stage'        => $startStage,
            'total_amount'         => $totalAmount,
            'subsidy_amount'       => $request->subsidy_amount,
            'part_payment_amount'  => $request->part_payment_amount,
            'suryaghar_app_no'     => $request->suryaghar_app_no,
            'discom_name'          => $request->discom_name,
            'consumer_no'          => $request->consumer_no,
            'meter_no'             => $request->meter_no,
            'notes'                => $request->notes,
            'status'               => $request->status ?? 'active',
            'kyc_completed_at'     => now(),
        ]);

        // Notifications
        if ($discountStatus === 'pending') {
            $this->notifyAdmins("Discount Approval Required", "Project {$code} requires discount approval of amount ₹{$discountAmount}.");
        }
        
        $this->notifyDealer($project->dealer_id, "New Project Created", "A new project {$code} has been created for {$project->customer_name}.");

        return redirect()->route($this->getRoutePrefix() . '.projects.index')
            ->with('success', "Project $code created successfully!" . ($discountStatus === 'pending' ? " Discount waiting for admin approval." : ""));
    }

    public function show(Project $project)
    {
        return view($this->getRoutePrefix() . '.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $leads = Lead::all();
        return view($this->getRoutePrefix() . '.projects.edit', compact('project', 'leads'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'customer_name' => 'required',
            'total_amount'  => 'nullable|numeric',
        ]);

        $project->update($request->all());

        return redirect()->route($this->getRoutePrefix() . '.projects.index')
            ->with('success', "Project {$project->project_code} updated successfully!");
    }

    /** Advance project to next stage */
    public function advanceStage(Request $request, Project $project)
    {
        $stages     = Project::getStages($project->payment_mode);
        $currentIdx = array_search($project->current_stage, $stages);

        // Handle payment mode selection
        if ($project->current_stage === 'payment_mode_selection') {
            $request->validate(['payment_mode' => 'required|in:cash,bank']);
            $project->update([
                'payment_mode'         => $request->payment_mode,
                'payment_selected_at'  => now(),
            ]);
            $stages     = Project::getStages($request->payment_mode);
            $currentIdx = array_search('payment_mode_selection', $stages);
        }

        $nextIdx  = $currentIdx + 1;
        if (!isset($stages[$nextIdx])) {
            return back()->with('info', 'Project is already at final stage!');
        }

        $nextStage = $stages[$nextIdx];
        $tsMap = [
            'geo_tag_upload'           => 'geo_tag_at',
            'pm_suryaghar_registration'=> 'suryaghar_at',
            'payment_mode_selection'   => 'payment_selected_at',
            'bank_login'               => 'bank_login_at',
            'bank_disbursement'        => 'bank_disbursement_at',
            'net_metering'             => 'net_metering_at',
            'inspection'               => 'inspection_at',
            'part_payment'             => 'part_payment_at',
            'commissioning'            => 'commissioning_at',
            'subsidy_redemption'       => 'subsidy_at',
        ];

        $updateData = ['current_stage' => $nextStage];
        if (isset($tsMap[$nextStage])) $updateData[$tsMap[$nextStage]] = now();

        // Handle financial fields
        if ($nextStage === 'part_payment' && $request->part_payment_amount) {
            $updateData['part_payment_amount'] = $request->part_payment_amount;
        }
        if ($nextStage === 'subsidy_redemption' && $request->subsidy_amount) {
            $updateData['subsidy_amount'] = $request->subsidy_amount;
        }
        if ($nextStage === 'subsidy_redemption') {
            $updateData['status'] = 'completed';
        }

        $project->update($updateData);

        return back()->with('success', 'Stage advanced to: ' . Project::stageLabel($nextStage));
    }

    public function approveDiscount(Request $request, Project $project)
    {
        $request->validate([
            'action' => 'required|in:approved,rejected',
            'notes' => 'nullable|string'
        ]);

        $project->update([
            'discount_status' => $request->action,
            'discount_approved_by' => auth()->id(),
            'discount_notes' => $request->notes
        ]);

        $msg = "Discount for project {$project->project_code} has been {$request->action}.";
        
        $this->notifyDealer($project->dealer_id, "Discount Update", $msg);
        
        return back()->with('success', $msg);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route($this->getRoutePrefix() . '.projects.index')
            ->with('success', 'Project removed.');
    }
}
