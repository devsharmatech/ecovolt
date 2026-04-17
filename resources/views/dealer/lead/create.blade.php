@extends('admin.layouts.master')

<style>
.lead-form-wrap { padding: 32px; background: #fdfdfd; border-radius: 24px; margin-top: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.02); }
.form-card { border: 1px solid #f1f5f9; border-radius: 20px; overflow: hidden; background: #fff; }
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

.solar-btn {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: #fff; border: none; padding: 18px 40px; border-radius: 16px; 
    font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: .3s;
    box-shadow: 0 10px 20px rgba(39, 174, 96, 0.2);
}
.solar-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(39, 174, 96, 0.3); }

.solar-btn-outline {
    background: transparent; color: #15803d; border: 2px solid #16a34a;
    padding: 18px 40px; border-radius: 16px; font-weight: 800; text-decoration: none;
}
</style>

@section('content')
<div class="lead-form-wrap">
    <div class="form-card">
        <div class="form-head">
            <h3 style="margin: 0; font-weight: 800; color: #fff;"><i class="fas fa-plus-circle"></i> Create Solar Lead</h3>
            <p style="margin: 8px 0 0; opacity: 0.85;">Entering a new solar project into the EcoVolt pipeline.</p>
        </div>
        <div class="form-body">
            <form action="{{ route(auth()->user()->getRoleNames()->first() . '.leads.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-input" placeholder="e.g. Rahul" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-input" placeholder="e.g. Sharma" required>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-input" placeholder="e.g. 98765 43210" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-input" placeholder="e.g. rahul@example.com">
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div style="margin: 30px 0 20px; padding: 12px 20px; background: #f8fafc; border-radius: 12px; border-left: 4px solid #16a34a;">
                            <span style="font-size: .8rem; font-weight: 800; color: #1e293b; text-transform: uppercase; letter-spacing: 1px;">
                                <i class="fas fa-id-card me-2"></i> Solar Project Configuration & Assignment
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Dealer Assignment (ID Mandatory)</label>
                            @if(auth()->user()->getRoleNames()->first() == 'admin')
                                <select name="dealer_id" class="form-input" required>
                                    <option value="">-- Select Partner Dealer (Mandatory) --</option>
                                    @foreach($dealers as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->user_code ?? 'ELV-DLR-0'.$d->id }})</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="form-input" style="background: #f8fafc; color: #64748b; pointer-events: none;">
                                    <i class="fas fa-check-circle text-success me-2"></i> {{ auth()->user()->name }} ({{ auth()->user()->user_code ?? 'ELV-DLR-0'.auth()->user()->id }})
                                </div>
                                <input type="hidden" name="dealer_id" value="{{ auth()->user()->id }}">
                            @endif
                            <small style="color: #94a3b8; font-weight: 600; margin-top: 6px; display: block;">All leads must be linked to a verified Dealer ID for commission tracking.</small>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Solar System Type</label>
                            <select name="system_type" class="form-input">
                                <option value="On-grid">On-grid (Eco Power)</option>
                                <option value="Hybrid">Hybrid (Storage + Grid)</option>
                                <option value="Off-grid">Off-grid (Independent)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Required Capacity (kW)</label>
                            <input type="number" name="kw_capacity" step="0.5" class="form-input" placeholder="e.g. 5.0" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">City / Location</label>
                            <input type="text" name="city" class="form-input" placeholder="e.g. New Delhi" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label">Full Address</label>
                            <textarea name="full_address" class="form-input" style="height: 52px;" placeholder="Complete building/site details..."></textarea>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; gap: 20px; align-items: center;">
                    <button type="submit" class="solar-btn">Generate Lead ID & Create</button>
                    <a href="{{ route(auth()->user()->getRoleNames()->first() . '.leads.index') }}" class="solar-btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
