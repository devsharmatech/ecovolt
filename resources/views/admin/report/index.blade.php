@extends('admin.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .document-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .status-verified {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .view-document {
        cursor: pointer;
        color: #3b82f6;
        text-decoration: underline;
    }
</style>

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Report & Analytics</h1>
            <div>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#helpModal">
                    <i class="bi bi-question-circle"></i> Help
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filters</h5>
            </div>
            <div class="card-body filter-section">
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.reports.filter') }}" method="GET"
                    id="filterForm">
                    <div class="row g-3">
                        <!-- Document Type -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Document Type</label>
                            <select class="form-select" name="document_type">
                                <option value="All">All Types</option>
                                @foreach ($documentTypes as $type)
                                    <option value="{{ $type }}"
                                        {{ request('document_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select" name="status">
                                <option value="All">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>
                                    Verified
                                </option>
                            </select>
                        </div>

                        <!-- Lead Name -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Lead Name</label>
                            <select class="form-select " name="lead_id">
                                <option value="All">All Leads</option>
                                @foreach ($leads as $lead)
                                    <option value="{{ $lead->id }}"
                                        {{ request('lead_id') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->local_name }} ({{ $lead->company }})
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-12 mt-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-filter me-1"></i> Apply Filters
                                </button>
                                <button type="button" onclick="resetFilters()" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                </button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report Summary -->
        <div class="print-details">
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card summary-card-1 h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-files fs-1 mb-3 opacity-75"></i>
                            <h2 class="card-title fw-bold">{{ number_format($summary['total_documents']) }}</h2>
                            <p class="card-text fw-medium">Total Documents</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card summary-card-2 h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-check-circle fs-1 mb-3 opacity-75"></i>
                            <h2 class="card-title fw-bold">{{ number_format($summary['verified_documents']) }}</h2>
                            <p class="card-text fw-medium">Verified Documents</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card summary-card-3 h-100 border-0 shadow">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-clock fs-1 mb-3 opacity-75"></i>
                            <h2 class="card-title fw-bold">{{ number_format($summary['pending_documents']) }}</h2>
                            <p class="card-text fw-medium">Pending Documents</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card h-100 border-0 shadow"
                        style="background: linear-gradient(135deg, #86efac 0%, #4ade80 100%) !important;">
                        <div class="card-body text-center p-4">
                            <i class="bi bi-percent fs-1 mb-3 opacity-75"></i>
                            <h2 class="card-title fw-bold">{{ $summary['verification_rate'] }}%</h2>
                            <p class="card-text fw-medium">Verification Rate</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="card border-0 shadow">
                <div
                    class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3">
                    <h4 class="mb-3 mb-md-0"><i class="bi bi-table me-2"></i>Document Reports</h4>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-danger btn-sm" onclick="downloadReport('pdf')">
                            <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                        </button>
                        <button class="btn btn-outline-success btn-sm" onclick="downloadReport('excel')">
                            <i class="bi bi-file-earmark-excel me-1"></i> Excel
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="printReport()">
                            <i class="bi bi-printer me-1"></i> Print
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if ($documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="reportTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Document Type</th>
                                        <th>Lead Name</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Uploaded Date</th>
                                        <th>Verified Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $index => $document)
                                        <tr>
                                            <td>{{ $loop->iteration + ($documents->currentPage() - 1) * $documents->perPage() }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person-circle me-2 text-primary"></i>
                                                    {{ $document->customer_name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                                    {{ ucfirst(str_replace('_', ' ', $document->document_type)) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($document->lead)
                                                    <div class="fw-medium">{{ $document->lead->local_name }}</div>
                                                @else
                                                    <span class="text-muted fst-italic">No Lead</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($document->lead)
                                                    {{ $document->lead->company }}
                                                @else
                                                    <span class="text-muted fst-italic">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="document-status status-{{ $document->status }}">
                                                    {{ ucfirst($document->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <i class="bi bi-calendar me-1 text-muted"></i>
                                                {{ \Carbon\Carbon::parse($document->uploaded_date)->format('d M Y') }}
                                            </td>
                                            <td>
                                                @if ($document->verified_date)
                                                    <i class="bi bi-calendar-check me-1 text-muted"></i>
                                                    {{ \Carbon\Carbon::parse($document->verified_date)->format('d M Y') }}
                                                @else
                                                    <span class="text-muted fst-italic">Not Verified</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    @if ($document->document_path)
                                                        <a href="{{ Storage::url($document->document_path) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary"
                                                            title="View Document">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ Storage::url($document->document_path) }}" download
                                                            class="btn btn-sm btn-outline-secondary" title="Download">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    @else
                                                        <span class="badge bg-secondary">No File</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $documents->firstItem() ?? 0 }} to {{ $documents->lastItem() ?? 0 }}
                                of {{ $documents->total() }} entries
                            </div>
                            <nav aria-label="Page navigation">
                                {{ $documents->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-inbox fs-1 text-muted opacity-50"></i>
                            </div>
                            <h4 class="text-muted mb-3">No documents found</h4>
                            <p class="text-muted mb-4">Try adjusting your filter criteria or upload new documents</p>
                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.documents.index') }}"
                                class="btn btn-primary">
                                <i class="bi bi-arrow-left me-1"></i> Go to Documents
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="helpModalLabel"><i class="bi bi-question-circle me-2"></i>Report Help
                        Guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>How to use:</h6>
                    <ul class="mb-3">
                        <li>Use filters to narrow down documents</li>
                        <li>Click on "View" to open document</li>
                        <li>Use Download buttons to export data</li>
                        <li>Status badges show verification status</li>
                    </ul>

                    <h6>Filter Tips:</h6>
                    <ul>
                        <li>Select "All" to remove specific filter</li>
                        <li>Use Lead dropdown to filter by customer</li>
                        <li>Date range filters by upload date</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <script>
        $(document).ready(function() {


            // Initialize DataTable with better configuration
            $('#reportTable').DataTable({
                "paging": false, // Disable DataTable pagination since we have Laravel pagination
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "language": {
                    "search": "Search in table:",
                    "searchPlaceholder": "Type to search...",
                    "zeroRecords": "No matching records found",
                    "infoEmpty": "No records available",
                },
                "dom": '<"row"<"col-sm-12"f>>' + // Only show search box
                    '<"row"<"col-sm-12"tr>>' + // Table rows
                    '<"row"<"col-sm-12"i>>', // Information
                "initComplete": function(settings, json) {
                    // Add custom search box
                    $('.dataTables_filter input').addClass('form-control form-control-sm');
                }
            });

            // Set default end date to today if empty
            if (!$('input[name="end_date"]').val()) {
                const today = new Date().toISOString().split('T')[0];
                $('input[name="end_date"]').val(today);
            }

            // Set default start date to 30 days ago if empty
            if (!$('input[name="start_date"]').val()) {
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
                $('input[name="start_date"]').val(thirtyDaysAgo.toISOString().split('T')[0]);
            }
        });

        function resetFilters() {
            // Reset form
            document.getElementById('filterForm').reset();

            // Reset dates to default
            const today = new Date().toISOString().split('T')[0];
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);

            $('input[name="end_date"]').val(today);
            $('input[name="start_date"]').val(thirtyDaysAgo.toISOString().split('T')[0]);

            // Reset Select2
            $('#leadSelect').val('All').trigger('change');

            // Submit form to show all results
            window.location.href = "{{ route(auth()->user()->getRoleNames()->first() . '.reports.index') }}";
        }

        function downloadReport(type) {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (const [key, value] of formData) {
                if (value && value !== 'All') {
                    params.append(key, value);
                }
            }

            let url = '';
            if (type === 'pdf') {
                url = "{{ route(auth()->user()->getRoleNames()->first() . '.reports.download.pdf') }}";

                // Show loading message for PDF generation
                Swal.fire({
                    title: 'Generating PDF',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            } else {
                url = "{{ route(auth()->user()->getRoleNames()->first() . '.reports.download.excel') }}";
            }

            // Open in new tab for PDF, same tab for Excel
            if (type === 'pdf') {
                window.open(url + '?' + params.toString(), '_blank');
                Swal.close();
            } else {
                window.location.href = url + '?' + params.toString();
            }
        }

        function printReport() {
            const printContent = document.querySelector('.print-details').innerHTML;
            const originalContent = document.body.innerHTML;

            document.body.innerHTML = `
            <div class="container mt-4">
                <h2 class="text-center mb-4">Document Report - {{ date('d M Y') }}</h2>
                ${printContent}
            </div>
        `;

            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload(); // Reload to restore functionality
        }

        // Show success/error messages
        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#f0f9ff',
                color: '#0369a1'
            });
        @endif

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

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endsection
