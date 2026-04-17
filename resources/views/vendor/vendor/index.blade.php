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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vendors Management</h1>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Vendor
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Vendors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->total() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Verified Vendors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::role('vendor')->where('verification_status', 'verified')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Verification</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::role('vendor')->where('verification_status', 'pending')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Rejected Vendors</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::role('vendor')->where('verification_status', 'rejected')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Vendors List</h6>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Active</a>
                        <a class="dropdown-item"
                            href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}">Inactive</a>
                        <a class="dropdown-item"
                            href="{{ request()->fullUrlWithQuery(['verification' => 'verified']) }}">Verified</a>
                        <a class="dropdown-item"
                            href="{{ request()->fullUrlWithQuery(['verification' => 'pending']) }}">Pending</a>
                        <a class="dropdown-item"
                            href="{{ request()->fullUrlWithQuery(['verification' => 'rejected']) }}">Rejected</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                            href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.index') }}">Clear
                            Filters</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="vendorsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vendor</th>
                                <th>Business</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Verification</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/40?text=User' }}"
                                                class="rounded-circle mr-3" width="40" height="40"
                                                alt="{{ $user->name }}">
                                            <div>
                                                <strong>{{ $user->name }}</strong><br>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $user->business_name }}</strong><br>
                                        <small class="text-muted">{{ $user->business_type }}</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-phone text-primary mr-1"></i> {{ $user->phone }}<br>
                                        <i class="fas fa-map-marker-alt text-success mr-1"></i>
                                        {{ $user->business_city ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if ($user->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->verification_status == 'verified')
                                            <span class="badge badge-success" style="color: green">
                                                <i class="fas fa-check-circle"></i> Verified
                                            </span>
                                        @elseif($user->verification_status == 'pending')
                                            <span class="badge badge-warning" style="color: rgb(117, 117, 3)">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @elseif($user->verification_status == 'rejected')
                                            <span class="badge badge-danger" style="color: red;">
                                                <i class="fas fa-times-circle"></i> Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.show', $user->id) }}"
                                                class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.edit', $user->id) }}"
                                                class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete Button with SweetAlert Confirmation -->
                                            <button type="button" class="btn btn-sm btn-danger delete-vendor-btn"
                                                title="Delete" data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-url="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.destroy', $user) }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Laravel Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $users->links() }}
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
            // Initialize DataTable without pagination (using Laravel pagination)
            $('#vendorsTable').DataTable({
                paging: false, // Disable DataTable pagination
                searching: true,
                ordering: true,
                info: false,
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search vendors..."
                }
            });

            // Status change AJAX with fixed route
            $('.status-change').change(function() {
                var userId = $(this).data('user-id');
                var status = $(this).val();
                var url = $(this).data('url').replace(':id', userId);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error updating status',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
            });

            // Delete vendor with SweetAlert confirmation
            $('.delete-vendor-btn').click(function(e) {
                e.preventDefault();

                var vendorId = $(this).data('id');
                var vendorName = $(this).data('name');
                var deleteUrl = $(this).data('url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete vendor: ${vendorName}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create form and submit
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = deleteUrl;

                        var csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        var methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });

            // Toast notification for success messages
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

            // Toast notification for error messages
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

            // Filter dropdown functionality
            $('.dropdown-item').click(function(e) {
                e.preventDefault();
                window.location.href = $(this).attr('href');
            });
        });
    </script>
@endsection
