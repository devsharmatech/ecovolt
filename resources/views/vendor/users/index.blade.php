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
            <h1 class="h3 mb-0 text-gray-800">Users Management</h1>
            @can('users.create')
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New User
                </a>
            @endcan
        </div>



        <div class="card shadow mb-4">
            <div class="card-body table-responsive">
                <table class="table table-bordered" width="100%" id="UserTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>

                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>
                                    @if ($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" width="40"
                                            height="40" class="rounded-circle">
                                    @else
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                            style="width:40px;height:40px;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>

                                <td>
                                    <select class="form-control form-control-sm status-select"
                                        data-user-id="{{ $user->id }}">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        @can('users.show')
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.show', $user) }}"
                                                style="height: 25px;" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                        @endcan
                                        @can('users.edit')
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.edit', $user) }}"
                                                style="height: 25px;" class="btn btn-sm btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('users.delete')
                                            <form
                                                action="{{ route(auth()->user()->getRoleNames()->first() . '.users.destroy', $user) }}"
                                                method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" style="height: 25px;"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links() }}
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
        $('.status-select').change(function() {
            var userId = $(this).data('user-id');
            var status = $(this).val();

            // Get the current user's role
            var role = '{{ auth()->user()->getRoleNames()->first() }}';

            // Build the route dynamically
            var url = '/' + role + '/users/' + userId + '/status';

            $.ajax({
                url: url,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(res) {
                    // Use Swal2 for toast notification instead of toastr
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error updating status',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    // Optionally revert the select on error
                    $(this).val($(this).data('previous-value'));
                }
            });
        });

        $('#UserTable').DataTable({
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
    </script>
@endsection
