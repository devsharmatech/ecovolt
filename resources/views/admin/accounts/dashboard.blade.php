@extends('admin.layouts.master')

@section('title', 'Accounts Dashboard')

@section('css')
<style>
    :root {
        --acc-primary: #0f172a;
        --acc-accent: #059669;
        --acc-light: #f8fafc;
        --acc-border: #e2e8f0;
    }
    
    .acc-wrap { padding: 32px; background: #f0f4f8; min-height: 100vh; font-family: 'Inter', sans-serif; }
    
    .acc-header {
        display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px;
    }
    .acc-title { font-size: 1.8rem; font-weight: 900; color: var(--acc-primary); margin: 0 0 8px; }
    .acc-subtitle { color: #64748b; font-weight: 500; font-size: 0.95rem; margin: 0; }
    
    .acc-top-action .btn {
        background: var(--acc-accent); border: none; color: white;
        padding: 12px 24px; border-radius: 12px; font-weight: 700;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.2); transition: 0.2s;
    }
    .acc-top-action .btn:hover { background: #047857; transform: translateY(-2px); }

    /* Summary Cards */
    .acc-summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    .acc-card {
        background: #fff; padding: 24px; border-radius: 20px;
        border: 1px solid var(--acc-border); box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        display: flex; flex-direction: column; position: relative; overflow: hidden;
    }
    .acc-card::after {
        content: ''; position: absolute; top: 0; right: 0; width: 60px; height: 60px;
        background: linear-gradient(135deg, rgba(255,255,255,0), rgba(0,0,0,0.03));
        border-radius: 0 0 0 60px;
    }
    
    .acc-card-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; margin-bottom: 16px;
    }
    .icon-green { background: #ecfdf5; color: #10b981; }
    .icon-blue { background: #eff6ff; color: #3b82f6; }
    .icon-amber { background: #fffbeb; color: #f59e0b; }
    .icon-purple { background: #faf5ff; color: #a855f7; }

    .acc-card-lbl { font-size: 0.75rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
    .acc-card-val { font-size: 1.8rem; font-weight: 900; color: #0f172a; margin: 4px 0 8px; }
    .acc-card-bot { font-size: 0.8rem; font-weight: 600; color: #10b981; display: flex; align-items: center; gap: 4px; }
    .acc-card-bot.alert { color: #f43f5e; }

    /* Section Split */
    .acc-split { display: grid; grid-template-columns: 2fr 1.2fr; gap: 24px; margin-bottom: 30px; }
    
    .acc-section {
        background: #fff; border-radius: 24px; border: 1px solid var(--acc-border);
        padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .sec-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; }
    .sec-title i { color: #64748b; }

    /* Table Styles */
    .acc-table { width: 100%; border-collapse: collapse; }
    .acc-table th {
        font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;
        padding: 14px 12px; border-bottom: 2px solid var(--acc-border); text-align: left;
    }
    .acc-table td { padding: 16px 12px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; }
    .acc-table tr:hover td { background: #f8fafc; }
    
    .tag-70 { background: #dbeafe; color: #1e40af; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; }
    .tag-30 { background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; }
    
    .btn-validate { background: #10b981; color: white; border: none; padding: 6px 14px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer; transition: 0.2s; }
    .btn-validate:hover { background: #059669; }

    /* Action List */
    .acc-action-list { list-style: none; padding: 0; margin: 0; }
    .acc-action-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px; border: 1px solid #f1f5f9; border-radius: 14px; margin-bottom: 12px;
        background: #fafbfc; transition: 0.2s;
    }
    .acc-action-item:hover { border-color: #cbd5e1; background: #fff; }
    
    .action-icon {
        width: 36px; height: 36px; border-radius: 10px; background: #e2e8f0; color: #475569;
        display: flex; align-items: center; justify-content: center; margin-right: 14px;
    }
    .action-text { flex-grow: 1; }
    .action-lbl { font-weight: 800; color: #1e293b; font-size: 0.9rem; margin-bottom: 2px; }
    .action-sub { font-size: 0.75rem; color: #64748b; font-weight: 600; }
    
    .action-btn { background: #0f172a; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.75rem; cursor: pointer; }
    .action-btn:hover { background: #1e293b; color: white; }

</style>
@endsection

@section('content')
<div class="acc-wrap">
    
    <!-- Header -->
    <div class="acc-header">
        <div>
            <h1 class="acc-title">Accounts Dashboard</h1>
            <p class="acc-subtitle">Financial oversight: Payment Validations, Outstanding Tracking & Disbursements.</p>
        </div>
        <div class="acc-top-action">
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.reports.index') }}" class="btn">
                <i class="fas fa-file-export me-2"></i> Export Reports
            </a>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="acc-summary-grid">
        <div class="acc-card">
            <div class="acc-card-icon icon-green"><i class="fas fa-money-check-alt"></i></div>
            <div class="acc-card-lbl">Total Validated (70%)</div>
            <div class="acc-card-val">₹{{ number_format($totals['validated_70'] ?? 1545000) }}</div>
            <div class="acc-card-bot"><i class="fas fa-arrow-up"></i> Collected via Booking</div>
        </div>
        <div class="acc-card">
            <div class="acc-card-icon icon-blue"><i class="fas fa-check-double"></i></div>
            <div class="acc-card-lbl">Total Validated (30%)</div>
            <div class="acc-card-val">₹{{ number_format($totals['validated_30'] ?? 420000) }}</div>
            <div class="acc-card-bot"><i class="fas fa-arrow-up"></i> Collected at Handover</div>
        </div>
        <div class="acc-card">
            <div class="acc-card-icon icon-amber"><i class="fas fa-exclamation-circle"></i></div>
            <div class="acc-card-lbl">Outstanding Tracking</div>
            <div class="acc-card-val">₹{{ number_format($totals['outstanding'] ?? 310000) }}</div>
            <div class="acc-card-bot alert"><i class="fas fa-clock"></i> Pending 30% Payments</div>
        </div>
        <div class="acc-card">
            <div class="acc-card-icon icon-purple"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="acc-card-lbl">Pending Dealer Payouts</div>
            <div class="acc-card-val">₹{{ number_format($totals['dealer_payout'] ?? 85000) }}</div>
            <div class="acc-card-bot alert"><i class="fas fa-hourglass-half"></i> Commissions to Disburse</div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="acc-split">
        
        <!-- Pending Validations -->
        <div class="acc-section">
            <div class="sec-title">
                <span><i class="fas fa-tasks me-2"></i> Pending Payment Validations</span>
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.accounts.index') }}" style="font-size:0.8rem; font-weight:800; color:var(--acc-accent); text-decoration:none;">View All</a>
            </div>
            
            <table class="acc-table">
                <thead>
                    <tr>
                        <th>Project Code</th>
                        <th>Type</th>
                        <th>Claimed Amt</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Mock Data since we need immediate UI visualization -->
                    <tr>
                        <td style="font-weight: 800;">PRJ-1049</td>
                        <td><span class="tag-70">70% Booking</span></td>
                        <td style="font-weight: 700;">₹ 1,40,000</td>
                        <td>Today</td>
                        <td><button class="btn-validate">Validate</button></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 800;">PRJ-1022</td>
                        <td><span class="tag-30">30% Handover</span></td>
                        <td style="font-weight: 700;">₹ 60,000</td>
                        <td>Yesterday</td>
                        <td><button class="btn-validate">Validate</button></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 800;">PRJ-1051</td>
                        <td><span class="tag-70">70% Booking</span></td>
                        <td style="font-weight: 700;">₹ 2,10,000</td>
                        <td>12 Apr</td>
                        <td><button class="btn-validate">Validate</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Quick Actions & Tracking -->
        <div class="acc-section">
            <div class="sec-title">
                <span><i class="fas fa-bolt me-2"></i> Accounts Workflow</span>
            </div>
            
            <ul class="acc-action-list">
                <li class="acc-action-item">
                    <div class="action-icon"><i class="fas fa-file-invoice"></i></div>
                    <div class="action-text">
                        <div class="action-lbl">GST Invoice Generation</div>
                        <div class="action-sub">Generate bills for completed 100% payments</div>
                    </div>
                    <a href="javascript:window.location.reload();" class="action-btn">Generate</a>
                </li>
                <li class="acc-action-item">
                    <div class="action-icon"><i class="fas fa-university"></i></div>
                    <div class="action-text">
                        <div class="action-lbl">Bank Disbursements</div>
                        <div class="action-sub">Track approved payouts to bank</div>
                    </div>
                    <a href="javascript:window.location.reload();" class="action-btn">Track</a>
                </li>
                <li class="acc-action-item">
                    <div class="action-icon"><i class="fas fa-handshake"></i></div>
                    <div class="action-text">
                        <div class="action-lbl">Dealer Payout Center</div>
                        <div class="action-sub">Process commission withdrawal requests</div>
                    </div>
                    <a href="javascript:window.location.reload();" class="action-btn">Process</a>
                </li>
            </ul>
        </div>
        
    </div>

</div>
@endsection
