<?php

namespace App\Http\Controllers;

use App\Models\DiscountSetting;
use Illuminate\Http\Request;

class DiscountSettingController extends Controller
{
    public function index()
    {
        $setting = DiscountSetting::first();
        return view('admin.discounts.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'employee_limit' => 'required|numeric|min:0|max:100',
            'manager_limit' => 'required|numeric|min:0|max:100',
            'coo_limit' => 'required|numeric|min:0|max:100',
            'margin_floor' => 'required|numeric|min:0|max:100',
        ]);

        DiscountSetting::first()->update([
            'employee_limit' => $request->employee_limit,
            'manager_limit' => $request->manager_limit,
            'coo_limit' => $request->coo_limit,
            'margin_floor' => $request->margin_floor,
        ]);

        return redirect()->back()->with('success', 'Discount tiers and margin floor updated successfully!');
    }
}
