@extends('admin.layouts.master')

<style>
.lead-wrap { padding: 24px; }
.lead-header {
    background: linear-gradient(135deg, #166534, #15803d);
    border-radius: 20px; padding: 28px 36px; margin-bottom: 32px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 4px 20px rgba(21, 128, 61, 0.2);
}
.lead-header h2 { font-size: 1.8rem; font-weight: 800; color: #fff; margin: 0; display: flex; align-items: center; gap: 15px; }

.lead-table-card {
    background: #fff; border-radius: 24px; overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04); border: 1px solid #f1f5f9;
}
.table-head { background: #f8fafc; padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }

.lead-table { width: 100%; border-collapse: collapse; padding: 20px !important; }
.lead-table th { text-align: left; padding: 18px 24px; font-size: .75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f1f5f9; }
.lead-table td { padding: 18px 24px; font-size: .9rem; color: #1e293b; border-bottom: 1px solid #f1f5f9; }

.id-badge { 
    background: #f0fdf4; color: #166534; 
    padding: 6px 14px; border-radius: 10px; 
    font-weight: 800; font-size: .82rem; 
    border: 1.5px solid #dcfce7;
    white-space: nowrap;
    display: inline-block;
    min-width: 85px;
    text-align: center;
}
.stage-badge { padding: 6px 12px; border-radius: 10px; font-weight: 700; font-size: .75rem; display: inline-flex; align-items: center; gap: 6px; }

.stage-entry { background: #fefce8; color: #854d0e; border: 1.5px solid #fef9c3; }
.stage-assigned { background: #f0f9ff; color: #075985; border: 1.5px solid #e0f2fe; }
.stage-qualified { background: #fdf2f8; color: #9d174d; border: 1.5px solid #fce7f3; }

.kw-badge { font-weight: 800; color: #16a34a; }
.sla-badge { padding: 4px 10px; border-radius: 8px; font-size: .65rem; font-weight: 900; text-transform: uppercase; }
.sla-safe { background: #dcfce7; color: #15803d; }
.sla-warning { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
.sla-danger { background: #fee2e2; color: #b91c1c; border: 1.5px solid #fecaca; animation: blink 1s infinite alternate; }

@keyframes blink { from { opacity: 1; } to { opacity: 0.6; } }

.create-btn {
    background: #fff; color: #15803d; padding: 12px 24px; border-radius: 14px;
    font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 10px;
    transition: .2s; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.create-btn:hover { transform: translateY(-3px); background: #f0fdf4; color: #166534; }

/* ── Mobile Responsive ── */
@media (max-width: 768px) {
    .lead-table { display: block; overflow-x: auto; }
}

</style>

@section('content')
<div class="lead-wrap">
    <div class="lead-header">
        <div>
            <h2><i class="fas fa-bolt" style="color: #fde047;"></i> Lead Master Flow</h2>
            <p style="color: rgba(255,255,255,0.85); margin: 5px 0 0;">Manage your core solar leads pipeline from entry to commissioning.</p>
        </div>
        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.leads.create') }}" class="create-btn">
            <i class="fas fa-plus-circle"></i> Create New Lead
        </a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 15px 24px; border-radius: 16px; margin-bottom: 24px; font-weight: 600; box-shadow: 0 4px 10px rgba(22, 163, 74, 0.1);">
            <i class="fas fa-check-circle" style="margin-right: 12px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="lead-table-card">
        <div class="table-head">
            <h5 style="margin: 0; font-weight: 800; color: #1e293b;">Active Solar Leads</h5>
            <div style="display: flex; gap: 10px;">
                <input type="text" placeholder="Search Lead ID or Name..." style="padding: 8px 16px; border-radius: 10px; border: 1.5px solid #f1f5f9; font-size: .85rem;">
                <button style="padding: 8px 16px; border-radius: 10px; background: #f1f5f9; border: none; font-weight: 600; color: #64748b;"><i class="fas fa-filter"></i></button>
            </div>
        </div>
        
        <table id="leadsTable" class="lead-table">
            <thead>
                <tr>
                    <th>Lead ID</th>
                    <th>Customer Name</th>
                    <th>Contact</th>
                    <th>System / Capacity</th>
                    <th>SLA Status</th>
                    <th>Stage</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                @php
                    $hours = $lead->created_at->diffInHours(now());
                    $slaClass = 'sla-safe'; $slaText = 'In Time';
                    if($hours >= 18) { $slaClass = 'sla-danger'; $slaText = '18h+ BREACH'; }
                    elseif($hours >= 12) { $slaClass = 'sla-warning'; $slaText = '12h ALERT'; }
                @endphp
                <tr>
                    <td><span class="id-badge">{{ $lead->lead_code }}</span></td>
                    <td>
                        <div style="font-weight: 800; color: #1e293b;">{{ $lead->full_name }}</div>
                        <div style="font-size: .78rem; color: #64748b;">Added: {{ $lead->created_at->format('d M, Y') }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $lead->phone }}</div>
                        <div style="font-size: .78rem; color: #64748b;">{{ $lead->email }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: #166534;">{{ $lead->system_type }}</div>
                        <div class="kw-badge">{{ $lead->kw_capacity }} kW</div>
                    </td>
                    <td>
                        @if($lead->stage == 'Entry')
                            <span class="sla-badge {{ $slaClass }}">{{ $slaText }}</span>
                        @else
                            <span class="sla-badge sla-safe">Actioned</span>
                        @endif
                    </td>
                    <td>
                        <span class="stage-badge 
                            {{ $lead->stage == 'Entry' ? 'stage-entry' : '' }}
                            {{ $lead->stage == 'Assigned' ? 'stage-assigned' : '' }}
                            {{ $lead->stage == 'Qualified' ? 'stage-qualified' : '' }}">
                            <i class="fas {{ $lead->stage == 'Entry' ? 'fa-plus' : ($lead->stage == 'Assigned' ? 'fa-user' : 'fa-check-circle') }}"></i>
                            {{ $lead->stage }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $lead->city }}</div>
                        <div style="font-size: .75rem; color: #94a3b8;"><i class="fas fa-map-marker-alt"></i> Pan-India</div>
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.leads.show', $lead->id) }}" style="width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #64748b;"><i class="fas fa-eye"></i></a>
                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.leads.edit', $lead->id) }}" style="width: 32px; height: 32px; border-radius: 8px; background: #f0f9ff; display: flex; align-items: center; justify-content: center; color: #0369a1;"><i class="fas fa-edit"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#leadsTable').DataTable({
        "pageLength": 10,
        "ordering": true,
        "info": true,
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search Leads..."
        }
    });
});
</script>
@endsection
