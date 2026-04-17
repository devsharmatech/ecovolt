@extends('admin.layouts.master')

@section('title')
    Lead Management
@endsection
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

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .lead-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-top: 20px;
    }

    .table th {
        background-color: #f1f5fd;
        color: #2c3e50;
        font-weight: 600;
        border-top: none;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-open {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .badge-contracted {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .badge-qualified {
        background-color: #fff3e0;
        color: #f57c00;
    }

    .badge-nurturing {
        background-color: #f3e5f5;
        color: #7b1fa2;
    }

    .badge-won {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .badge-lost {
        background-color: #ffebee;
        color: #c62828;
    }

    .search-box {
        max-width: 300px;
    }

    .action-btn {
        margin: 0 3px;
        padding: 5px 10px;
        font-size: 13px;
    }

    .action-buttons {
        min-width: 200px;
    }

    .avatar-placeholder {
        width: 30px;
        height: 30px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }

    .lead-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .company-name {
        color: #6c757d;
        font-size: 14px;
    }
</style>


@section('content')
    <div class="container-fluid">
        <div class="lead-container">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-black">
                        Lead Management
                    </h1>
                    <p class="text-muted mb-0">Manage and track all your leads in one place</p>
                </div>
                <div>
                    @can('leads.create')
                    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.leads.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add New Lead
                    </a>
                    @endcan
                </div>
            </div>

            <!-- Search and Action Bar -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <!-- Change these buttons -->
                <div>
                    <a href="{{ route('admin.leads.import.form') }}" class="btn btn-outline-primary me-2">
                        <i class="bi bi-upload me-1"></i> Import Leads
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                        data-bs-target="#exportModal">
                        <i class="bi bi-download me-1"></i> Export Leads
                    </button>
                </div>
            </div>

            <!-- Leads Table -->
            <div class="table-responsive">
                <table class="table table-hover" id="leadTable">
                    <thead>
                        <tr>
                            <th>Lead Name</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Owner</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td>
                                    <div class="lead-name">{{ $lead->local_name }}</div>
                                    <div class="company-name">ID: #{{ $lead->id }}</div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building me-2 text-secondary"></i>
                                        <span>{{ $lead->company }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match (strtolower($lead->status)) {
                                            'open' => 'badge-open',
                                            'contracted' => 'badge-contracted',
                                            'qualified' => 'badge-qualified',
                                            'nurturing' => 'badge-nurturing',
                                            'closed - won' => 'badge-won',
                                            'closed - lost' => 'badge-lost',
                                            default => 'badge-open',
                                        };
                                    @endphp
                                    <span class="badge-status {{ $statusClass }}">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person text-secondary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $lead->owner }}</div>
                                            <small class="text-muted">Sales</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-medium">{{ $lead->formatted_created_date }}</div>
                                    <small class="text-muted">{{ $lead->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <div class="d-flex action-buttons">
                                        @can('leads.edit')
                                        <a href="{{ route(auth()->user()->getRoleNames()->first() .'.leads.edit', $lead) }}" style="height: 25px;"
                                            class="btn btn-sm btn-primary action-btn" title="Edit Lead">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @endcan
                                        <button type="button" class="btn btn-sm btn-secondary action-btn"
                                            style="height: 25px;" data-bs-toggle="modal"
                                            data-bs-target="#assignModal{{ $lead->id }}" title="Assign Lead">
                                            <i class="bi bi-person-plus"></i>
                                        </button>

                                        <form action="{{ route(auth()->user()->getRoleNames()->first() .'.leads.archive', $lead) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-warning action-btn"
                                                style="height: 25px;"
                                                onclick="return confirm('Are you sure you want to archive this lead?')"
                                                title="Archive Lead">
                                                <i class="bi bi-archive"></i>
                                            </button>
                                        </form>
                                        @can('leads.delete')
                                        <form action="{{ route(auth()->user()->getRoleNames()->first() .'.leads.destroy', $lead) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger action-btn"
                                                style="height: 25px;"
                                                onclick="return confirm('Are you sure you want to delete this lead?')"
                                                title="Delete Lead">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>

                                    <!-- Assign Modal -->
                                    <div class="modal fade" id="assignModal{{ $lead->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.leads.assign', $lead) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Assign Lead to Owner</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="owner{{ $lead->id }}" class="form-label">Select
                                                                Owner</label>
                                                            <select class="form-select" id="owner{{ $lead->id }}"
                                                                name="owner">
                                                                <option value="John Doe"
                                                                    {{ $lead->owner == 'John Doe' ? 'selected' : '' }}>John
                                                                    Doe</option>
                                                                <option value="Jane Smith"
                                                                    {{ $lead->owner == 'Jane Smith' ? 'selected' : '' }}>
                                                                    Jane Smith</option>
                                                                <option value="Mike Johnson"
                                                                    {{ $lead->owner == 'Mike Johnson' ? 'selected' : '' }}>
                                                                    Mike Johnson</option>
                                                                <option value="Sarah Wilson"
                                                                    {{ $lead->owner == 'Sarah Wilson' ? 'selected' : '' }}>
                                                                    Sarah Wilson</option>
                                                            </select>
                                                        </div>
                                                        <div class="alert alert-info">
                                                            <i class="bi bi-info-circle me-2"></i>
                                                            This will reassign the lead to the selected team member.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Assign
                                                            Lead</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                    <h5>No leads found</h5>
                                    <p>Start by adding your first lead!</p>
                                    @can('leads.create')
                                    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.leads.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i> Create Lead
                                    </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.leads.export') }}" method="GET" id="exportForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Export Leads</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="export_status" class="form-label">Filter by Status</label>
                            <select class="form-select" id="export_status" name="status">
                                <option value="all">All Leads</option>
                                <option value="Open">Open</option>
                                <option value="Qualified">Qualified</option>
                                <option value="Contracted">Contracted</option>
                                <option value="Nurturing">Nurturing</option>
                                <option value="Closed - Won">Closed - Won</option>
                                <option value="Closed - Lost">Closed - Lost</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Export Format</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="format_xlsx"
                                    value="xlsx" checked>
                                <label class="form-check-label" for="format_xlsx">
                                    <i class="bi bi-file-earmark-excel text-success me-1"></i> Excel (.xlsx)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="format_csv"
                                    value="csv">
                                <label class="form-check-label" for="format_csv">
                                    <i class="bi bi-filetype-csv text-primary me-1"></i> CSV (.csv)
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            The export will include all lead data including contact information and notes.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-download me-1"></i> Export Leads
                        </button>
                    </div>
                </form>
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

        $('#leadTable').DataTable({
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
        // Search functionality
        document.querySelector('input[placeholder="Search leads by name, company, status..."]').addEventListener('keyup',
            function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                let visibleCount = 0;

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show message if no results
                const emptyRow = document.querySelector('tbody tr[colspan]');
                if (emptyRow) {
                    if (visibleCount === 0 && searchTerm !== '') {
                        emptyRow.style.display = '';
                        emptyRow.innerHTML = `
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-search display-6 d-block mb-2"></i>
                        <h5>No matching leads found</h5>
                        <p>Try different search terms</p>
                    </td>
                `;
                    } else if (searchTerm === '') {
                        emptyRow.style.display = 'none';
                    }
                }
            });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
