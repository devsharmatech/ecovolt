@extends('admin.layouts.master')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* ─── Page Wrapper ─────────────────────────────────────── */
    .um-wrapper { padding: 24px; }

    /* ─── Header Bar ───────────────────────────────────────── */
    .um-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .um-title-group h1 {
        font-size: 1.65rem;
        font-weight: 700;
        color: #1a1f36;
        margin: 0;
    }
    .um-title-group p {
        font-size: .82rem;
        color: #8898aa;
        margin: 2px 0 0;
    }
    .um-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: #fff !important;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: .875rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(46,204,113,.35);
        transition: transform .2s, box-shadow .2s;
    }
    .um-add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(46,204,113,.45);
        color: #fff !important;
    }

    /* ─── Stats Strip ──────────────────────────────────────── */
    .um-stats {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .um-stat-card {
        flex: 1;
        min-width: 140px;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,.07);
    }
    .um-stat-card.green  { background: linear-gradient(135deg,#e9faf2,#d1f5e0); }
    .um-stat-card.blue   { background: linear-gradient(135deg,#e8f4fd,#cce5fb); }
    .um-stat-card.orange { background: linear-gradient(135deg,#fff4e5,#ffe4bc); }
    .um-stat-card.purple { background: linear-gradient(135deg,#f3eeff,#e2d4fc); }
    .um-stat-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }
    .green  .um-stat-icon { background: rgba(46,204,113,.2); color: #27ae60; }
    .blue   .um-stat-icon { background: rgba(52,144,220,.2); color: #2980b9; }
    .orange .um-stat-icon { background: rgba(255,165,0,.2);  color: #e67e22; }
    .purple .um-stat-icon { background: rgba(155,89,182,.2); color: #8e44ad; }
    .um-stat-info span { font-size: .72rem; color: #7a8599; display: block; }
    .um-stat-info strong { font-size: 1.45rem; font-weight: 700; color: #1a1f36; line-height: 1; }

    /* ─── Card ─────────────────────────────────────────────── */
    .um-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 16px rgba(0,0,0,.07);
        overflow: hidden;
    }
    .um-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid #f0f2f7;
        display: flex; align-items: center; gap: 10px;
    }
    .um-card-header .icon-circle {
        width: 36px; height: 36px; border-radius: 10px;
        background: linear-gradient(135deg,#2ecc71,#27ae60);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: .9rem;
    }
    .um-card-header h6 {
        margin: 0; font-weight: 700; color: #1a1f36; font-size: .95rem;
    }

    /* ─── Table ─────────────────────────────────────────────── */
    #UserTable thead th {
        background: #f8f9fc;
        color: #5a6282;
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        border: none;
        padding: 13px 16px;
        white-space: nowrap;
    }
    #UserTable tbody tr {
        border-bottom: 1px solid #f0f2f7;
        transition: background .15s;
    }
    #UserTable tbody tr:hover { background: #f8fbff; }
    #UserTable tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border: none;
        font-size: .875rem;
        color: #3d4566;
    }

    /* ─── User Code Badge ───────────────────────────────────── */
    .code-badge {
        background: linear-gradient(135deg, #636363, #e2e2e2);
        color: #fff;
        font-size: .7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: .04em;
        white-space: nowrap;
    }

    /* ─── Avatar ─────────────────────────────────────────────── */
    .user-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }
    .avatar-initials {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem; font-weight: 700; color: #fff;
    }

    /* ─── User Info ─────────────────────────────────────────── */
    .user-name { font-weight: 600; color: #1a1f36; margin: 0; font-size: .875rem; }
    .user-email { color: #8898aa; font-size: .75rem; margin: 0; }

    /* ─── Status Switch ─────────────────────────────────────── */
    .status-pill {
        appearance: none;
        border: none;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: .72rem;
        font-weight: 600;
        cursor: pointer;
        outline: none;
        transition: all .2s;
    }
    .status-pill.active-pill   { background: #d1fae5; color: #065f46; }
    .status-pill.inactive-pill { background: #fee2e2; color: #991b1b; }

    /* ─── Action Buttons ─────────────────────────────────────── */
    .action-group { display: flex; gap: 6px; align-items: center; }
    .action-btn {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: transform .15s, box-shadow .15s;
    }
    .action-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.15); }
    .btn-view { background: #e0f2fe; color: #0369a1; }
    .btn-edit { background: #ede9fe; color: #5b21b6; }
    .btn-del  { background: #fee2e2; color: #991b1b; }

    /* ─── Date cell ─────────────────────────────────────────── */
    .date-cell { font-size: .78rem; color: #8898aa; white-space: nowrap; }

    /* ─── DataTables overrides ──────────────────────────────── */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px; border: 1.5px solid #e0e4ef;
        padding: 6px 12px; font-size: .82rem; outline: none;
    }
    .dataTables_wrapper .dataTables_filter input:focus { border-color: #27ae60; }
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px; border: 1.5px solid #e0e4ef;
        padding: 4px 8px; font-size: .82rem;
    }
    .dataTables_wrapper .dataTables_info { font-size: .78rem; color: #8898aa; }
    .dataTables_paginate .paginate_button { border-radius: 8px !important; }
    .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg,#2ecc71,#27ae60) !important;
        color: #fff !important; border: none !important;
    }
    .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f0faf4 !important; color: #27ae60 !important; border-color: #27ae60 !important;
    }

    /* ─── Empty State ────────────────────────────────────────── */
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-state .empty-icon { font-size: 3rem; color: #d1d9e4; margin-bottom: 16px; }
    .empty-state p { color: #8898aa; font-size: .9rem; }

    /* Toast */
    .swal2-toast { font-size: 12px !important; }

    /* Responsive name+email stacked */
    .user-cell { display: flex; align-items: center; gap: 12px; }
</style>

@section('content')
<div class="um-wrapper">

    {{-- ── HEADER ─────────────────────────────────────────────── --}}
    <div class="um-header">
        <div class="um-title-group">
            <h1>
                @php
                    $icons = ['Accounts'=>'fas fa-calculator','Dealer'=>'fas fa-store','Employee'=>'fas fa-user-tie','Customer'=>'fas fa-users'];
                    $icon  = $icons[$requestedRole] ?? 'fas fa-users';
                @endphp
                <i class="{{ $icon }}" style="color:#27ae60;margin-right:8px;"></i>
                {{ $requestedRole == 'user' ? 'Users' : ucfirst($requestedRole) }} Management
            </h1>
            <p>Manage all {{ strtolower($requestedRole == 'user' ? 'users' : ucfirst($requestedRole)) }} in the system</p>
        </div>

        @can('users.create')
            @if(!in_array(strtolower($requestedRole), ['employee', 'customer']))
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.create') }}?role={{ $requestedRole }}"
                   class="um-add-btn">
                    <i class="fas fa-plus"></i>
                    Add New {{ $requestedRole == 'user' ? 'User' : rtrim(ucfirst($requestedRole), 's') }}
                </a>
            @endif
        @endcan
    </div>

    {{-- ── STATS STRIP ──────────────────────────────────────────── --}}
    @php
        $total    = $users->total();
        $active   = $users->getCollection()->where('status','active')->count();
        $inactive = $users->getCollection()->where('status','inactive')->count();
    @endphp
    <div class="um-stats">
        <div class="um-stat-card green">
            <div class="um-stat-icon"><i class="fas fa-users"></i></div>
            <div class="um-stat-info"><span>Total</span><strong>{{ $total }}</strong></div>
        </div>
        <div class="um-stat-card blue">
            <div class="um-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="um-stat-info"><span>Active</span><strong>{{ $active }}</strong></div>
        </div>
        <div class="um-stat-card orange">
            <div class="um-stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="um-stat-info"><span>Inactive</span><strong>{{ $inactive }}</strong></div>
        </div>
        <div class="um-stat-card purple">
            <div class="um-stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="um-stat-info"><span>This Page</span><strong>{{ $users->count() }}</strong></div>
        </div>
    </div>

    {{-- ── TABLE CARD ─────────────────────────────────────────── --}}
    <div class="um-card">
        <div class="um-card-header">
            <div class="icon-circle"><i class="fas fa-list"></i></div>
            <h6>{{ $requestedRole == 'user' ? 'Users' : ucfirst($requestedRole) }} Directory</h6>
        </div>

        <div style="padding:20px 24px">
            @if($users->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-user-slash"></i></div>
                    <p>No {{ strtolower($requestedRole == 'user' ? 'users' : ucfirst($requestedRole)) }} found. Start by adding one!</p>
                    @can('users.create')
                        @if(!in_array(strtolower($requestedRole), ['employee', 'customer']))
                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.create') }}?role={{ $requestedRole }}"
                               class="um-add-btn" style="display:inline-flex;margin-top:12px;">
                                <i class="fas fa-plus"></i> Add First {{ $requestedRole == 'user' ? 'User' : rtrim(ucfirst($requestedRole), 's') }}
                            </a>
                        @endif
                    @endcan
                </div>
            @else
                <div class="table-responsive">
                    <table class="table" width="100%" id="UserTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $avatarColors = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#06b6d4'];
                                $ci = 0;
                            @endphp
                            @foreach ($users as $user)
                                @php $ci++; $color = $avatarColors[$ci % count($avatarColors)]; @endphp
                                <tr>
                                    {{-- ID --}}
                                    <td>
                                        <span class="code-badge">{{ $user->user_code ?? 'N/A' }}</span>
                                    </td>

                                    {{-- User (avatar + name + email) --}}
                                    <td>
                                        <div class="user-cell">
                                            @if ($user->profile_picture)
                                                <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                                     class="user-avatar" alt="{{ $user->name }}">
                                            @else
                                                <div class="avatar-initials" style="background:{{ $color }}">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="user-name">{{ $user->name }}</p>
                                                <p class="user-email">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Phone --}}
                                    <td>
                                        @if($user->phone)
                                            <span style="font-size:.85rem">
                                                <i class="fas fa-phone-alt" style="color:#27ae60;font-size:.7rem;margin-right:4px;"></i>
                                                {{ $user->phone }}
                                            </span>
                                        @else
                                            <span style="color:#d1d9e4">—</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        <select class="status-pill {{ $user->status == 'active' ? 'active-pill' : 'inactive-pill' }} status-select"
                                                data-user-id="{{ $user->id }}"
                                                onchange="this.className='status-pill status-select '+(this.value==='active'?'active-pill':'inactive-pill')">
                                            <option value="active"   {{ $user->status == 'active'   ? 'selected' : '' }}>● Active</option>
                                            <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>● Inactive</option>
                                        </select>
                                    </td>

                                    {{-- Date --}}
                                    <td>
                                        <span class="date-cell">
                                            <i class="fas fa-calendar-alt" style="margin-right:4px;color:#c4c9dc;"></i>
                                            {{ $user->created_at->format('d M Y') }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td>
                                        <div class="action-group">
                                            @can('users.show')
                                                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.show', $user) }}"
                                                   class="action-btn btn-view" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endcan
                                            @can('users.edit')
                                                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.edit', $user) }}"
                                                   class="action-btn btn-edit" title="Edit User">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            @endcan
                                            @can('users.delete')
                                                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.users.destroy', $user) }}"
                                                      method="POST" class="d-inline" id="del-form-{{ $user->id }}">
                                                    @csrf @method('DELETE')
                                                    <button type="button"
                                                            class="action-btn btn-del"
                                                            title="Delete User"
                                                            onclick="confirmDelete({{ $user->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">{{ $users->appends(['role' => $requestedRole])->links() }}</div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ── DataTable Init ───────────────────────────────────────────
    $('#UserTable').DataTable({
        pageLength: 5,
        language: {
            search: '',
            searchPlaceholder: '🔍  Search...',
            lengthMenu: 'Show _MENU_',
            info: 'Showing _START_–_END_ of _TOTAL_',
            paginate: { previous: '‹', next: '›' }
        }
    });

    // ── Status Change ────────────────────────────────────────────
    $(document).on('change', '.status-select', function () {
        var userId = $(this).data('user-id');
        var status = $(this).val();
        var role   = '{{ auth()->user()->getRoleNames()->first() }}';
        var url    = '/' + role + '/users/' + userId + '/status';

        $.ajax({
            url: url, type: 'PATCH',
            data: { _token: '{{ csrf_token() }}', status: status },
            success: function (res) {
                Swal.fire({ toast:true, position:'top-end', icon:'success', title: res.message, showConfirmButton:false, timer:2500, timerProgressBar:true });
            },
            error: function () {
                Swal.fire({ toast:true, position:'top-end', icon:'error', title:'Error updating status', showConfirmButton:false, timer:2500 });
            }
        });
    });

    // ── Delete Confirm ───────────────────────────────────────────
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete User?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor:  '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            borderRadius: '16px'
        }).then(function (res) {
            if (res.isConfirmed) { $('#del-form-' + id).submit(); }
        });
    }

    // ── Session Toasts ─────────────────────────────────────────
    @if (session('success'))
        Swal.fire({ toast:true, position:'top-end', icon:'success', title:'{{ session('success') }}', showConfirmButton:false, timer:3000, timerProgressBar:true });
    @endif
    @if (session('error'))
        Swal.fire({ toast:true, position:'top-end', icon:'error', title:'{{ session('error') }}', showConfirmButton:false, timer:3000, timerProgressBar:true });
    @endif
</script>
@endsection
