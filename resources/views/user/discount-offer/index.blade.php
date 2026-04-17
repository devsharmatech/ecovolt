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

    /* Add this to your CSS file */
    .badge-success {
        background-color: #28a745 !important;
        color: white !important;
    }

    .badge-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    .badge-danger {
        background-color: #dc3545 !important;
        color: white !important;
    }

    .badge-info {
        background-color: #17a2b8 !important;
        color: white !important;
    }

    /* Badge styling */
    .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col mb-2">
                    <h3 class="page-title">Discounts & Offers</h3>

                </div>
                <div class="col-auto mb-2">
                    @can('discount-offers.create')
                    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Rule
                    </a>
                    @endcan
                    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.pending') }}" class="btn btn-warning">
                        <i class="fas fa-clock"></i> Pending Approvals
                        @if ($pendingCount = \App\Models\DiscountOffer::where('status', 'pending')->count())
                            <span class="badge badge-danger">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>



        <!-- Existing Rules Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Existing Rules</h5>
                <p class="card-subtitle">Manage discount rates and offers for stocklines.</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Rule Name</th>
                                <th>Description</th>
                                <th>Discount Type</th>
                                <th>Value</th>
                                <th>Status</th>
                                <th>Applicable To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($discounts as $index => $discount)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $discount->rule_name }}</strong></td>
                                    <td>{{ Str::limit($discount->description, 50) }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $discount->discount_type == 'percentage' ? 'info' : 'success' }}"
                                            style="color: purple">
                                            {{ ucfirst(str_replace('_', ' ', $discount->discount_type)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-weight-bold">{{ $discount->formatted_value }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $discount->status == 'active' ? 'success' : ($discount->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($discount->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $discount->applicable_to ?? 'All Items' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('discount-offers.show')
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.show', $discount) }}"
                                                class="btn btn-sm btn-info" title="View"
                                                style="height:25px;margin-right: 5px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('discount-offers.edit')
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.edit', $discount) }}"
                                                class="btn btn-sm btn-primary" title="Edit"
                                                style="height:25px;margin-right: 5px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('discount-offers.delete')
                                            <form action="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.destroy', $discount) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                    style="height:25px;"
                                                    onclick="return confirm('Are you sure you want to delete this discount rule?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-tags fa-3x mb-3"></i><br>
                                        No discount rules found. 
                                        @can
                                        <a href="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.create') }}">Create your first rule</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
            $('.table').DataTable({
                pageLength: 10,
                ordering: true,
                searching: true,
                responsive: true
            });

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
