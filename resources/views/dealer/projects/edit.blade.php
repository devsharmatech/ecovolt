@extends('admin.layouts.master')
@section('title', 'Edit Project — ' . $project->project_code)

<style>
.edit-wrap { padding: 32px; background: #f0f4f8; min-height: 100vh; }
.edit-card { background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; overflow: hidden; }

/* Header */
.edit-head { background: linear-gradient(135deg, #14532d, #15803d); padding: 36px 44px; display: flex; justify-content: space-between; align-items: center; }
.edit-head h2 { color: #fff; margin: 0; font-weight: 900; font-size: 1.6rem; }
.edit-head p { color: rgba(255,255,255,.7); margin: 6px 0 0; }
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

/* Payment Mode */
.pay-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.pay-option { border: 2px solid #e2e8f0; border-radius: 16px; padding: 20px; cursor: pointer; transition: .2s; }
.pay-option input[type=radio] { display: none; }
.pay-option:has(input:checked) { border-color: #166534; background: #f0fdf4; }
.pay-option .pay-label { font-weight: 800; color: #1e293b; }

/* Amount fields */
.amount-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

/* Submit */
.save-btn { background: #166534; color: #fff; border: none; padding: 16px 60px; border-radius: 16px; font-weight: 800; font-size: 1rem; cursor: pointer; transition: .2s; }
.save-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(22,101,52,0.3); }
</style>

@section('content')
<div class="edit-wrap">
    <div class="edit-card">
        <!-- Header -->
        <div class="edit-head">
            <div>
                <h2><i class="fas fa-edit" style="margin-right:14px; opacity:.9;"></i>Edit Project: {{ $project->project_code }}</h2>
                <p>Modify technical specs, registration details or financial overview.</p>
            </div>
            <a href="{{ route(auth()->user()->getRoleNames()->first().'.projects.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>

        <!-- Form Body -->
        <div class="form-body">
            <form action="{{ route(auth()->user()->getRoleNames()->first().'.projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- ① Identity -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-user-circle"></i> Customer Identity</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Customer Name</label>
                            <input type="text" name="customer_name" class="f-input" value="{{ old('customer_name', $project->customer_name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Linked Lead</label>
                            <select name="lead_id" class="f-select" required>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ $project->lead_id == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->lead_code }} — {{ $lead->first_name }} {{ $lead->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ② Technical Spec -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-tools"></i> Technical Specifications</div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="f-label">System Type</label>
                            <select name="system_type" class="f-select">
                                <option value="on-grid" {{ $project->system_type == 'on-grid' ? 'selected' : '' }}>On-Grid</option>
                                <option value="off-grid" {{ $project->system_type == 'off-grid' ? 'selected' : '' }}>Off-Grid</option>
                                <option value="hybrid" {{ $project->system_type == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="f-label">KW Capacity</label>
                            <input type="number" step="0.1" name="kw_capacity" class="f-input" value="{{ old('kw_capacity', $project->kw_capacity) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="f-label">Project Status</label>
                            <select name="status" class="f-select">
                                <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="on_hold" {{ $project->status == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ③ Registration Details -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-id-card"></i> Registration Info</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Suryaghar App No.</label>
                            <input type="text" name="suryaghar_app_no" class="f-input" value="{{ old('suryaghar_app_no', $project->suryaghar_app_no) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">DISCOM Name</label>
                            <input type="text" name="discom_name" class="f-input" value="{{ old('discom_name', $project->discom_name) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Consumer No.</label>
                            <input type="text" name="consumer_no" class="f-input" value="{{ old('consumer_no', $project->consumer_no) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="f-label">Meter No.</label>
                            <input type="text" name="meter_no" class="f-input" value="{{ old('meter_no', $project->meter_no) }}">
                        </div>
                    </div>
                </div>

                <!-- ④ Financials -->
                <div class="form-section">
                    <div class="section-title"><i class="fas fa-rupee-sign"></i> Financials</div>
                    <div class="amount-grid">
                        <div>
                            <label class="f-label">Total Amount</label>
                            <input type="number" name="total_amount" class="f-input" value="{{ old('total_amount', $project->total_amount) }}">
                        </div>
                        <div>
                            <label class="f-label">Part Payment Received</label>
                            <input type="number" name="part_payment_amount" class="f-input" value="{{ old('part_payment_amount', $project->part_payment_amount) }}">
                        </div>
                        <div>
                            <label class="f-label">Subsidy Amount</label>
                            <input type="number" name="subsidy_amount" class="f-input" value="{{ old('subsidy_amount', $project->subsidy_amount) }}">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="section-title"><i class="fas fa-sticky-note"></i> Internal Notes</div>
                    <textarea name="notes" class="f-textarea">{{ old('notes', $project->notes) }}</textarea>
                </div>

                <div style="text-align: center; margin-top: 50px;">
                    <button type="submit" class="save-btn"><i class="fas fa-save"></i> Save All Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
