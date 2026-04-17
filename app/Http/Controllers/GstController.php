<?php

namespace App\Http\Controllers;

use App\Models\SolarPricing;
use Illuminate\Http\Request;

class GstController extends Controller
{
    public function index()
    {
        // Get the standard GST rate from the first category or a global default
        $pricing = SolarPricing::first();
        $globalGst = $pricing ? $pricing->gst_rate : 8.9;

        // Examples for preview
        $previewValue = 100000; // Example 1 Lakh
        $taxable = $previewValue / (1 + ($globalGst / 100));
        $gstAmount = $previewValue - $taxable;

        return view('admin.gst.index', compact('globalGst', 'taxable', 'gstAmount', 'previewValue'));
    }

    public function update(Request $request)
    {
        $request->validate(['gst_rate' => 'required|numeric|min:0|max:100']);

        // Update GST for all categories to keep it unified system-wide
        SolarPricing::query()->update(['gst_rate' => $request->gst_rate]);

        return redirect()->back()->with('success', "System-wide GST rate updated to {$request->gst_rate}%");
    }
}
