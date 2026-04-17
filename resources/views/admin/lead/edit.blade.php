@extends('admin.layouts.master')

<style>
.edit-wrap { padding: 32px; }
.form-card { border: 1px solid #f1f5f9; border-radius: 20px; overflow: hidden; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
.form-head { background: linear-gradient(135deg, #166534, #15803d); padding: 24px 32px; color: #fff; }
.form-body { padding: 40px; }

.form-group { margin-bottom: 24px; }
.form-label { display: block; font-size: .78rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 10px; }
.form-input { 
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: 14px; 
    padding: 14px 18px; font-size: .95rem; font-weight: 600; color: #1e293b;
    outline: none; transition: .2s;
}
.form-input:focus { border-color: #27ae60; box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.1); }

.solar-btn { background: #166534; color: #fff; border: none; padding: 18px 40px; border-radius: 16px; font-weight: 800; font-size: 1.1rem; cursor: pointer; }
</style>

@section('content')
<div class="edit-wrap">
    <div class="form-card">
        <div class="form-head">
            <h3 style="margin: 0; font-weight: 800; color: #fff;"><i class="fas fa-edit"></i> Edit Solar Lead : {{ $lead->lead_code }}</h3>
            <p style="margin: 8px 0 0; opacity: 0.85;">Update information or progress lead to next stage.</p>
        </div>
        <div class="form-body">
            <form action="{{ route(auth()->user()->getRoleNames()->first() . '.leads.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-input" value="{{ $lead->first_name }}" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-input" value="{{ $lead->last_name }}" required>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Dealer Assignment</label>
                            @if(auth()->user()->getRoleNames()->first() == 'admin')
                                <select name="dealer_id" class="form-input" required>
                                    @foreach($dealers as $d)
                                        <option value="{{ $d->id }}" {{ $lead->dealer_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="form-input" style="background: #f8fafc; color: #64748b; pointer-events: none;">
                                    {{ $lead->dealer_id ? \App\Models\User::find($lead->dealer_id)->name : 'Not Assigned' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">System Type</label>
                            <select name="system_type" class="form-input">
                                <option value="On-grid" {{ $lead->system_type == 'On-grid' ? 'selected' : '' }}>On-grid</option>
                                <option value="Hybrid" {{ $lead->system_type == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="Off-grid" {{ $lead->system_type == 'Off-grid' ? 'selected' : '' }}>Off-grid</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Capacity (kW)</label>
                            <input type="number" name="kw_capacity" step="0.5" class="form-input" value="{{ $lead->kw_capacity }}" required>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Workflow Stage</label>
                            <select name="stage" id="stageSelect" class="form-input" style="background:#fffbeb; border-color:#fef3c7;">
                                <option value="Entry" {{ $lead->stage == 'Entry' ? 'selected' : '' }}>Entry (Initial)</option>
                                <option value="Assigned" {{ $lead->stage == 'Assigned' ? 'selected' : '' }}>Assigned (In Work)</option>
                                <option value="Qualified" {{ $lead->stage == 'Qualified' ? 'selected' : '' }}>Qualified (Verified)</option>
                                <option value="Survey" {{ $lead->stage == 'Survey' ? 'selected' : '' }}>Survey (Geo-tagged)</option>
                                <option value="Quotation" {{ $lead->stage == 'Quotation' ? 'selected' : '' }}>Quotation Phase</option>
                                <option value="Booking" {{ $lead->stage == 'Booking' ? 'selected' : '' }}>Booking Done (70% Paid)</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12" id="bookingFields" style="display: {{ $lead->stage == 'Booking' ? 'block' : 'none' }};">
                        <div class="form-group" style="background: #f0fdf4; padding: 20px; border-radius: 16px; border: 1.5px dashed #22c55e;">
                            <label class="form-label" style="color:#166534;">Booking Amount (70%) <span style="font-size: .6rem; color: #15803d;">(Project will be created automatically)</span></label>
                            <input type="number" name="booking_amount" class="form-input" value="{{ $lead->booking_amount }}" placeholder="Enter 70% booking amount">
                            
                            <label class="form-label mt-3" style="color:#166534;">Total Project Valuation</label>
                            <input type="number" name="total_amount" class="form-input" value="{{ $lead->total_amount }}" placeholder="Total deal value">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Detailed Address</label>
                            <textarea name="full_address" class="form-input" style="height: 100px;">{{ $lead->full_address }}</textarea>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; gap: 20px;">
                    <button type="submit" class="solar-btn">Update Lead Information</button>
                    <a href="{{ route(auth()->user()->getRoleNames()->first() . '.leads.index') }}" style="padding:18px 40px; border-radius:16px; color:#64748b; font-weight:800; text-decoration:none; background:#f1f5f9;">Back to List</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.getElementById('stageSelect').addEventListener('change', function() {
    document.getElementById('bookingFields').style.display = (this.value === 'Booking') ? 'block' : 'none';
});
</script>
@endsection
