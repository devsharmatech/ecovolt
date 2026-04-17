@extends('admin.layouts.master')
@section('title', 'New Solar Project')

<style>
.create-wrap { padding: 32px; background: #f0f4f8; min-height: 100vh; }
.create-card { background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden; }

/* Header */
.create-head { background: linear-gradient(135deg, #14532d, #15803d); padding: 36px 44px; display: flex; justify-content: space-between; align-items: center; }
.create-head h2 { color: #fff; margin: 0; font-weight: 900; font-size: 1.6rem; }
.create-head p { color: rgba(255,255,255,.7); margin: 6px 0 0; }
.back-link { color: rgba(255,255,255,.9); font-weight: 700; text-decoration: none; background: rgba(255,255,255,.15); padding: 10px 20px; border-radius: 10px; }

/* Sections */
.form-body { padding: 44px; }
.form-section { margin-bottom: 40px; }
.section-title {
    font-size: .7rem; font-weight: 900; color: #94a3b8;
    text-transform: uppercase; letter-spacing: 1.5px;
    margin-bottom: 22px; padding-bottom: 12px;
    border-bottom: 2px solid #f1f5f9;
    display: flex; align-items: center; gap: 8px;
}
.section-title i { color: #166534; font-size: .9rem; }

/* Fields */
.f-label { font-size: .8rem; font-weight: 800; color: #475569; margin-bottom: 8px; display: block; }
.f-label span.req { color: #ef4444; margin-left: 3px; }
.f-input, .f-select, .f-textarea {
    width: 100%; padding: 13px 18px;
    border: 1.5px solid #e2e8f0; border-radius: 12px;
    font-size: .9rem; font-weight: 600; color: #1e293b;
    outline: none; transition: .2s;
    background: #fdfdfd;
}
.f-input:focus, .f-select:focus, .f-textarea:focus {
    border-color: #166534;
    box-shadow: 0 0 0 3px rgba(22,101,52,0.1);
    background: #fff;
}
.f-textarea { min-height: 100px; resize: vertical; }

/* Payment Mode Cards */
.pay-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.pay-option { border: 2px solid #e2e8f0; border-radius: 16px; padding: 20px; cursor: pointer; transition: .2s; }
.pay-option input[type=radio] { display: none; }
.pay-option:has(input:checked) { border-color: #166534; background: #f0fdf4; }
.pay-option .pay-icon { font-size: 1.8rem; margin-bottom: 8px; }
.pay-option .pay-label { font-weight: 800; color: #1e293b; font-size: .95rem; }
.pay-option .pay-desc { font-size: .75rem; color: #64748b; margin-top: 4px; }

/* Stage Radio Group */
.stage-pills { display: flex; flex-wrap: wrap; gap: 10px; }
.stage-pill { border: 1.5px solid #e2e8f0; border-radius: 20px; padding: 8px 18px; cursor: pointer; font-size: .78rem; font-weight: 700; color: #475569; transition: .2s; }
.stage-pill input[type=radio] { display: none; }
.stage-pill:has(input:checked) { border-color: #166534; background: #f0fdf4; color: #166534; }

/* Amount fields */
.amount-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

/* Submit */
.submit-row { display: flex; justify-content: center; gap: 16px; margin-top: 48px; padding-top: 32px; border-top: 2px solid #f1f5f9; }
.submit-btn { background: #166534; color: #fff; border: none; padding: 16px 60px; border-radius: 16px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: .2s; }
.submit-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(22,101,52,0.3); }
.reset-btn { background: #f1f5f9; color: #475569; border: none; padding: 16px 40px; border-radius: 16px; font-weight: 700; cursor: pointer; }

.info-box { background: #eff6ff; border: 1.5px solid #bfdbfe; border-radius: 12px; padding: 14px 18px; font-size: .82rem; color: #1d4ed8; font-weight: 600; margin-bottom: 24px; }
</style>

@section('content')
<div class="create-wrap">

    @if($errors->any())
        <div style="background:#fee2e2; border: 1.5px solid #fca5a5; color:#dc2626; padding:16px 20px; border-radius:14px; margin-bottom:24px; font-weight:700;">
            <i class="fas fa-exclamation-triangle"></i> Please fix the following:
            <ul style="margin:10px 0 0; padding-left:20px;">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="create-card">
        <!-- Header -->
        <div class="create-head">
            <div>
                <h2><i class="fas fa-rocket" style="margin-right:14px; opacity:.9;"></i>Initialize Solar Project</h2>
                <p>Set up the complete project pipeline with all required details.</p>
            </div>
            <a href="{{ route(auth()->user()->getRoleNames()->first().'.projects.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
        </div>

        <!-- Form Body -->
        <div class="form-body">
            <form action="{{ route(auth()->user()->getRoleNames()->first().'.projects.store') }}" method="POST">
                @csrf

                <!-- ① Lead & Customer Info -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-user-tie"></i> Customer & Lead Identity</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Linked Lead <span class="req">*</span></label>
                            <select name="lead_id" class="f-select" required>
                                <option value="">-- Select a Lead --</option>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->lead_code }} — {{ $lead->first_name }} {{ $lead->last_name }} ({{ $lead->city }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Customer Full Name <span class="req">*</span></label>
                            <input type="text" name="customer_name" class="f-input" value="{{ old('customer_name') }}" placeholder="As per KYC / Aadhaar" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="f-label">System Type</label>
                            <select name="system_type" class="f-select">
                                <option value="">-- Select --</option>
                                <option value="on-grid">On-Grid</option>
                                <option value="off-grid">Off-Grid</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="f-label">System Capacity (kW)</label>
                            <input type="number" step="0.1" name="kw_capacity" class="f-input" value="{{ old('kw_capacity') }}" placeholder="e.g. 5.5">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="f-label">Installation Address</label>
                            <input type="text" name="address" class="f-input" value="{{ old('address') }}" placeholder="Site / Property address">
                        </div>
                    </div>
                </div>

                <!-- ② Payment Mode -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-credit-card"></i> Payment Mode Selection</div>
                    <div class="info-box"><i class="fas fa-info-circle"></i> &nbsp;You can update the payment mode later when the project reaches the Payment Selection stage.</div>
                    <div class="pay-grid">
                        <label class="pay-option">
                            <input type="radio" name="payment_mode" value="cash" {{ old('payment_mode','cash')=='cash' ? 'checked' : '' }}>
                            <div class="pay-icon">💵</div>
                            <div class="pay-label">Cash Payment</div>
                            <div class="pay-desc">Customer pays directly. No bank loan required.</div>
                        </label>
                        <label class="pay-option">
                            <input type="radio" name="payment_mode" value="bank" {{ old('payment_mode')=='bank' ? 'checked' : '' }}>
                            <div class="pay-icon">🏦</div>
                            <div class="pay-label">Bank Finance</div>
                            <div class="pay-desc">Loan via bank. Includes Bank Login & Disbursement stages.</div>
                        </label>
                    </div>
                </div>

                <!-- ③ Starting Stage -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-flag"></i> Starting Pipeline Stage</div>
                    <div class="stage-pills">
                        @foreach(['kyc_complete' => 'KYC Complete', 'geo_tag_upload' => 'Geo-tag Upload', 'pm_suryaghar_registration' => 'PM Suryaghar Reg.', 'payment_mode_selection' => 'Payment Selection', 'net_metering' => 'Net Metering'] as $val => $lbl)
                        <label class="stage-pill">
                            <input type="radio" name="start_stage" value="{{ $val }}" {{ old('start_stage','kyc_complete') == $val ? 'checked' : '' }}>
                            {{ $lbl }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- ④ Financial Details -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-rupee-sign"></i> Financial Overview</div>
                    <div class="amount-grid">
                        <div>
                            <label class="f-label">Total Project Amount (₹)</label>
                            <input type="number" name="total_amount" class="f-input" value="{{ old('total_amount') }}" placeholder="e.g. 150000">
                        </div>
                        <div>
                            <label class="f-label">Expected Subsidy (₹)</label>
                            <input type="number" name="subsidy_amount" class="f-input" value="{{ old('subsidy_amount') }}" placeholder="e.g. 78000">
                        </div>
                        <div>
                            <label class="f-label">Part Payment (₹)</label>
                            <input type="number" name="part_payment_amount" class="f-input" value="{{ old('part_payment_amount') }}" placeholder="e.g. 30000">
                        </div>
                    </div>
                </div>

                <!-- ⑤ PM Suryaghar Details -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-sun"></i> PM Suryaghar Registration Info</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="f-label">PM Suryaghar Application No.</label>
                            <input type="text" name="suryaghar_app_no" class="f-input" value="{{ old('suryaghar_app_no') }}" placeholder="e.g. SURYA-2026-XXXXX">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">DISCOM / Electricity Board</label>
                            <input type="text" name="discom_name" class="f-input" value="{{ old('discom_name') }}" placeholder="e.g. JVVNL, TPDDL...">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Consumer Number</label>
                            <input type="text" name="consumer_no" class="f-input" value="{{ old('consumer_no') }}" placeholder="Electricity consumer number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Meter Number</label>
                            <input type="text" name="meter_no" class="f-input" value="{{ old('meter_no') }}" placeholder="Existing meter number">
                        </div>
                    </div>
                </div>

                <!-- ⑥ Status & Notes -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-sticky-note"></i> Status & Remarks</div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="f-label">Project Status</label>
                            <select name="status" class="f-select">
                                <option value="active" {{ old('status','active')=='active' ? 'selected' : '' }}>Active</option>
                                <option value="on_hold" {{ old('status')=='on_hold' ? 'selected' : '' }}>On Hold</option>
                            </select>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="f-label">Notes / Special Instructions</label>
                            <textarea name="notes" class="f-textarea" placeholder="Any special instructions, roof type, shading details, etc...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="submit-row">
                    <button type="reset" class="reset-btn"><i class="fas fa-undo"></i> Reset</button>
                    <button type="submit" class="submit-btn"><i class="fas fa-rocket"></i> Launch Project Pipeline</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
