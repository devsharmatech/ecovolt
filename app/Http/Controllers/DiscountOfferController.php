<?php
// app/Http/Controllers/Admin/DiscountOfferController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiscountOffer;
use App\Models\DiscountApprovalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\RouteHandle;

class DiscountOfferController extends Controller
{
    use RouteHandle;
    public function index()
    {
        $discounts = DiscountOffer::where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view($this->getRoutePrefix() .'.discount-offer.index', compact('discounts'));
    }

    public function pending()
    {
        $pendingDiscounts = DiscountOffer::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view($this->getRoutePrefix() .'.discount-offer.pending', compact('pendingDiscounts'));
    }

    
    public function create()
    {
        return view($this->getRoutePrefix() .'.discount-offer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rule_name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'applicable_to' => 'nullable|string',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'repeat' => 'nullable|in:none,daily,weekly,monthly,yearly',
            'repeat_days' => 'nullable|array',
            'requires_approval' => 'boolean'
        ]);

        $validated['created_by'] = Auth::user()->name;
        
        // Set status based on approval requirement
        $validated['status'] = $request->has('requires_approval') ? 'pending' : 'active';
        
        // Handle repeat days
        if ($request->has('repeat_days')) {
            $validated['repeat_days'] = json_encode($request->repeat_days);
        }

        $discountOffer = DiscountOffer::create($validated);

        // Log approval history if pending
        if ($discountOffer->status === 'pending') {
            DiscountApprovalHistory::create([
                'discount_offer_id' => $discountOffer->id,
                'action' => 'pending',
                'acted_by' => Auth::user()->name,
                'comments' => 'Created and sent for approval'
            ]);
        }

        return redirect()->route($this->getRoutePrefix() .'.discount-offer.index')
            ->with('success', $discountOffer->status === 'pending' 
                ? 'Discount rule created and sent for approval' 
                : 'Discount rule created successfully');
    }

    public function show(DiscountOffer $discountOffer)
    {
        $approvalHistory = $discountOffer->approvalHistory()->orderBy('acted_at', 'desc')->get();
        return view($this->getRoutePrefix() .'.discount-offer.show', compact('discountOffer', 'approvalHistory'));
    }

    public function edit(DiscountOffer $discountOffer)
    {
        return view($this->getRoutePrefix() .'.discount-offer.edit', compact('discountOffer'));
    }

   
    public function update(Request $request, DiscountOffer $discountOffer)
    {
        $validated = $request->validate([
            'rule_name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'applicable_to' => 'nullable|string',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'repeat' => 'nullable|in:none,daily,weekly,monthly,yearly',
            'repeat_days' => 'nullable|array',
        ]);

        $validated['updated_by'] = Auth::user()->name;
        
        // Handle repeat days
        if ($request->has('repeat_days')) {
            $validated['repeat_days'] = json_encode($request->repeat_days);
        }

        $discountOffer->update($validated);

        return redirect()->route($this->getRoutePrefix() .'.discount-offer.index')
            ->with('success', 'Discount rule updated successfully');
    }

    public function approve(Request $request, DiscountOffer $discountOffer)
    {
        // Validate request
        $request->validate([
            'comments' => 'nullable|string|max:500'
        ]);

        // Check if discount is already processed
        if ($discountOffer->status != 'pending') {
            return redirect()->route($this->getRoutePrefix() .'.discount-offer.pending')
                ->with('error', 'This discount rule has already been processed.');
        }

        // Update discount offer
        $discountOffer->update([
            'status' => 'active',
            'approved_by' => Auth::user()->name,
            'approved_date' => now(),
            'updated_by' => Auth::user()->name
        ]);

        // Create approval history
        DiscountApprovalHistory::create([
            'discount_offer_id' => $discountOffer->id,
            'action' => 'approved',
            'acted_by' => Auth::user()->name,
            'comments' => $request->comments
        ]);

        return redirect()->route($this->getRoutePrefix() .'.discount-offer.pending')
            ->with('success', 'Discount rule "' . $discountOffer->rule_name . '" has been approved successfully.');
    }

    public function reject(Request $request, DiscountOffer $discountOffer)
    {
        // Validate request
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        // Check if discount is already processed
        if ($discountOffer->status != 'pending') {
            return redirect()->route($this->getRoutePrefix() .'.discount-offer.pending')
                ->with('error', 'This discount rule has already been processed.');
        }

        // Update discount offer
        $discountOffer->update([
            'status' => 'inactive',
            'rejection_reason' => $request->rejection_reason,
            'updated_by' => Auth::user()->name
        ]);

        // Create approval history
        DiscountApprovalHistory::create([
            'discount_offer_id' => $discountOffer->id,
            'action' => 'rejected',
            'acted_by' => Auth::user()->name,
            'comments' => $request->rejection_reason
        ]);

        return redirect()->route($this->getRoutePrefix() .'.discount-offer.pending')
            ->with('success', 'Discount rule "' . $discountOffer->rule_name . '" has been rejected.');
    }

    public function destroy(DiscountOffer $discountOffer)
    {
        $discountOffer->delete();

        return redirect()->route($this->getRoutePrefix() .'.discount-offer.index')
            ->with('success', 'Discount rule deleted successfully');
    }
}