<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use App\RouteHandle;

class LeadController extends Controller
{
    use RouteHandle;

    public function index()
    {
        $role = strtolower(auth()->user()->getRoleNames()->first());
        $user = auth()->user();

        $query = Lead::orderBy('created_at', 'desc');

        if ($role == 'dealer') {
            $query->where('dealer_id', $user->id);
        } elseif ($role == 'accounts' || $role == 'employee') {
            $query->where('assigned_employee_id', $user->id);
        }

        $employees = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['employee', 'accounts']);
        })->get();

        $leads = $query->get();
        return view($this->getRoutePrefix() . '.lead.index', compact('leads', 'employees'));
    }

    public function create()
    {
        $dealers = User::whereHas('roles', function($q) {
            $q->where('name', 'dealer');
        })->get();

        $employees = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['employee', 'accounts']);
        })->get();

        return view($this->getRoutePrefix() . '.lead.create', compact('dealers', 'employees'));
    }

    public function store(Request $request)
    {
        $role = auth()->user()->getRoleNames()->first();
        
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'system_type' => 'required|in:On-grid,Hybrid,Off-grid',
            'kw_capacity' => 'required|numeric|min:0',
            'city' => 'required|string',
        ];

        if ($role != 'dealer') {
            $rules['dealer_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        // Auto-generate LED ID
        $lastLead = Lead::orderBy('id', 'desc')->first();
        $nextId = $lastLead ? ($lastLead->id + 1) : 1;
        $leadCode = 'LED-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $dealerId = ($role == 'dealer') ? auth()->id() : $request->dealer_id;

        $lead = Lead::create(array_merge($request->all(), [
            'lead_code' => $leadCode,
            'stage' => 'Entry',
            'dealer_id' => $dealerId
        ]));

        // Notify Admins
        $admins = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Lead Created',
                'description' => "A new lead {$leadCode} has been created by " . auth()->user()->name,
                'type' => 'alert',
            ]);
        }

        return redirect()->route($role . '.leads.index')->with('success', "New Lead {$leadCode} created successfully.");
    }

    public function show(Lead $lead)
    {
        return view($this->getRoutePrefix() . '.lead.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $dealers = User::whereHas('roles', function($q) {
            $q->where('name', 'dealer');
        })->get();

        $employees = User::whereHas('roles', function($q) {
            $q->whereIn('name', ['employee', 'accounts']);
        })->get();

        return view($this->getRoutePrefix() . '.lead.edit', compact('lead', 'dealers', 'employees'));
    }

    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'stage' => 'required'
        ]);

        $oldStage = $lead->stage;
        $lead->update($request->all());

        // Master Flow: Transition to Project Creation on Booking
        if ($request->stage == 'Booking' && $oldStage != 'Booking') {
            
            // Check if project already exists to avoid duplicates
            if (!\App\Models\Project::where('lead_id', $lead->id)->exists()) {
                $prjCode = 'PRJ-' . str_pad(\App\Models\Project::count() + 1, 4, '0', STR_PAD_LEFT);
                
                \App\Models\Project::create([
                    'project_code'         => $prjCode,
                    'lead_id'              => $lead->id,
                    'dealer_id'            => $lead->dealer_id,
                    'customer_name'        => $lead->first_name . ' ' . $lead->last_name,
                    'system_type'          => strtolower($lead->system_type),
                    'kw_capacity'          => $lead->kw_capacity,
                    'address'              => $lead->full_address,
                    'current_stage'        => 'kyc_complete', // Starts Unified Flow
                    'total_amount'         => $request->total_amount ?? 0,
                    'part_payment_amount'  => $request->booking_amount ?? 0,
                    'status'               => 'active',
                    'kyc_completed_at'     => now(),
                ]);

                return redirect()->route($this->getRoutePrefix() . '.leads.index')
                    ->with('success', "Lead promoted to Booking! Project {$prjCode} created automatically.");
            }
        }

        return redirect()->route($this->getRoutePrefix() . '.leads.index')->with('success', 'Lead updated successfully.');
    }

    public function quickAssign(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->update([
            'assigned_employee_id' => $request->assigned_employee_id,
            'assigned_at' => now(),
            'stage' => ($lead->stage == 'Entry') ? 'Assigned' : $lead->stage
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Lead assigned successfully to ' . \App\Models\User::find($request->assigned_employee_id)->name
        ]);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route($this->getRoutePrefix() . '.leads.index')->with('success', 'Lead deleted successfully.');
    }
}