<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\RouteHandle;
use App\Traits\NotificationTrait;

class DocumentController extends Controller
{
    use RouteHandle, NotificationTrait;
    
    public function index(Request $request) {
        $role = strtolower($this->getRoutePrefix());
        $user = auth()->user();
        
        $query = Document::with('lead');

        if ($role == 'dealer') {
            $query->whereHas('lead', function($q) use ($user) {
                $q->where('dealer_id', $user->id);
            });
        } elseif ($role == 'accounts' || $role == 'employee') {
            $query->whereHas('lead', function($q) use ($user) {
                $q->where('assigned_employee_id', $user->id);
            });
        }

        $documents = $query->latest()->get();
        return view($role .'.documents.index', compact('documents'));
    }

    public function create() {
        $role = $this->getRoutePrefix();
        if ($role == 'dealer') {
            $leads = Lead::where('dealer_id', auth()->id())->orderBy('created_at', 'desc')->get();
        } else {
            $leads = Lead::orderBy('created_at', 'desc')->get();
        }
        return view($role .'.documents.create', compact('leads'));
    }

    public function store(Request $request) {
        $role = $this->getRoutePrefix();
        $request->validate([
            'customer_name' => 'required',
            'lead_id' => 'required',
            'doc_geo' => 'required|file|max:5120',
        ]);

        $data = [
            'customer_name' => $request->customer_name,
            'lead_id' => $request->lead_id,
            'email_val' => $request->doc_email_verify,
            'mobile_val' => $request->doc_mobile_verify,
            'status' => 'pending',
            'uploaded_date' => now(),
        ];

        // Handling Files
        $fields = ['doc_pan' => 'pan_path', 'doc_aadhaar' => 'aadhaar_path', 'doc_bill' => 'bill_path', 'doc_bank' => 'bank_path', 'doc_geo' => 'geo_path'];
        foreach($fields as $input => $column) {
            if($request->hasFile($input)) {
                $data[$column] = $request->file($input)->store('documents', 'public');
            }
        }

        $doc = Document::create($data);

        // Notify
        $this->notifyAdmins("New Documents Uploaded", "Documents for {$doc->customer_name} (Lead ID: {$doc->lead_id}) have been uploaded.");
        if ($doc->lead && $doc->lead->dealer_id) {
            $this->notifyDealer($doc->lead->dealer_id, "Documents Uploaded", "Documents for {$doc->customer_name} have been uploaded.");
        }

        return redirect()->route($role .'.documents.index')->with('success', 'Documents saved to database!');
    }

    public function show(Document $document) {
        return view($this->getRoutePrefix() .'.documents.show', compact('document'));
    }

    public function edit(Document $document) {
        $role = $this->getRoutePrefix();
        $leads = ($role == 'dealer') ? Lead::where('dealer_id', auth()->id())->get() : Lead::all();
        return view($role .'.documents.edit', compact('document', 'leads'));
    }

    public function update(Request $request, Document $document) {
        $data = [
            'customer_name' => $request->customer_name,
            'email_val' => $request->doc_email_verify,
            'mobile_val' => $request->doc_mobile_verify
        ];

        $fields = ['doc_pan' => 'pan_path', 'doc_aadhaar' => 'aadhaar_path', 'doc_bill' => 'bill_path', 'doc_bank' => 'bank_path', 'doc_geo' => 'geo_path'];
        foreach($fields as $input => $column) {
            if($request->hasFile($input)) {
                if($document->$column) Storage::disk('public')->delete($document->$column);
                $data[$column] = $request->file($input)->store('documents', 'public');
            }
        }

        $document->update($data);
        return redirect()->route($this->getRoutePrefix() .'.documents.index')->with('success', 'Document set updated!');
    }

    public function destroy(Document $document) {
        $document->delete();
        return redirect()->back()->with('success', 'Removed.');
    }
}