@extends('admin.layouts.master')

<style>
.accounts-wrap { padding: 32px; }
.acc-header {
    background: linear-gradient(135deg, #00a246ff, #05ae35ff);
    border-radius: 20px; padding: 28px 36px; margin-bottom: 32px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2); color: #fff;
}
.financial-stats { display: flex; gap: 30px; }
.stat-item { background: rgba(255,255,255,0.15); padding: 12px 24px; border-radius: 14px; border: 1px solid rgba(255,255,255,0.2); }

.pay-table-card { background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #f1f5f9; }
.pay-table th { background: #f8fafc; padding: 18px 24px; font-size: .75rem; font-weight: 700; color: #64748b; text-transform: uppercase; border-bottom: 1px solid #f1f5f9; text-align: left; }
.pay-table td { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; font-size: .9rem; color: #1e293b; }

.amt-badge { font-weight: 800; color: #166534; font-size: 1rem; }
.status-pill { padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: .7rem; text-transform: uppercase; }
.pill-pending { background: #fffbeb; color: #854d0e; border: 1px solid #fef3c7; }
.pill-success { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
</style>

@section('content')
<div class="accounts-wrap">
    <div class="acc-header">
        <div>
            <h2 style="margin: 0; font-weight: 800; color: #fff;"> Accounts & Collections</h2>
            <p style="margin: 5px 0 0; opacity: 0.85;">Tracking the financial flow based on 70/30 Payment Rules.</p>
        </div>
        <div class="financial-stats">
            <div class="stat-item">
                <div style="font-size: .7rem; font-weight: 700; opacity: 0.8;">TOTAL COLLECTIONS</div>
                <div style="font-size: 1.2rem; font-weight: 800;">₹ 12,45,000</div>
            </div>
            <div class="stat-item">
                <div style="font-size: .7rem; font-weight: 700; opacity: 0.8;">PENDING (30%)</div>
                <div style="font-size: 1.2rem; font-weight: 800;">₹ 3,75,000</div>
            </div>
        </div>
    </div>

    <div class="pay-table-card">
        <table class="pay-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Customer / Lead</th>
                    <th>Amount Type</th>
                    <th>Method</th>
                    <th>Total Value</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                <tr>
                    <td><span style="font-weight: 800; color:#3b82f6;">PAY-{{ str_pad($pay->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                    <td>
                        <div style="font-weight: 800;">{{ $pay->customer_name }}</div>
                        <div style="font-size: .75rem; color:#64748b;">Trx: {{ $pay->transaction_id ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 700;">{{ $pay->amount_type ?? 'Booking (70%)' }}</div>
                        <div style="font-size: .75rem; color:#16a34a;">Rules Applied</div>
                    </td>
                    <td><i class="fas fa-university"></i> {{ $pay->payment_method }}</td>
                    <td class="amt-badge">₹ {{ number_format($pay->amount, 2) }}</td>
                    <td>
                        <span class="status-pill {{ $pay->payment_status == 'Received' ? 'pill-success' : 'pill-pending' }}">
                            {{ $pay->payment_status }}
                        </span>
                    </td>
                    <td>{{ $pay->created_at->format('d M, Y') }}</td>
                    <td>
                        <form action="{{ route(auth()->user()->getRoleNames()->first() . '.accounts.destroy', $pay->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 48px; color: #94a3b8;">No payments recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
