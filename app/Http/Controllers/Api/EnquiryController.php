<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::where('user_id', auth()->id())->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $enquiries
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10',
            'address' => 'required',
            'load_requirement' => 'required',
        ]);

        $sitePhotoPath = null;
        if ($request->hasFile('site_photo')) {
            $sitePhotoPath = $request->file('site_photo')->store('enquiries', 'public');
        }

        $enquiry = Enquiry::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'load_requirement' => $request->load_requirement,
            'panel_capacity' => $request->panel_capacity,
            'package_name' => $request->package_name,
            'site_photo' => $sitePhotoPath,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Enquiry submitted successfully!',
            'data' => $enquiry
        ]);
    }
}
