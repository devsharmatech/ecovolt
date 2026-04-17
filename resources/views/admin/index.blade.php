@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
    * { font-family: 'Inter', sans-serif; }

    .dash-wrap {
        padding: 32px;
        background: #f0f4f8;
        min-height: 100vh;
    }

    /* ── Page Header ── */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }
    .dash-header .greet-tag {
        font-size: 11px; font-weight: 800; color: #16a34a;
        text-transform: uppercase; letter-spacing: 2.5px;
        display: flex; align-items: center; gap: 8px; margin-bottom: 6px;
    }
    .dash-header .greet-tag::before { content: ''; width: 18px; height: 2px; background: #16a34a; border-radius: 2px; }
    .dash-header h1 { font-size: 1.9rem; font-weight: 900; color: #0f172a; margin: 0; }
    .dash-header p  { font-size: 0.85rem; color: #64748b; font-weight: 500; margin-top: 4px; }

    .dash-date {
        background: #fff; border: 1.5px solid #e2e8f0;
        border-radius: 14px; padding: 12px 20px;
        font-size: 0.8rem; font-weight: 700; color: #64748b;
        display: flex; align-items: center; gap: 10px;
    }
    .dash-date i { color: #16a34a; }

    /* ── Metrics Grid ── */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .metric-card {
        border-radius: 22px;
        padding: 26px 24px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        display: block;
        text-decoration: none;
    }
    .metric-card:hover { transform: translateY(-5px); box-shadow: 0 20px 48px rgba(0,0,0,0.12); }

    .metric-card::after {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 130px; height: 130px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }
    .metric-card::before {
        content: '';
        position: absolute;
        bottom: -50px; right: 20px;
        width: 100px; height: 100px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    .mc-leads    { background: linear-gradient(145deg, #14532d, #166534); box-shadow: 0 10px 32px rgba(22,101,52,0.3); }
    .mc-projects { background: linear-gradient(145deg, #15803d, #22c55e); box-shadow: 0 10px 32px rgba(34,197,94,0.25); }
    .mc-approval { background: linear-gradient(145deg, #10b981, #34d399); box-shadow: 0 10px 32px rgba(16,185,129,0.25); }
    .mc-dealers  { background: linear-gradient(145deg, #0f766e, #14b8a6); box-shadow: 0 10px 32px rgba(20,184,166,0.25); }

    .mc-icon-wrap {
        width: 50px; height: 50px;
        background: rgba(255,255,255,0.15);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; color: rgba(255,255,255,0.9);
        margin-bottom: 20px;
    }
    .mc-label { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.65); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 4px; }
    .mc-value { font-size: 2.6rem; font-weight: 900; color: #fff; line-height: 1; margin-bottom: 14px; }
    .mc-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.12);
        border-radius: 30px; padding: 5px 12px;
        font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.85);
    }
    .mc-badge i { font-size: 0.75rem; }

    /* ── 2-col grid ── */
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }

    /* ── Section Card ── */
    .s-card {
        background: #fff;
        border-radius: 22px;
        border: 1.5px solid #f1f5f9;
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .s-card-head {
        padding: 22px 26px 0;
        display: flex; align-items: center; justify-content: space-between;
    }
    .s-card-title {
        display: flex; align-items: center; gap: 12px;
        font-size: 1rem; font-weight: 800; color: #0f172a;
    }
    .s-card-title .icon-box {
        width: 38px; height: 38px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
    }
    .ib-danger  { background: #fee2e2; color: #dc2626; }
    .ib-primary { background: #dbeafe; color: #2563eb; }
    .ib-success { background: #dcfce7; color: #16a34a; }
    .s-card-body { padding: 20px 26px 26px; }

    /* SLA Alerts */
    .sla-alert-item {
        display: flex; align-items: center; justify-content: space-between;
        background: #fafafa;
        border: 1.5px solid #f1f5f9;
        border-left: 4px solid;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 10px;
        transition: 0.2s;
    }
    .sla-alert-item:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
    .sla-alert-item.sla-warn { border-left-color: #f59e0b; }
    .sla-alert-item.sla-crit { border-left-color: #ef4444; animation: sla-blink 1.5s ease infinite; }
    @keyframes sla-blink { 0%,100% { opacity:1; } 50% { opacity:0.75; } }

    .sla-name { font-size: 0.88rem; font-weight: 700; color: #1e293b; }
    .sla-code { font-size: 0.75rem; color: #64748b; font-weight: 500; }
    .sla-badge-time {
        font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 30px;
    }
    .badge-warn { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .badge-crit { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }

    .sla-ok {
        text-align: center; padding: 30px;
        color: #16a34a; font-weight: 700; font-size: 0.9rem;
    }
    .sla-ok i { font-size: 2rem; display: block; margin-bottom: 8px; }

    /* Dealer Table */
    .d-table { width: 100%; border-collapse: collapse; }
    .d-table th {
        font-size: 10px; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 1.5px;
        padding: 10px 14px; border-bottom: 1.5px solid #f1f5f9; text-align: left;
    }
    .d-table td { padding: 14px 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
    .d-table tr:last-child td { border-bottom: none; }
    .d-table tr:hover td { background: #f8fafc; }

    .dealer-ava {
        width: 36px; height: 36px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 13px; color: #fff;
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        flex-shrink: 0;
    }
    .dealer-name { font-size: 0.88rem; font-weight: 700; color: #1e293b; }
    .cnt-pill {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 10px;
        font-size: 13px; font-weight: 800;
    }
    .cnt-leads    { background: #eff6ff; color: #2563eb; }
    .cnt-projects { background: #dcfce7; color: #16a34a; }

    /* Pipeline Table */
    .p-table { width: 100%; border-collapse: collapse; }
    .p-table th {
        font-size: 10px; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 1.5px;
        padding: 10px 16px; border-bottom: 1.5px solid #f1f5f9; text-align: left;
    }
    .p-table td { padding: 16px 16px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
    .p-table tr:last-child td { border-bottom: none; }
    .p-table tr:hover td { background: #f8fafc; }

    .prj-ava {
        width: 38px; height: 38px; border-radius: 12px;
        background: linear-gradient(135deg, #064e3b, #166534);
        color: #fff; font-weight: 800; font-size: 13px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .prj-name { font-size: 0.88rem; font-weight: 700; color: #1e293b; }
    .prj-code { font-size: 0.73rem; color: #94a3b8; font-weight: 500; }
    .stage-chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f0fdf4; color: #16a34a;
        border: 1px solid #bbf7d0; border-radius: 30px;
        padding: 5px 12px; font-size: 11px; font-weight: 700;
    }
    .stage-chip i { font-size: 0.65rem; }
    .status-chip {
        display: inline-block; padding: 4px 12px; border-radius: 30px;
        font-size: 11px; font-weight: 800;
    }
    .sc-active { background: #dcfce7; color: #15803d; }
    .sc-other  { background: #f1f5f9; color: #64748b; }

    .monitor-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f0fdf4; color: #16a34a;
        border: 1.5px solid #bbf7d0; border-radius: 10px;
        padding: 7px 14px; font-size: 11px; font-weight: 700;
        text-decoration: none; transition: 0.2s;
    }
    .monitor-btn:hover { background: #16a34a; color: #fff; border-color: #16a34a; }

    .empty-state { text-align: center; padding: 36px; color: #cbd5e1; }
    .empty-state i { font-size: 2rem; margin-bottom: 8px; display: block; }
    .empty-state span { font-size: 0.85rem; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="dash-wrap">

    {{-- ── Header ── --}}
    <div class="dash-header">
        <div>
            <div class="greet-tag">EcoVolt Admin Portal</div>
            <h1>Admin Dashboard</h1>
            <p>Real-time overview of your solar project pipeline & dealer network.</p>
        </div>
        <div class="dash-date">
            <i class="fa-regular fa-calendar-check"></i>
            {{ now()->format('l, d M Y') }}
        </div>
    </div>

    {{-- ── Metric Cards ── --}}
    <div class="metrics-grid">
        <a href="{{ route('admin.leads.index') }}" class="metric-card mc-leads">
            <div class="mc-icon-wrap"><i class="fa-solid fa-bolt-lightning"></i></div>
            <div class="mc-label">Total Leads</div>
            <div class="mc-value">{{ number_format($leadsCount) }}</div>
            <div class="mc-badge"><i class="fa-solid fa-circle-dot"></i> Operations Active</div>
        </a>
        <a href="{{ route('admin.projects.index') }}" class="metric-card mc-projects">
            <div class="mc-icon-wrap"><i class="fa-solid fa-solar-panel"></i></div>
            <div class="mc-label">Active Projects</div>
            <div class="mc-value">{{ number_format($projectsCount) }}</div>
            <div class="mc-badge"><i class="fa-solid fa-chart-line"></i> Execution Phase</div>
        </a>
        <a href="{{ route('admin.documents.index') }}" class="metric-card mc-approval">
            <div class="mc-icon-wrap"><i class="fa-solid fa-circle-check"></i></div>
            <div class="mc-label">Pending Approvals</div>
            <div class="mc-value">{{ number_format($pendingApprovals) }}</div>
            <div class="mc-badge"><i class="fa-solid fa-triangle-exclamation"></i> Action Required</div>
        </a>
        <a href="{{ route('admin.users.index') }}" class="metric-card mc-dealers">
            <div class="mc-icon-wrap"><i class="fa-solid fa-users-gear"></i></div>
            <div class="mc-label">Total Dealers</div>
            <div class="mc-value">{{ $dealerCount }}</div>
            <div class="mc-badge"><i class="fa-solid fa-check"></i> Network Online</div>
        </a>
    </div>

    {{-- ── SLA + Dealer ── --}}
    <div class="two-col">

        {{-- SLA Monitoring --}}
        <div class="s-card">
            <div class="s-card-head">
                <div class="s-card-title">
                    <div class="icon-box ib-danger"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    SLA Monitoring Center
                </div>
                <span style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:1.5px;">Live</span>
            </div>
            <div class="s-card-body">
                @php
                    $breachedLeads = \App\Models\Lead::whereIn('stage', ['Entry', 'Pending', 'New'])
                        ->get()
                        ->filter(fn($l) => $l->updated_at->diffInHours(now()) >= 12);
                @endphp
                @forelse($breachedLeads as $bl)
                    @php $hrs = floor($bl->updated_at->diffInHours(now())); @endphp
                    <div class="sla-alert-item {{ $hrs >= 18 ? 'sla-crit' : 'sla-warn' }}">
                        <div>
                            <div class="sla-name">{{ $bl->first_name }} {{ $bl->last_name }}</div>
                            <div class="sla-code">{{ $bl->lead_code }} · {{ $bl->city }}</div>
                        </div>
                        <span class="sla-badge-time {{ $hrs >= 18 ? 'badge-crit' : 'badge-warn' }}">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i>{{ $hrs }}h Elapsed
                        </span>
                    </div>
                @empty
                    <div class="sla-ok">
                        <i class="fa-solid fa-circle-check"></i>
                        All leads within SLA time. 🎯
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Dealer Performance --}}
        <div class="s-card">
            <div class="s-card-head">
                <div class="s-card-title">
                    <div class="icon-box ib-primary"><i class="fa-solid fa-handshake"></i></div>
                    Dealer Performance
                </div>
            </div>
            <div class="s-card-body" style="padding-top:16px;">
                @if($dealerStats->isEmpty())
                    <div class="empty-state">
                        <i class="fa-solid fa-user-slash"></i>
                        <span>No dealers registered yet.</span>
                    </div>
                @else
                <table class="d-table">
                    <thead><tr>
                        <th>Dealer</th>
                        <th style="text-align:center;">Leads</th>
                        <th style="text-align:center;">Projects</th>
                    </tr></thead>
                    <tbody>
                        @foreach($dealerStats as $ds)
                        <tr>
                            <td>
                                <a href="{{ route('admin.users.show', $ds->id) }}" style="display:flex; align-items:center; gap:12px; text-decoration:none; cursor:pointer;">
                                    <div class="dealer-ava">{{ strtoupper(substr($ds->name,0,2)) }}</div>
                                    <div class="dealer-name" style="transition:0.2s; color:#1e293b;" onmouseover="this.style.color='#16a34a'" onmouseout="this.style.color='#1e293b'">{{ $ds->name }}</div>
                                </a>
                            </td>
                            <td style="text-align:center;"><span class="cnt-pill cnt-leads">{{ $ds->leads_count }}</span></td>
                            <td style="text-align:center;"><span class="cnt-pill cnt-projects">{{ $ds->projects_count }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Project Pipeline Table ── --}}
    <div class="s-card">
        <div class="s-card-head">
            <div class="s-card-title">
                <div class="icon-box ib-success"><i class="fa-solid fa-diagram-project"></i></div>
                Project Milestone Tracking
            </div>
            <a href="{{ route(auth()->user()->getRoleNames()->first().'.projects.index') }}"
               style="font-size:11px; font-weight:700; color:#16a34a; text-decoration:none;">
                View All <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="s-card-body" style="padding-top:16px;">
            @if($recentProjects->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>No projects found. Create your first project!</span>
                </div>
            @else
            <table class="p-table">
                <thead><tr>
                    <th>Project</th>
                    <th>Current Stage</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr></thead>
                <tbody>
                    @foreach($recentProjects as $p)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="prj-ava">{{ strtoupper(substr($p->customer_name,0,2)) }}</div>
                                <div>
                                    <div class="prj-name">{{ $p->customer_name }}</div>
                                    <div class="prj-code">{{ $p->project_code }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="stage-chip">
                                <i class="fa-solid fa-circle-dot"></i>
                                {{ \App\Models\Project::stageLabel($p->current_stage) }}
                            </span>
                        </td>
                        <td>
                            @if($p->status == 'active')
                                <span class="status-chip sc-active">Active</span>
                            @else
                                <span class="status-chip sc-other">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route(auth()->user()->getRoleNames()->first().'.projects.show', $p) }}" class="monitor-btn">
                                <i class="fa-solid fa-eye"></i> Monitor
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Animate metric numbers on load
    document.querySelectorAll('.mc-value').forEach(el => {
        const target = parseInt(el.innerText.replace(/,/g,'')) || 0;
        if (isNaN(target) || target === 0) return;
        let count = 0;
        const step = Math.max(1, Math.floor(target / 40));
        const timer = setInterval(() => {
            count = Math.min(count + step, target);
            el.innerText = count.toLocaleString();
            if (count >= target) clearInterval(timer);
        }, 25);
    });
</script>
@endsection
