<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Quote;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Project;
use App\Traits\NotificationTrait;

class QuoteController extends \App\Http\Controllers\Controller
{
    use NotificationTrait;
    public function index()
    {
        $role = auth()->user()->getRoleNames()->first();
        $user = auth()->user();

        $query = Quote::with(['user', 'project.lead']);

        if (strtolower($role) === 'dealer') {
            $query->whereHas('project', function($q) use ($user) {
                $q->where('dealer_id', $user->id);
            });
        } elseif (strtolower($role) === 'accounts' || strtolower($role) === 'employee') {
            $query->whereHas('project.lead', function($q) use ($user) {
                $q->where('assigned_employee_id', $user->id);
            });
        }

        $quotes = $query->latest()->get();
        return view('admin.quotes.index', compact('quotes', 'role'));
    }

    public function create(Request $request)
    {
        $role = auth()->user()->getRoleNames()->first();
        $projects = Project::with('lead')->where('status', 'active')->get();
        $selectedProject = $request->project_id ? Project::find($request->project_id) : null;
        return view('admin.quotes.create', compact('projects', 'selectedProject', 'role'));
    }

    public function download($id)
    {
        $quote = Quote::with('user')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.quote', compact('quote'));
        return $pdf->stream('Quote-' . $quote->proposal_id . '.pdf');
    }

    public function show($id)
    {
        $role = auth()->user()->getRoleNames()->first();
        $quote = Quote::with('user')->findOrFail($id);
        return view('admin.quotes.show', compact('quote', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'package_name' => 'required',
            'total_price' => 'required|numeric',
            'proposal_id' => 'required|unique:quotes',
            'components' => 'required|array'
        ]);

        $project = Project::find($request->project_id);
        
        // Find customer user by phone from lead
        $customer = User::where('phone', $project->lead->phone)->first();

        $quote = Quote::create([
            'user_id' => $customer ? $customer->id : 0, // Fallback if no user account yet
            'project_id' => $project->id,
            'package_name' => $request->package_name,
            'total_price' => $request->total_price,
            'proposal_id' => $request->proposal_id,
            'status' => 'pending',
            'components' => $request->components,
            'timeline' => $request->timeline,
            'quote_date' => now()
        ]);

        $project->update(['quotation_sent_at' => now()]);

        // Notifications
        if ($customer) {
            $this->sendNotification($customer->id, "New Quotation Received", "A new quotation {$quote->proposal_id} has been generated for your solar project.", 'quote', $quote->id);
        }
        
        $this->notifyDealer($project->dealer_id, "Quotation Generated", "Quotation {$quote->proposal_id} has been sent to the customer for project {$project->project_code}.");

        $role = auth()->user()->getRoleNames()->first();
        return redirect()->route($role . '.quotes.index')->with('success', 'Quotation created and sent successfully!');
    }

    public function edit($id)
    {
        $role = auth()->user()->getRoleNames()->first();
        $quote = Quote::findOrFail($id);
        $projects = Project::with('lead')->get();
        return view('admin.quotes.edit', compact('quote', 'projects', 'role'));
    }

    public function update(Request $request, $id)
    {
        $quote = Quote::findOrFail($id);
        $request->validate([
            'package_name' => 'required',
            'total_price' => 'required|numeric',
            'components' => 'required|array'
        ]);

        $quote->update([
            'package_name' => $request->package_name,
            'total_price' => $request->total_price,
            'components' => $request->components,
            'timeline' => $request->timeline
        ]);

        $role = auth()->user()->getRoleNames()->first();
        return redirect()->route($role . '.quotes.index')->with('success', 'Quotation updated successfully!');
    }

    public function destroy($id)
    {
        Quote::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Quotation deleted!');
    }
}
