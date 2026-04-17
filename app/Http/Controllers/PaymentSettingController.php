<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $setting = PaymentSetting::first();
        return view('admin.payments.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'booking_perc' => 'required|numeric|min:0|max:100',
            'commissioning_perc' => 'required|numeric|min:0|max:100',
        ]);

        PaymentSetting::first()->update([
            'booking_perc' => $request->booking_perc,
            'commissioning_perc' => $request->commissioning_perc,
        ]);

        return redirect()->back()->with('success', 'Payment split settings updated successfully!');
    }
}
