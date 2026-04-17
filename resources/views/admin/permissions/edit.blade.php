@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-lg">
            <div class="card-header text-dark d-flex justify-content-between align-items-center"
                style="background-color: lightgray; color:black !important;">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Permission
                </h5>
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.permissions.index') }}"
                    class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Permissions
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.permissions.update', $permission->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-key me-2"></i>Permission Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter permission name (e.g., users.create, posts.delete)" required
                                    value="{{ old('name', $permission->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Use dot notation for better organization (e.g., module.action)
                                </small>
                            </div>



                        </div>


                    </div>

                    <div class="mt-4 pt-3 border-top">
                        @can('permissions.update')
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="fas fa-save me-2"></i> Update Permission
                            </button>
                        @endcan
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.permissions.index') }}"
                            class="btn btn-outline-secondary btn-sm px-4 ms-2">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>


                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @can('permissions.delete')
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>Delete Permission
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this permission?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Warning:</strong> This action cannot be undone. All role assignments for this permission
                            will be removed.
                        </div>
                        <p class="mb-0">
                            <strong>Permission:</strong> {{ $permission->name }}<br>
                            <strong>ID:</strong> #{{ $permission->id }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <form
                            action="{{ route(auth()->user()->getRoleNames()->first() . '.permissions.destroy', $permission->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Delete Permission
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <style>
        .card {
            border-radius: 10px;
            border: none;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #fd7e14;
            box-shadow: 0 0 0 0.25rem rgba(253, 126, 20, 0.15);
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border: none;
            color: white;
            transition: all 0.3s;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            color: white;
        }

        .btn-light {
            border: 1px solid #dee2e6;
        }

        .border-warning {
            border-color: #f59e0b !important;
        }

        .bg-warning {
            background-color: #f59e0b !important;
        }

        .badge {
            font-size: 0.85em;
            padding: 4px 10px;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
        }
    </style>

    <!-- Bootstrap JS for modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
