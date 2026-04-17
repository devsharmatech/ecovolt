@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Details</h1>
            <div>

                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        @if ($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}"
                                class="rounded-circle img-thumbnail mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3"
                                style="width: 150px; height: 150px;">
                                <span class="text-white" style="font-size: 48px;">
                                    {{ substr($user->name, 0, 1) }}
                                </span>
                            </div>
                        @endif

                        <h4>{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>

                        <div class="mb-3">
                            <span
                                class="badge badge-{{ $user->user_type == 'admin' ? 'danger' : ($user->user_type == 'vendor' ? 'warning' : 'info') }} p-2">
                                {{ ucfirst($user->user_type) }}
                            </span>
                            <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }} p-2">
                                {{ ucfirst($user->status) }}
                            </span>
                            @if ($user->is_admin)
                                <span class="badge badge-primary p-2">Admin Privileges</span>
                            @endif
                        </div>

                        <hr>

                        <div class="text-left">
                            <p><strong><i class="fas fa-phone"></i> Phone:</strong> {{ $user->phone }}</p>
                            <p><strong><i class="fas fa-venus-mars"></i> Gender:</strong> {{ ucfirst($user->gender) }}</p>
                            <p><strong><i class="fas fa-map-marker-alt"></i> Locality:</strong>
                                {{ $user->locality ?? 'N/A' }}</p>
                            <p><strong><i class="fas fa-calendar-alt"></i> Registered:</strong>
                                {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Email Verified:</strong>
                                <br>
                                @if ($user->email_verified_at)
                                    <span class="badge badge-success" style="color: green">Yes
                                        ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                                @else
                                    <span class="badge badge-warning" style="color: rgb(255, 0, 0)">Not Verified</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <strong>Last Login:</strong>
                                <br>
                                @if ($user->last_login)
                                    {{ $user->last_login->diffForHumans() }}
                                @else
                                    <span class="text-muted">Never logged in</span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <h6 class="font-weight-bold mb-3">Address Details</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <strong>Address:</strong>
                                <br>
                                {{ $user->locality ?? 'N/A' }}
                            </div>


                        </div>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Account Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">



                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status_change">Change Status:</label>
                                    <select class="form-control" id="status_change" data-user-id="{{ $user->id }}">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Status change handler
            $('#status_change').change(function() {
                const userId = $(this).data('user-id');
                const status = $(this).val();

                $.ajax({
                    url: "{{ url('admin/users') }}/" + userId + "/status",
                    method: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        // Update badge
                        const badge = $('.badge[class*="badge-"]').filter(function() {
                            return $(this).text().toLowerCase() === 'active' || $(this)
                                .text().toLowerCase() === 'inactive';
                        });
                        badge.removeClass('badge-success badge-danger')
                            .addClass(status === 'active' ? 'badge-success' : 'badge-danger')
                            .text(status.charAt(0).toUpperCase() + status.slice(1));
                    },
                    error: function(xhr) {
                        toastr.error('Error updating status');
                        location.reload();
                    }
                });
            });
        });
    </script>
@endpush
