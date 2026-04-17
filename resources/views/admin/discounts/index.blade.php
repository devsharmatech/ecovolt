@extends('admin.layouts.master')

<style>
.disc-wrap { padding: 24px; }
.disc-header {
    background: linear-gradient(135deg, #166534, #15803d);
    border-radius: 16px; padding: 24px 32px; margin-bottom: 28px;
    display: flex; align-items: center; justify-content: space-between;
}
.disc-header h2 { font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0; }
.disc-header p { font-size: .88rem; color: rgba(255,255,255,0.85); margin: 4px 0 0; }

.disc-card { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 2px 14px rgba(0,0,0,0.06); border: 1px solid #f1f5f9; }
.disc-card-body { padding: 32px; }

.tier-item {
    display: flex; align-items: center; gap: 20px; padding: 20px;
    border-radius: 16px; background: #f8fafc; margin-bottom: 16px;
    transition: transform .2s;
}
.tier-item:hover { transform: translateX(5px); background: #f1f5f9; }
.tier-icon {
    width: 50px; height: 50px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #fff;
    background: #16a34a;
}
.tier-info { flex: 1; }
.tier-info h6 { margin: 0; font-weight: 800; color: #334155; }
.tier-info p { margin: 0; font-size: .75rem; color: #64748b; }

.disc-input {
    width: 100px; border: 1.5px solid #e2e8f0; border-radius: 10px;
    padding: 10px 14px; font-size: 1.1rem; font-weight: 700; color: #1e293b;
    outline: none; text-align: center;
}
.disc-input:focus { border-color: #27ae60; }

.margin-box {
    background: #fef2f2; border: 1.5px solid #fee2e2;
    border-radius: 16px; padding: 24px; margin-top: 10px;
    text-align: center;
}
</style>

@section('content')
<div class="disc-wrap">
    <div class="disc-header">
        <div>
            <h2><i class="fas fa-user-check" style="margin-right: 12px;"></i>Discount & Approval Tiers</h2>
            <p>Define discount limits and mandatory margin floors for solar projects.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route(auth()->user()->getRoleNames()->first() . '.discounts.update') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-7">
                <div class="disc-card">
                    <div class="disc-card-body">
                        <h5 style="margin-bottom: 24px; font-weight: 800; color: #166534;">Approval Hierarchy</h5>
                        
                        <div class="tier-item">
                            <div class="tier-icon" style="background:#64748b;"><i class="fas fa-user"></i></div>
                            <div class="tier-info">
                                <h6>Employee Level</h6>
                                <p>Standard discount power.</p>
                            </div>
                            <input type="number" name="employee_limit" class="disc-input" value="{{ $setting->employee_limit }}" step="0.1">
                            <span style="font-weight: 800; color: #64748b;">%</span>
                        </div>

                        <div class="tier-item">
                            <div class="tier-icon"><i class="fas fa-user-tie"></i></div>
                            <div class="tier-info">
                                <h6>Manager Level</h6>
                                <p>Approval required above Employee limit.</p>
                            </div>
                            <input type="number" name="manager_limit" class="disc-input" value="{{ $setting->manager_limit }}" step="0.1">
                            <span style="font-weight: 800; color: #16a34a;">%</span>
                        </div>

                        <div class="tier-item">
                            <div class="tier-icon" style="background:#1e40af;"><i class="fas fa-id-badge"></i></div>
                            <div class="tier-info">
                                <h6>COO Level</h6>
                                <p>High-level discount approval tier.</p>
                            </div>
                            <input type="number" name="coo_limit" class="disc-input" value="{{ $setting->coo_limit }}" step="0.1">
                            <span style="font-weight: 800; color: #1e40af;">%</span>
                        </div>

                        <div class="tier-item">
                            <div class="tier-icon" style="background:#7c3aed;"><i class="fas fa-crown"></i></div>
                            <div class="tier-info">
                                <h6>MD Level</h6>
                                <p>Unlimited/Maximum override power.</p>
                            </div>
                            <div style="font-weight: 800; color: #7c3aed;">Above 10%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="disc-card">
                    <div class="disc-card-body">
                        <h5 style="margin-bottom: 12px; font-weight: 800; color: #dc2626;">Safety Controls</h5>
                        <p style="font-size: .88rem; color: #64748b;">Protect the company margin with a hard stop floor.</p>

                        <div class="margin-box">
                            <label style="font-size: .75rem; font-weight: 700; color: #ef4444; text-transform: uppercase;">Minimum Margin Floor</label>
                            <div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 10px;">
                                <input type="number" name="margin_floor" class="disc-input" 
                                       style="width: 140px; font-size: 1.8rem; height: 60px; border-color:#fee2e2;" 
                                       value="{{ $setting->margin_floor }}" step="0.1">
                                <span style="font-size: 1.8rem; font-weight: 800; color: #dc2626;">%</span>
                            </div>
                            <div style="margin-top: 16px; font-size: .78rem; color: #991b1b; padding: 10px; background: rgba(239,68,68,0.05); border-radius: 8px;">
                                <i class="fas fa-exclamation-triangle"></i> Deals below this margin will be blocked by the system automatically.
                            </div>
                        </div>

                        <button type="submit" style="margin-top: 32px; width: 100%; border: none; padding: 16px; border-radius: 12px; background: linear-gradient(135deg, #2ecc71, #27ae60); color: #fff; font-weight: 800; font-size: 1rem;">Save All Rules</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
