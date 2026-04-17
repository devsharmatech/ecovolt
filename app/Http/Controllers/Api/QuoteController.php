<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\NotificationTrait;

class QuoteController extends Controller
{
    use NotificationTrait;
    public function index()
    {
        \Log::info('Quote Request from User ID: ' . auth()->id());
        $quote = Quote::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->first();
        \Log::info('Quote Found: ' . ($quote ? $quote->id : 'None'));

        return response()->json([
            'status' => 'success',
            'data' => $quote
        ]);
    }

    public function respond(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,declined',
            'rejection_reason' => 'nullable|string'
        ]);
        
        $quote = Quote::where('user_id', auth()->id())->findOrFail($id);
        $quote->update([
            'status' => $request->status,
            'rejection_reason' => $request->rejection_reason ?? null
        ]);

        // Notify Admin and Dealer
        $this->notifyAdmins("Quotation " . ucfirst($request->status), "Customer " . auth()->user()->name . " has {$request->status} quotation {$quote->proposal_id}.");
        
        if ($quote->project) {
            if ($request->status == 'accepted') {
                $quote->project->update([
                    'status' => 'active',
                    'current_stage' => 'kyc_complete'
                ]);

                // Create initial entry for Accounts to verify
                \App\Models\Payment::updateOrCreate(
                    ['project_id' => $quote->project->id, 'type' => 'Booking'],
                    [
                        'customer_name' => auth()->user()->name,
                        'customer_email' => auth()->user()->email,
                        'amount' => $quote->project->lead->booking_amount ?? 10000, // Default or lead defined
                        'payment_status' => 'Pending',
                        'payment_method' => 'App-Online'
                    ]
                );

                // Notify Accounts team
                $accounts = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'accounts'))->get();
                foreach($accounts as $acc) {
                    $this->sendNotification($acc->id, "Booking Verification Needed", "Customer " . auth()->user()->name . " has accepted the quote. Please verify booking payment.", 'payment');
                }
            }
            
            if ($quote->project->dealer_id) {
                $this->notifyDealer($quote->project->dealer_id, "Quotation " . ucfirst($request->status), "Customer has {$request->status} quotation {$quote->proposal_id}.");
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Quote status updated to ' . $request->status,
            'data' => $quote
        ]);
    }

    public function download($id)
    {
        $quote = Quote::where('user_id', auth()->id())->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.quote', compact('quote'));
        
        return $pdf->stream('Quote-' . $quote->proposal_id . '.pdf');
    }
}
