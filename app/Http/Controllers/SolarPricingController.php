<?php

namespace App\Http\Controllers;

use App\Models\SolarPricing;
use Illuminate\Http\Request;

class SolarPricingController extends Controller
{
    public function index()
    {
        $pricings = SolarPricing::all();
        return view('admin.pricing.index', compact('pricings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'price_per_kw' => 'required|numeric|min:0',
            'gst_rate'     => 'required|numeric|min:0|max:100',
            'margin_floor' => 'required|numeric|min:0|max:100',
        ]);

        $pricing = SolarPricing::findOrFail($id);
        $pricing->update([
            'price_per_kw' => $request->price_per_kw,
            'gst_rate'     => $request->gst_rate,
            'margin_floor' => $request->margin_floor,
        ]);

        return redirect()->back()->with('success', "Pricing for {$pricing->category} updated successfully!");
    }

    public function destroy($id)
    {
        $pricing = SolarPricing::findOrFail($id);
        $cat = $pricing->category;
        $pricing->delete();

        return redirect()->back()->with('success', "Pricing category '{$cat}' deleted successfully.");
    }
}
