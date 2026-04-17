<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = ServiceRequest::where('user_id', auth()->id())->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $requests
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'issue_type' => 'required',
            'description' => 'required'
        ]);

        $serviceRequest = ServiceRequest::create([
            'user_id' => auth()->id(),
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Service request booked successfully!',
            'data' => $serviceRequest
        ]);
    }
}
