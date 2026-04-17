@extends('admin.layouts.master')

<style>
.pay-wrap { padding: 24px; }
.pay-header {
    background: linear-gradient(135deg, #166534, #15803d);
    border-radius: 16px; padding: 24px 32px; margin-bottom: 28px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 4px 20px rgba(21, 128, 61, 0.2);
}
.pay-header h2 { font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0; }
.pay-header p { font-size: .88rem; color: rgba(255,255,255,0.85); margin: 4px 0 0; }

.pay-card {
    background: #fff; border-radius: 20px; overflow: hidden;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;
}
.pay-card-head {
    padding: 24px; background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 16px;
}
.pay-card-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #fff;
    background: linear-gradient(135deg, #2ecc71, #27ae60);
}
.pay-card-body { padding: 32px; }

.split-pill {
    background: #f0fdf4; border: 1.5px solid #dcfce7;
    border-radius: 16px; padding: 24px; margin-top: 24px;
    display: flex; gap: 20px; align-items: center;
}
.perc-bubble {
    width: 70px; height: 70px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; font-weight: 800; color: #fff;
    background: #16a34a; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2);
}

.pay-input {
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px;
    padding: 12px 16px; font-size: 1.1rem; font-weight: 700; color: #1e293b;
    outline: none;
}
.pay-input:focus { border-color: #27ae60; }
</style>

@section('content')
<div class="pay-wrap">
    <div class="pay-header">
        <div>
            <h2><i class="fas fa-wallet" style="margin-right: 12px;"></i>Payment Structure</h2>
            <p>Define the financial split between Booking and Commissioning.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="pay-card">
                <div class="pay-card-head">
                    <div class="pay-card-icon"><i class="fas fa-percentage"></i></div>
                    <h5>Modify Payment Split</h5>
                </div>
                <div class="pay-card-body">
                    <form action="{{ route(auth()->user()->getRoleNames()->first() . '.payments.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <label style="font-size: .7rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:8px; display:block;">Booking (%)</label>
                                <input type="number" name="booking_perc" class="pay-input" value="{{ $setting->booking_perc }}" required>
                            </div>
                            <div class="col-6">
                                <label style="font-size: .7rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:8px; display:block;">Commissioning (%)</label>
                                <input type="number" name="commissioning_perc" class="pay-input" value="{{ $setting->commissioning_perc }}" required>
                            </div>
                        </div>
                        <button type="submit" style="margin-top: 24px; width: 100%; border: none; padding: 14px; border-radius: 12px; background: linear-gradient(135deg, #2ecc71, #27ae60); color: #fff; font-weight: 800;">Update Payment Structure</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="pay-card">
                <div class="pay-card-head">
                    <div class="pay-card-icon" style="background:#f59e0b;"><i class="fas fa-eye"></i></div>
                    <h5>Visual Split Preview</h5>
                </div>
                <div class="pay-card-body">
                    <div class="split-pill">
                        <div class="perc-bubble">{{ (int)$setting->booking_perc }}%</div>
                        <div>
                            <h6 style="margin: 0; font-weight: 800; color: #166534;">Booking Amount</h6>
                            <p style="margin: 0; font-size: .82rem; color: #15803d;">Collected initial booking phase.</p>
                        </div>
                    </div>
                    <div class="split-pill" style="background:#fff7ed; border-color:#ffedd5;">
                        <div class="perc-bubble" style="background:#f59e0b;">{{ (int)$setting->commissioning_perc }}%</div>
                        <div>
                            <h6 style="margin: 0; font-weight: 800; color: #9a3412;">Commissioning Amount</h6>
                            <p style="margin: 0; font-size: .82rem; color: #c2410c;">Collected on project completion.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
