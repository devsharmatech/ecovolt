@extends('admin.layouts.master')
@section('title', 'Partner Portal')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .dl-wrap { padding: 32px; background: #f0f4f8; min-height: 100vh; }
    
    /* Stats grid */
    .dl-metrics { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    
    .dl-card {
        background: #fff; border-radius: 20px; padding: 24px;
        border: 1.5px solid #e2e8f0; transition: transform 0.3s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .dl-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.08); }

    .dl-card-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; margin-bottom: 16px;
    }
    .dl-card-label { font-size: 11px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
    .dl-card-val { font-size: 1.8rem; font-weight: 900; color: #0f172a; margin: 4px 0 10px; }
    
    .dl-card-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 30px; font-size: 10px; font-weight: 800;
        background: #f0fdf4; color: #166534;
    }

    .dl-id-box {
        background: linear-gradient(135deg, #14532d, #16a34a);
        border: none; color: #fff;
    }
    .dl-id-box .dl-card-label { color: rgba(255,255,255,0.7); }
    .dl-id-box .dl-card-val { color: #fff; }
    .dl-id-box .dl-card-badge { background: rgba(255,255,255,0.15); color: #fff; }

    /* 2-col */
    .dl-cols { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
    .dl-section { background: #fff; border-radius: 22px; border: 1.5px solid #f1f5f9; padding: 24px; }
    .dl-sec-title { font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .dl-sec-title i { color: #16a34a; }

    /* Table */
    .dl-table { width: 100%; border-collapse: collapse; }
    .dl-table th { font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; padding: 12px 10px; border-bottom: 1.5px solid #f8fafc; text-align: left; }
    .dl-table td { padding: 14px 10px; border-bottom: 1px solid #f8fafc; font-size: 0.88rem; color: #334155; }
    .dl-table tr:hover td { background: #f8fafc; }

    .prj-status { padding: 4px 10px; border-radius: 30px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
    .status-alert { background: #fff1f2; color: #be123c; }
    .status-ok { background: #f0fdf4; color: #166534; }

    .payout-btn {
        width: 100%; background: #16a34a; color: #fff; border: none;
        padding: 12px; border-radius: 12px; font-weight: 800; font-size: 0.85rem;
        cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px;
        margin-top: 15px;
    }
    .payout-btn:hover { background: #15803d; transform: translateY(-2px); }

    .summary-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px dashed #e2e8f0; }
    .summary-item:last-child { border: none; }
    .summary-lbl { font-size: 0.8rem; font-weight: 600; color: #64748b; }
    .summary-val { font-size: 0.85rem; font-weight: 800; color: #1e293b; }
</style>
@endsection

@section('content')
<div class="dl-wrap">
    
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 1.8rem; font-weight: 900; color: #0f172a;">Dealer Dashboard</h1>
        <p style="color: #64748b; font-weight: 500;">Welcome back, <strong>{{ auth()->user()->name }}</strong>. Here's your performance snapshot.</p>
    </div>

    {{-- Metrics --}}
    <div class="dl-metrics">
        <div class="dl-card dl-id-box">
            <div class="dl-card-icon" style="background: rgba(255,255,255,0.15);">
                <i class="fas fa-id-card"></i>
            </div>
            <div class="dl-card-label">Dealer Unique identity</div>
            <div class="dl-card-val">ELV-DLR-{{ str_pad(auth()->user()->id, 3, '0', STR_PAD_LEFT) }}</div>
            <div class="dl-card-badge">Network: Verified</div>
        </div>

        <div class="dl-card">
            <div class="dl-card-icon" style="background: #ecfdf5; color: #10b981;">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="dl-card-label">My Total Leads</div>
            <div class="dl-card-val">{{ $leadsCount }}</div>
            <div class="dl-card-badge">Active Funnel</div>
        </div>

        <div class="dl-card">
            <div class="dl-card-icon" style="background: #eff6ff; color: #3b82f6;">
                <i class="fas fa-solar-panel"></i>
            </div>
            <div class="dl-card-label">Execution (Projects)</div>
            <div class="dl-card-val">{{ $projectsCount }}</div>
            <div class="dl-card-badge">In Installation</div>
        </div>

        <div class="dl-card text-success" style="background: #16653410;">
            <div class="dl-card-icon" style="background: #166534; color: #fff;">
                <i class="fas fa-coins"></i>
            </div>
            <div class="dl-card-label">Estimated Commission</div>
            <div class="dl-card-val">₹{{ number_format($myCommission) }}</div>
            <div class="dl-card-badge" style="background: #16a34a; color: #fff;">Accrued Balance</div>
        </div>
    </div>

    {{-- Main sections --}}
    <div class="dl-cols">
        
        {{-- Project Track --}}
        <div class="dl-section">
            <div class="dl-sec-title">
                <i class="fas fa-map-marker-alt"></i> Project Execution Tracking
            </div>
            <table class="dl-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Project Code</th>
                        <th>Current Stage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProjects as $p)
                    <tr>
                        <td style="font-weight: 700;">{{ $p->customer_name }}</td>
                        <td style="font-weight: 600; color: #64748b;">{{ $p->project_code }}</td>
                        <td>
                            <span style="font-weight: 800; color: #16a34a;">
                                {{ \App\Models\Project::stageLabel($p->current_stage) }}
                            </span>
                        </td>
                        <td>
                            <span class="prj-status status-ok">In Progress</span>
                        </td>
                    </tr>
                    @endforeach
                    @if($recentProjects->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center; color: #94a3b8; padding: 40px;">No active projects to track.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Commission & Payout --}}
        <div class="dl-section">
            <div class="dl-sec-title">
                <i class="fas fa-wallet"></i> Payout Summary
            </div>
            <div style="padding-top: 10px;">
                <div class="summary-item">
                    <span class="summary-lbl">Last Settlement</span>
                    <span class="summary-val">₹{{ number_format($payoutStats['last_settlement'], 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-lbl">Pending Disbursement</span>
                    <span class="summary-val">₹{{ number_format($payoutStats['pending_disbursement'], 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-lbl">Next Payout Cycle</span>
                    <span class="summary-val">{{ $payoutStats['next_cycle'] }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-lbl">Status</span>
                    <span style="font-size: 0.8rem; font-weight: 900; color: #16a34a;">{{ $payoutStats['status'] }}</span>
                </div>

                <button class="payout-btn" id="requestPayoutBtn">
                    <i class="fas fa-paper-plane"></i> Raise Payout Request
                </button>
            </div>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payoutBtn = document.getElementById('requestPayoutBtn');
        if(payoutBtn) {
            payoutBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Processing Request...',
                    text: 'Locating pending disbursements and generating your payout request.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Simulating network request processing
                setTimeout(() => {
                    Swal.fire({
                        title: 'Request Submitted! 🚀',
                        text: 'Your payout request has been successfully submitted for processing. The admin team will review it shortly.',
                        icon: 'success',
                        confirmButtonColor: '#16a34a',
                        confirmButtonText: 'Great!'
                    });
                }, 2000);
            });
        }
    });
</script>
@endsection
