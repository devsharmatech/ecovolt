<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use App\RouteHandle;

class ServiceRequestController extends Controller
{
    use RouteHandle;
    
    public function index()
    {
        $role = $this->getRoutePrefix();
        $requests = ServiceRequest::with('user')->latest()->get();
        return view($role .'.services.index', compact('requests', 'role'));
    }

    public function updateStatus(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function destroy($id)
    {
        ServiceRequest::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Removed.');
    }
}
