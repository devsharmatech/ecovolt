<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Lead;
use Illuminate\Http\Request;
use App\RouteHandle;

class AccountController extends Controller
{
    use RouteHandle;

    public function index()
    {
        // Lists all payments with a clear breakdown
        $payments = Payment::orderBy('created_at', 'desc')->get();
        return view($this->getRoutePrefix() . '.accounts.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view($this->getRoutePrefix() . '.accounts.show', compact('payment'));
    }

    public function verify($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'payment_status' => 'Received',
            'payment_date' => now()
        ]);

        return redirect()->back()->with('success', 'Payment verified and marked as Received!');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $payment->update([
            'payment_status' => $request->status,
            'payment_date' => $request->status == 'Received' ? now() : null
        ]);

        return redirect()->back()->with('success', 'Payment status updated!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route($this->getRoutePrefix() . '.accounts.index')->with('success', 'Payment record deleted successfully.');
    }
}
