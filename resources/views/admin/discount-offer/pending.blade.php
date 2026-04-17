@extends('admin.layouts.master')

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
</style>

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h3 class="page-title">Pending Approvals</h3>
                </div>
                <div class="col-auto">
                    @can('discount-offers.view')
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.discount-offer.index') }}"
                            class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Discounts
                        </a>
                    @endcan
                </div>
            </div>
        </div>



        <!-- Pending Approvals Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pending Approvals</h5>
                <p class="card-subtitle">Approve or reject discount rule requests.</p>
            </div>
            <div class="card-body">
                @if ($pendingDiscounts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Rule Name</th>
                                    <th>Description</th>
                                    <th>Discount Type</th>
                                    <th>Value</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingDiscounts as $index => $discount)
                                    <tr id="discount-row-{{ $discount->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $discount->rule_name }}</strong></td>
                                        <td>{{ Str::limit($discount->description, 40) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $discount->discount_type == 'percentage' ? 'badge-info' : 'badge-success' }}">
                                                {{ ucfirst(str_replace('_', ' ', $discount->discount_type)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold">{{ $discount->formatted_value }}</span>
                                        </td>
                                        <td>{{ $discount->created_by }}</td>
                                        <td>{{ $discount->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Approve Button -->
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal{{ $discount->id }}">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>

                                                <!-- Reject Button -->
                                                <button type="button" class="btn btn-sm btn-danger ms-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $discount->id }}">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>

                                                <!-- View Button -->
                                                @can('discount-offers.show')
                                                    <a href="{{ route(auth()->user()->getRoleNames()->first() . '.discount-offer.show', $discount) }}"
                                                        class="btn btn-sm btn-info ms-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                            </div>

                                            <!-- Approve Modal -->
                                            <div class="modal fade" id="approveModal{{ $discount->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form id="approve-form-{{ $discount->id }}"
                                                            action="{{ route(auth()->user()->getRoleNames()->first() . '.discount-offer.approve', $discount) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Approve Discount Rule</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to approve
                                                                    <strong>"{{ $discount->rule_name }}"</strong>?
                                                                </p>
                                                                <div class="form-group">
                                                                    <label>Comments (Optional)</label>
                                                                    <textarea class="form-control" name="comments" rows="3" placeholder="Add comments..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $discount->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form id="reject-form-{{ $discount->id }}"
                                                            action="{{ route(auth()->user()->getRoleNames()->first() . '.discount-offer.reject', $discount) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Reject Discount Rule</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to reject
                                                                    <strong>"{{ $discount->rule_name }}"</strong>?
                                                                </p>
                                                                <div class="form-group">
                                                                    <label class="required">Reason for Rejection</label>
                                                                    <textarea class="form-control" name="rejection_reason" rows="3" required placeholder="Please provide a reason..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fas fa-times"></i> Reject
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clock fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Pending Approvals</h4>
                        <p class="text-muted">All discount rules have been processed.</p>
                    </div>
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
        $(document).ready(function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Initialize Bootstrap modals (if needed)
            var approveModals = document.querySelectorAll('.modal');
            approveModals.forEach(function(modalElement) {
                new bootstrap.Modal(modalElement);
            });

            // Handle form submission
            $('form[id^="approve-form-"], form[id^="reject-form-"]').submit(function(e) {
                // Show loading state
                $(this).find('button[type="submit"]').html(
                    '<i class="fas fa-spinner fa-spin"></i> Processing...'
                ).prop('disabled', true);
            });

            // Clear modal form when closed
            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('button[type="submit"]').html(function() {
                    return $(this).data('original-text') || $(this).text();
                }).prop('disabled', false);
            });

            // Store original button text
            $('.modal').on('show.bs.modal', function() {
                $(this).find('button[type="submit"]').each(function() {
                    $(this).data('original-text', $(this).html());
                });
            });

            // SweetAlert notifications
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
