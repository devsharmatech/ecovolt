@extends('admin.layouts.master')
@section('title', 'Project Management')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
.pm-wrap { padding: 28px; background: #f0f4f8; min-height: 100vh; }

.pm-hero {
    background: linear-gradient(135deg, #14532d, #166534, #15803d);
    border-radius: 24px; padding: 36px 44px;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px;
    box-shadow: 0 8px 30px rgba(21,128,61,0.25);
    position: relative; overflow: hidden;
}
.pm-hero::after {
    content: '\f542'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
    position: absolute; right: 180px; top: -20px; font-size: 10rem;
    color: rgba(255,255,255,0.04);
}
.hero-badge { background: rgba(255,255,255,0.2); color: #fff; border-radius: 20px; padding: 4px 14px; font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 10px; }
.pm-hero h1 { font-size: 1.9rem; font-weight: 900; color: #fff; margin: 0; }
.pm-hero p { color: rgba(255,255,255,0.7); margin: 6px 0 0; }
.hero-btn { background: #fff; color: #166534; padding: 14px 28px; border-radius: 14px; font-weight: 800; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: .2s; }
.hero-btn:hover { color: #166534; transform: translateY(-3px); }

.stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px; }
.stat-card { background: #fff; border-radius: 18px; padding: 22px 24px; display: flex; align-items: center; gap: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
.s-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.s-val { font-size: 1.7rem; font-weight: 900; color: #1e293b; line-height: 1; }
.s-lbl { font-size: .72rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-top: 4px; }

.table-card { background: #fff; border-radius: 22px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; }
.tc-head { padding: 22px 30px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
.tc-head h5 { margin: 0; font-weight: 800; color: #1e293b; }

#projectTable { width:100% !important; border-collapse: collapse; }
#projectTable thead th { background: #f8fafc; padding: 14px 18px; font-size: .7rem; font-weight: 900; color: #94a3b8; text-transform: uppercase; border-bottom: 2px solid #f1f5f9; border-top: none; white-space: nowrap; }
#projectTable tbody td { padding: 18px 18px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
#projectTable tbody tr:hover { background: #f8fdfb; }
#projectTable tbody tr:last-child td { border-bottom: none; }

.proj-code { background: #f0fdf4; color: #166534; padding: 4px 12px; border-radius: 8px; font-weight: 900; font-size: .78rem; border: 1.5px solid #dcfce7; }

.stage-chip { padding: 5px 14px; border-radius: 20px; font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: .4px; }
.stage-active { background: #dbeafe; color: #1d4ed8; }
.stage-done { background: #dcfce7; color: #15803d; }
.stage-hold { background: #fef9c3; color: #92400e; }

.progress-bar-wrap { height: 6px; background: #f1f5f9; border-radius: 99px; width: 100px; overflow: hidden; }
.progress-bar-fill { height: 100%; border-radius: 99px; background: linear-gradient(to right, #22c55e, #166534); }

.mode-cash { background: #fef9c3; color: #92400e; padding: 3px 10px; border-radius: 6px; font-size: .7rem; font-weight: 800; }
.mode-bank { background: #eff6ff; color: #1d4ed8; padding: 3px 10px; border-radius: 6px; font-size: .7rem; font-weight: 800; }
.mode-pending { background: #f1f5f9; color: #64748b; padding: 3px 10px; border-radius: 6px; font-size: .7rem; font-weight: 800; }

.act-btn { width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; border: none; cursor: pointer; transition: .2s; font-size: .85rem; }
.act-btn:hover { transform: scale(1.12); }
.act-view { background: #f0fdf4; color: #166534; }
.act-del { background: #fff1f2; color: #e11d48; }

.custom-search { padding: 9px 16px 9px 38px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: .85rem; outline: none; transition: .2s; width: 240px; }
.custom-search:focus { border-color: #166534; }
.search-wrap { position: relative; }
.search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }

.dataTables_wrapper .dataTables_info { font-size: .8rem; color: #94a3b8; padding: 14px 30px !important; }
.dataTables_wrapper .dataTables_paginate { padding: 10px 30px !important; }
.page-item.active .page-link { background: #166534 !important; border-color: #166534 !important; }
.page-link { color: #166534 !important; }
</style>

@section('content')
<div class="pm-wrap">

    <!-- Hero -->
    <div class="pm-hero">
        <div>
            <span class="hero-badge"><i class="fas fa-solar-panel"></i> Solar CRM</span>
            <h1>Project Management</h1>
            <p>Track every solar project from KYC to Subsidy Redemption.</p>
        </div>
        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.projects.create') }}" class="hero-btn">
            <i class="fas fa-plus-circle"></i> New Project
        </a>
    </div>

    <!-- Stats -->
    @php
        $total     = $projects->count();
        $active    = $projects->where('status','active')->count();
        $completed = $projects->where('status','completed')->count();
        $onHold    = $projects->where('status','on_hold')->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="s-icon" style="background:#eff6ff; color:#1d4ed8;"><i class="fas fa-project-diagram"></i></div>
            <div><div class="s-val">{{ $total }}</div><div class="s-lbl">Total Projects</div></div>
        </div>
        <div class="stat-card">
            <div class="s-icon" style="background:#f0fdf4; color:#166534;"><i class="fas fa-bolt"></i></div>
            <div><div class="s-val">{{ $active }}</div><div class="s-lbl">Active Pipeline</div></div>
        </div>
        <div class="stat-card">
            <div class="s-icon" style="background:#dcfce7; color:#15803d;"><i class="fas fa-check-double"></i></div>
            <div><div class="s-val">{{ $completed }}</div><div class="s-lbl">Commissioned</div></div>
        </div>
        <div class="stat-card">
            <div class="s-icon" style="background:#fef9c3; color:#92400e;"><i class="fas fa-pause-circle"></i></div>
            <div><div class="s-val">{{ $onHold }}</div><div class="s-lbl">On Hold</div></div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="tc-head">
            <h5><i class="fas fa-stream" style="color:#166534; margin-right:8px;"></i>Project Pipeline Board</h5>
            <div class="search-wrap">
                <i class="fas fa-search" style="font-size:.75rem;"></i>
                <input type="text" id="pmSearch" class="custom-search" placeholder="Search projects...">
            </div>
        </div>

        <div class="table-responsive">
            <table id="projectTable" class="table">
                <thead>
                    <tr>
                        <th>Project / Customer</th>
                        <th>Lead</th>
                        <th>Payment</th>
                        <th>Current Stage</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td>
                            <div><span class="proj-code">{{ $project->project_code }}</span></div>
                            <div style="font-weight:800; color:#1e293b; margin-top:6px;">{{ $project->customer_name }}</div>
                            <div style="font-size:.72rem; color:#94a3b8;"><i class="fas fa-calendar-alt"></i> {{ $project->created_at->format('d M Y') }}</div>
                        </td>
                        <td>
                            @if($project->lead)
                                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.leads.show', $project->lead->id) }}" style="text-decoration: none;">
                                    <div style="font-weight:700; color:#166534;">{{ $project->lead->lead_code }}</div>
                                </a>
                            @else
                                <div style="font-weight:700; color:#94a3b8;">N/A</div>
                            @endif
                        </td>
                        <td>
                            <span class="mode-{{ $project->payment_mode }}">
                                {{ strtoupper($project->payment_mode) }}
                            </span>
                        </td>
                        <td>
                            <span class="stage-chip stage-active">
                                {{ \App\Models\Project::stageLabel($project->current_stage) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="progress-bar-wrap">
                                    <div class="progress-bar-fill" style="width:{{ $project->progressPercent() }}%"></div>
                                </div>
                                <span style="font-size:.75rem; font-weight:800; color:#64748b;">{{ $project->progressPercent() }}%</span>
                            </div>
                        </td>
                        <td>
                            @if($project->status=='completed')
                                <span class="stage-chip stage-done"><i class="fas fa-check"></i> Done</span>
                            @elseif($project->status=='on_hold')
                                <span class="stage-chip stage-hold"><i class="fas fa-pause"></i> Hold</span>
                            @else
                                <span class="stage-chip stage-active"><i class="fas fa-play"></i> Active</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:8px;">
                                <a href="{{ route(auth()->user()->getRoleNames()->first().'.projects.show', $project) }}" class="act-btn act-view" title="Open Pipeline"><i class="fas fa-eye"></i></a>
                                <a href="{{ route(auth()->user()->getRoleNames()->first().'.projects.edit', $project) }}" class="act-btn act-edit" style="background:#eff6ff; color:#1d4ed8;" title="Edit Project"><i class="fas fa-pen"></i></a>
                                <form action="{{ route(auth()->user()->getRoleNames()->first().'.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Remove project?');" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button class="act-btn act-del" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:60px; color:#94a3b8;">
                            <i class="fas fa-solar-panel" style="font-size:3rem; display:block; margin-bottom:16px;"></i>
                            No projects yet. Create your first solar project!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#projectTable').DataTable({
        pageLength: 10,
        dom: '<"d-flex justify-content-between align-items-center px-4 py-3"li>tp',
        language: {
            info: "Showing _START_–_END_ of _TOTAL_ projects",
            paginate: { previous: "<i class='fas fa-chevron-left'></i>", next: "<i class='fas fa-chevron-right'></i>" }
        }
    });
    $('#pmSearch').on('keyup', function() { table.search(this.value).draw(); });
});
</script>
@endsection
