<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $role = auth()->user()->getRoleNames()->first();

        // ── ADMIN VIEW ────────────────────────────
        if ($role == 'admin') {
            $leadsCount = \App\Models\Lead::count();
            $projectsCount = \App\Models\Project::count();
            $pendingApprovals = \App\Models\DiscountOffer::where('status', 'pending')->count();
            $recentProjects = \App\Models\Project::latest()->take(5)->get();
            $dealerCount = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'dealer'))->count();
            $dealerStats = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'dealer'))
                ->withCount(['leads', 'projects'])
                ->orderBy('leads_count', 'desc')
                ->take(5)
                ->get();

            return view('admin.index', compact('leadsCount', 'projectsCount', 'pendingApprovals', 'recentProjects', 'dealerCount', 'dealerStats'));
        }

        // ── DEALER VIEW ───────────────────────────
        if (strtolower($role) === 'dealer') {
            $user = auth()->user();
            $leadsCount = \App\Models\Lead::where('dealer_id', $user->id)->count();
            $projectsCount = \App\Models\Project::where('dealer_id', $user->id)->count();
            
            // Commission: 5% of total_amount of completed projects or part_payment of active
            $myCommission = \App\Models\Project::where('dealer_id', $user->id)->sum('part_payment_amount') * 0.05; 
            $recentProjects = \App\Models\Project::where('dealer_id', $user->id)->latest()->take(5)->get();
            
            // Stats for Payout Summary
            $payoutStats = [
                'last_settlement' => 0.00,
                'pending_disbursement' => $myCommission,
                'next_cycle' => '15th ' . now()->format('M'),
                'status' => 'Active'
            ];

            return view('dealer.index', compact('leadsCount', 'projectsCount', 'myCommission', 'recentProjects', 'payoutStats'));
        }
        // ── ACCOUNTS VIEW ───────────────────────────
        if (strtolower($role) === 'accounts' || strtolower($role) === 'accounts manager') {
            return view('admin.accounts.dashboard');
        }

        // ── DEFAULT / OTHER VIEWS (Admin-like) ──────────────────
        $leadsCount = \App\Models\Lead::count();
        $projectsCount = \App\Models\Project::count();
        $pendingApprovals = \App\Models\DiscountOffer::where('status', 'pending')->count();
        $recentProjects = \App\Models\Project::latest()->take(5)->get();
        $dealerCount = \App\Models\User::role('dealer')->count();
        $dealerStats = \App\Models\User::role('dealer')
            ->withCount(['leads', 'projects'])
            ->orderBy('leads_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.index', compact('leadsCount', 'projectsCount', 'pendingApprovals', 'recentProjects', 'dealerCount', 'dealerStats'));
    }

}
