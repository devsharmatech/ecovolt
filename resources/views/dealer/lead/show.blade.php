@extends('admin.layouts.master')

<style>
.show-wrap { padding: 32px; }
.show-header {
    background: linear-gradient(135deg, #166534, #15803d);
    border-radius: 20px; padding: 32px; margin-bottom: 24px;
    display: flex; align-items: center; justify-content: space-between; color: #fff;
}
.show-id { background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 12px; font-weight: 800; border: 1px solid rgba(255,255,255,0.3); }

.detail-card { background: #fff; border-radius: 24px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; }
.section-title { font-size: .8rem; font-weight: 800; color: #166534; text-transform: uppercase; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.label { font-size: .75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px; }
.value { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 24px; }

.status-step { display: flex; gap: 15px; margin-bottom: 12px; padding: 15px; border-radius: 16px; background: #f8fafc; border: 1px solid #f1f5f9; }
.step-icon { width: 40px; height: 40px; border-radius: 10px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 1rem; }
.step-active { background: #16a34a; color: #fff; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.2); }
</style>

@section('content')
<div class="show-wrap">
    <div class="show-header">
        <div>
            <h2 style="margin: 0; font-weight: 800; color: #fff;">{{ $lead->full_name }}</h2>
            <p style="margin: 5px 0 0; opacity: 0.9;">Solar Project Inquiry Details</p>
        </div>
        <div class="show-id">{{ $lead->lead_code }}</div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="section-title"><i class="fas fa-info-circle"></i> Basic Information</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="label">Primary Contact</div>
                        <div class="value">{{ $lead->phone }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="label">Email Address</div>
                        <div class="value">{{ $lead->email ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="label">Requested Capacity</div>
                        <div class="value" style="color:#166534">{{ $lead->kw_capacity }} kW - {{ $lead->system_type }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="label">Service Location</div>
                        <div class="value">{{ $lead->city }}, {{ $lead->state ?? 'Pan-India' }}</div>
                    </div>
                </div>

                <div class="section-title" style="margin-top: 20px;"><i class="fas fa-map-marked-alt"></i> Installation Address</div>
                <p style="color: #475569; font-weight: 500;">{{ $lead->full_address ?? 'No detailed address provided yet.' }}</p>
                
                @if($lead->geo_latitude)
                    <div style="margin-top: 20px; padding: 15px; border-radius: 12px; background: #ecfdf5; border: 1.5px solid #dcfce7; display: flex; align-items: center; gap:12px;">
                        <i class="fas fa-satellite" style="color: #10b981; font-size: 1.4rem;"></i>
                        <div>
                            <div style="font-size: .8rem; font-weight: 800; color: #065f46;">GEO-TAGGED LOCATION</div>
                            <div style="font-size: .75rem; font-weight: 600; color: #059669;">Lat: {{ $lead->geo_latitude }}, Long: {{ $lead->geo_longitude }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="detail-card">
                <div class="section-title"><i class="fas fa-tasks"></i> Workflow Stage</div>
                
                <div class="status-step">
                    <div class="step-icon {{ $lead->stage == 'Entry' ? 'step-active' : '' }}"><i class="fas fa-plus"></i></div>
                    <div><h6 style="margin:0">Entry Done</h6><p style="margin:0; font-size:.7rem">Lead was entered into system.</p></div>
                </div>

                <div class="status-step">
                    <div class="step-icon {{ $lead->stage == 'Assigned' ? 'step-active' : '' }}"><i class="fas fa-user-check"></i></div>
                    <div><h6 style="margin:0">Assigned</h6><p style="margin:0; font-size:.7rem">Waiting for employee pick.</p></div>
                </div>

                <div class="status-step">
                    <div class="step-icon {{ $lead->stage == 'Qualified' ? 'step-active' : '' }}"><i class="fas fa-check-double"></i></div>
                    <div><h6 style="margin:0">Qualified</h6><p style="margin:0; font-size:.7rem">Requirements verified.</p></div>
                </div>

                <div style="margin-top: 32px;">
                    <a href="{{ route(auth()->user()->getRoleNames()->first() . '.leads.edit', $lead->id) }}" style="width: 100%; display: block; text-align: center; padding: 15px; border-radius: 14px; background: #166534; color: #fff; font-weight: 800; text-decoration: none;">Move to Next Stage</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
