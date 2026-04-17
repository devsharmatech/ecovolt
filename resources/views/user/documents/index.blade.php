@extends('admin.layouts.master')

@section('title', 'Documents Management')


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .swal2-toast {
        font-size: 12px !important;
        padding: 6px 10px !important;
        min-width: auto !important;
        width: 220px !important;
        line-height: 1.3em !important;
    }

    .swal2-toast .swal2-icon {
        width: 24px !important;
        height: 24px !important;
        margin-right: 6px !important;
    }

    .swal2-toast .swal2-title {
        font-size: 13px !important;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle;
    }

    .btn-group .btn {
        margin-right: 4px;
        border-radius: 4px !important;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .border-bottom {
        border-bottom: 2px solid #dee2e6 !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        margin: 10px 0;
        padding: 10px;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 5px 10px;
        margin-left: 10px;
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 5px;
        margin: 0 5px;
    }

    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        color: white;
        border-bottom: none;
        padding: 1.25rem 1.5rem;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
    }

    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 0;
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea;
        background-color: rgba(102, 126, 234, 0.05);
    }

    .nav-tabs .nav-link.active {
        color: #667eea;
        background-color: transparent;
        border-bottom: 3px solid #667eea;
        font-weight: 600;
    }

    .badge-pill {
        border-radius: 10rem;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: nowrap;
    }

    .action-buttons .btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05);
        transform: translateY(-1px);
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .status-badge {
        padding: 0.4em 0.8em;
        border-radius: 20px;
        font-weight: 500;
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        padding-left: 40px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.3s;
    }

    .search-box input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
    }

    .dataTables_empty {
        text-align: center;
        padding: 40px !important;
        color: #6c757d;
        font-size: 1.1em;
    }
</style>


@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            Documents Management
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs mb-4" id="docTabs">
                            <li class="nav-item">
                                <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.index', ['filter' => 'all']) }}"
                                    class="nav-link {{ $filter === 'all' ? 'active' : '' }}">
                                    All Documents
                                    <span class="badge bg-secondary badge-pill ms-1">{{ $allCount }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.index', ['filter' => 'pending']) }}"
                                    class="nav-link {{ $filter === 'pending' ? 'active' : '' }}">
                                    Pending
                                    <span class="badge bg-warning badge-pill ms-1">{{ $pendingCount }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.index', ['filter' => 'verified']) }}"
                                    class="nav-link {{ $filter === 'verified' ? 'active' : '' }}">
                                    Verified
                                    <span class="badge bg-success badge-pill ms-1">{{ $verifiedCount }}</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Search and Action Bar -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <form id="searchForm" method="GET">
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                    <div class="search-box">
                                        <i class="fas fa-search search-icon"></i>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search by customer name, document type..."
                                            value="{{ $search }}" id="searchInput">
                                        @if ($search)
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.index', ['filter' => $filter]) }}"
                                                class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-2 text-danger">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                @can('documents.create')
                                <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add New Document
                                </a>
                                @endcan
                            </div>
                        </div>

                        <!-- Documents Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="documentsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Document Type</th>
                                        <th>Status</th>
                                        <th>Uploaded Date</th>
                                        <th>Verified Date</th>
                                        <th style="min-width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($documents as $document)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-3">
                                                        <p class="fw-bold mb-0">{{ $document->customer_name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2">
                                                    <i class="fas fa-file me-1"></i>{{ $document->document_type }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($document->status === 'verified')
                                                    <span class="status-badge bg-success bg-opacity-10 text-success">
                                                        <i class="fas fa-check-circle me-1"></i>Verified
                                                    </span>
                                                @else
                                                    <span class="status-badge bg-warning bg-opacity-10 text-warning">
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $document->uploaded_date->format('Y-m-d') }}</td>
                                            <td>
                                                {{ $document->verified_date ? $document->verified_date->format('Y-m-d') : 'Not Verified' }}
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    @can('documents.show')
                                                    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.show', $document) }}"
                                                        class="btn btn-sm btn-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @endcan
                                                    @can('documents.edit')
                                                    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.edit', $document) }}"
                                                        class="btn btn-sm btn-secondary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @if ($document->status === 'pending')
                                                        <form action="{{ route(auth()->user()->getRoleNames()->first() .'.documents.verify', $document) }}"
                                                            method="POST" class="d-inline verify-form">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Verify">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @can('documents.delete')
                                                    <form action="{{ route(auth()->user()->getRoleNames()->first() .'.documents.destroy', $document) }}"
                                                        method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="fas fa-folder-open fa-2x text-muted mb-3"></i>
                                                <p class="text-muted">No documents found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
        $(document).ready(function() {


            $('#documentsTable').DataTable({
                "pageLength": 5,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ ",
                    "info": "Showing _START_ to _END_ of _TOTAL_ ",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    }
                }
            });

            // Handle search form submission
            $('#searchInput').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    $('#searchForm').submit();
                }
            });

            // Handle verify form submission
            $('.verify-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Verify Document?',
                    text: "Are you sure you want to verify this document?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, verify it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // Handle delete form submission
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete Document?',
                    text: "Are you sure you want to delete this document? This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // Show success/error messages
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // Display error message from session if exists
            @if (session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
        });
    </script>
@endsection
