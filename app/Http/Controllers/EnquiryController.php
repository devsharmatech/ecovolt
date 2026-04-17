<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use App\RouteHandle;

class EnquiryController extends Controller
{
    use RouteHandle;
    
    public function index()
    {
        $role = $this->getRoutePrefix();
        $enquiries = Enquiry::with('user')->latest()->get();
        return view($role .'.enquiries.index', compact('enquiries', 'role'));
    }

    public function show($id)
    {
        $role = $this->getRoutePrefix();
        $enquiry = Enquiry::with('user')->findOrFail($id);
        return view($role .'.enquiries.show', compact('enquiry', 'role'));
    }

    public function updateStatus(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function destroy($id)
    {
        Enquiry::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Enquiry removed.');
    }
}
