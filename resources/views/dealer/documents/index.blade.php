@extends('admin.layouts.master')
@section('title', 'Documents Management')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<style>
/* ── Page Wrapper ── */
.doc-wrap { padding: 28px; background: #f0f4f8; min-height: 100vh; }

/* ── Top Hero ── */
.doc-hero {
    background: linear-gradient(135deg, #14532d 0%, #166534 50%, #15803d 100%);
    border-radius: 24px;
    padding: 36px 44px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    box-shadow: 0 8px 30px rgba(21, 128, 61, 0.25);
    position: relative;
    overflow: hidden;
}
.doc-hero::before {
    content: '\f15c';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    right: 200px;
    top: -10px;
    font-size: 9rem;
    color: rgba(255,255,255,0.05);
}
.doc-hero h1 { font-size: 1.8rem; font-weight: 900; color: #fff; margin: 0; }
.doc-hero p { color: rgba(255,255,255,0.75); margin: 6px 0 0; font-size: .95rem; }

.hero-btn {
    background: #fff;
    color: #166534;
    padding: 14px 28px;
    border-radius: 14px;
    font-weight: 800;
    font-size: .95rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    transition: .25s;
    white-space: nowrap;
}
.hero-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); color: #166534; }

/* ── Stats Row ── */
.stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 28px; }
.stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 22px 28px;
    display: flex;
    align-items: center;
    gap: 18px;
    border: 1px solid #e8f5e9;
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
}
.stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.stat-val { font-size: 1.8rem; font-weight: 900; color: #1e293b; line-height: 1; }
.stat-lbl { font-size: .78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-top: 4px; }

/* ── Main Table Card ── */
.table-card {
    background: #fff;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    border: 1px solid #e8f5e9;
}
.table-card-header {
    padding: 22px 30px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.table-card-header h5 { margin: 0; font-weight: 800; color: #1e293b; font-size: 1rem; }

/* DataTable Overrides */
.dataTables_wrapper .dataTables_filter { display: none; } /* hide default, we have our own */
.dataTables_wrapper .dataTables_length select { border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 4px 8px; }
.dataTables_wrapper .dataTables_info { font-size: .8rem; color: #94a3b8; padding: 16px 30px !important; }
.dataTables_wrapper .dataTables_paginate { padding: 12px 30px !important; }
.dataTables_wrapper .page-item.active .page-link { background: #166534; border-color: #166534; }
.dataTables_wrapper .page-link { color: #166534; }

/* ── Compliance Table ── */
#complianceTable { width: 100% !important; border-collapse: collapse; }
#complianceTable thead th {
    background: #f8fafc;
    padding: 15px 18px;
    font-size: .7rem;
    font-weight: 900;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .5px;
    border-bottom: 2px solid #f1f5f9;
    border-top: none;
    white-space: nowrap;
}
#complianceTable tbody td {
    padding: 18px 18px;
    border-bottom: 1px solid #f8fafc;
    vertical-align: middle;
}
#complianceTable tbody tr:hover { background: #f8fdfb; }
#complianceTable tbody tr:last-child td { border-bottom: none; }

/* Doc Icon Chips */
.doc-chip {
    width: 40px; height: 40px; border-radius: 12px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 1rem; text-decoration: none; transition: .2s;
    border: none; cursor: pointer;
}
.doc-chip:hover { transform: scale(1.15); }
.chip-pan      { background: #eef2ff; color: #4f46e5; }
.chip-aadhaar  { background: #f0fdf4; color: #16a34a; }
.chip-bill     { background: #fff7ed; color: #c2410c; }
.chip-bank     { background: #f5f3ff; color: #7c3aed; }
.chip-geo      { background: #fff1f2; color: #e11d48; }
.chip-missing  { background: #f1f5f9; color: #cbd5e1; cursor: not-allowed; }

/* Status Badge */
.s-verified { background: #dcfce7; color: #15803d; border: 1.5px solid #bbf7d0; padding: 6px 16px; border-radius: 20px; font-size: .72rem; font-weight: 900; text-transform: uppercase; letter-spacing: .4px; }
.s-pending  { background: #fef9c3; color: #92400e; border: 1.5px solid #fde68a; padding: 6px 16px; border-radius: 20px; font-size: .72rem; font-weight: 900; text-transform: uppercase; letter-spacing: .4px; }

/* Action Buttons */
.act-btn { width: 34px; height: 34px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; text-decoration: none; border: none; cursor: pointer; transition: .2s; }
.act-btn:hover { transform: scale(1.12); }
.act-view { background: #f0fdf4; color: #166534; }
.act-edit { background: #eff6ff; color: #1d4ed8; }
.act-del  { background: #fff1f2; color: #e11d48; }

/* Custom Search */
.custom-search {
    padding: 9px 16px 9px 38px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: .85rem;
    outline: none;
    transition: .2s;
    width: 240px;
}
.custom-search:focus { border-color: #166534; box-shadow: 0 0 0 3px rgba(22,101,52,0.1); }
.search-wrap { position: relative; }
.search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: .8rem; }
</style>

@section('content')
<div class="doc-wrap">

    <!-- Hero Header -->
    <div class="doc-hero">
        <div>
            <h1><i class="fas fa-folder-open" style="margin-right:14px; opacity:.9;"></i>Lead Documentation Tracking</h1>
            <p>One-stop compliance matrix for all mandatory solar project documents.</p>
        </div>
        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.documents.create') }}" class="hero-btn">
            <i class="fas fa-plus-circle"></i> New Onboarding
        </a>
    </div>

    <!-- Stats Row -->
    @php
        $total    = $documents->count();
        $verified = $documents->where('status','verified')->count();
        $pending  = $documents->where('status','pending')->count();
    @endphp
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: #e0f2fe; color: #0369a1;"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-val">{{ $total }}</div>
                <div class="stat-lbl">Total Leads Onboarded</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #dcfce7; color: #166534;"><i class="fas fa-check-double"></i></div>
            <div>
                <div class="stat-val">{{ $verified }}</div>
                <div class="stat-lbl">Fully Verified Sets</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef9c3; color: #92400e;"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-val">{{ $pending }}</div>
                <div class="stat-lbl">Pending Audit</div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-card-header">
            <h5><i class="fas fa-table" style="color:#166534; margin-right:8px;"></i>Active Compliance Matrix</h5>
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="docSearch" class="custom-search" placeholder="Search customers...">
            </div>
        </div>

        <div class="table-responsive" style="padding: 0 4px;">
            <table id="complianceTable" class="table">
                <thead>
                    <tr>
                        <th>Customer / Lead</th>
                        <th class="text-center">PAN</th>
                        <th class="text-center">Aadhaar</th>
                        <th class="text-center">Elec. Bill</th>
                        <th class="text-center">Bank</th>
                        <th class="text-center">Geo Photos</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <!-- Customer Cell -->
                        <td>
                            <div style="font-weight: 800; color: #1e293b; font-size: .95rem;">{{ $doc->customer_name }}</div>
                            <div style="font-size: .72rem; color: #94a3b8; margin-top:4px;">
                                <span style="background:#f0fdf4; color:#166534; padding:2px 8px; border-radius:6px; font-weight:700; margin-right:6px;">
                                    {{ $doc->lead ? $doc->lead->lead_code : 'No Lead' }}
                                </span>
                                <i class="fas fa-calendar-alt"></i> {{ $doc->uploaded_date->format('d M Y') }}
                            </div>
                        </td>

                        <!-- PAN -->
                        <td class="text-center">
                            @if($doc->pan_path)
                                <a href="{{ asset('storage/'.$doc->pan_path) }}" target="_blank" class="doc-chip chip-pan" title="View PAN Card"><i class="fas fa-file-invoice"></i></a>
                            @else
                                <div class="doc-chip chip-missing" title="Not Uploaded"><i class="fas fa-minus"></i></div>
                            @endif
                        </td>

                        <!-- Aadhaar -->
                        <td class="text-center">
                            @if($doc->aadhaar_path)
                                <a href="{{ asset('storage/'.$doc->aadhaar_path) }}" target="_blank" class="doc-chip chip-aadhaar" title="View Aadhaar"><i class="fas fa-id-card"></i></a>
                            @else
                                <div class="doc-chip chip-missing" title="Not Uploaded"><i class="fas fa-minus"></i></div>
                            @endif
                        </td>

                        <!-- Bill -->
                        <td class="text-center">
                            @if($doc->bill_path)
                                <a href="{{ asset('storage/'.$doc->bill_path) }}" target="_blank" class="doc-chip chip-bill" title="View Electricity Bill"><i class="fas fa-bolt"></i></a>
                            @else
                                <div class="doc-chip chip-missing" title="Not Uploaded"><i class="fas fa-minus"></i></div>
                            @endif
                        </td>

                        <!-- Bank -->
                        <td class="text-center">
                            @if($doc->bank_path)
                                <a href="{{ asset('storage/'.$doc->bank_path) }}" target="_blank" class="doc-chip chip-bank" title="View Bank Statement"><i class="fas fa-university"></i></a>
                            @else
                                <div class="doc-chip chip-missing" title="Not Uploaded"><i class="fas fa-minus"></i></div>
                            @endif
                        </td>

                        <!-- Geo -->
                        <td class="text-center">
                            @if($doc->geo_path)
                                <a href="{{ asset('storage/'.$doc->geo_path) }}" target="_blank" class="doc-chip chip-geo" title="View Site Photos"><i class="fas fa-map-marker-alt"></i></a>
                            @else
                                <div class="doc-chip chip-missing" title="Not Uploaded"><i class="fas fa-minus"></i></div>
                            @endif
                        </td>

                        <!-- Status -->
                        <td>
                            @if($doc->status == 'verified')
                                <span class="s-verified"><i class="fas fa-check-circle me-1"></i>Verified</span>
                            @else
                                <span class="s-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <a href="{{ route(auth()->user()->getRoleNames()->first().'.documents.show', $doc) }}" class="act-btn act-view" title="View Set"><i class="fas fa-eye"></i></a>
                                <a href="{{ route(auth()->user()->getRoleNames()->first().'.documents.edit', $doc) }}" class="act-btn act-edit" title="Edit Documents"><i class="fas fa-pen"></i></a>
                                <form action="{{ route(auth()->user()->getRoleNames()->first().'.documents.destroy', $doc) }}" method="POST" style="margin:0;" onsubmit="return confirm('Delete this entire document set?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn act-del" title="Delete Set"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:60px; color:#94a3b8;">
                            <i class="fas fa-folder-open" style="font-size:3rem; margin-bottom:16px; display:block;"></i>
                            No documents onboarded yet. Click "New Onboarding" to begin.
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
    var table = $('#complianceTable').DataTable({
        pageLength: 10,
        ordering: true,
        dom: '<"d-flex justify-content-between align-items-center px-4 py-3"li>tp',
        language: {
            info: "Showing _START_–_END_ of _TOTAL_ leads",
            lengthMenu: "Show _MENU_",
            paginate: { previous: "<i class='fas fa-chevron-left'></i>", next: "<i class='fas fa-chevron-right'></i>" }
        }
    });

    // Wire custom search box
    $('#docSearch').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>
@endsection
