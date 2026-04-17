@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-lg">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background-color: #cfcaca; color: black !important;">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Create New Permission
                </h5>
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.permissions.index') }}"
                    class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Permissions
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.permissions.store') }}" method="POST">
                    @csrf

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
                                    value="{{ old('name') }}">
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
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="fas fa-save me-2"></i> Create Permission
                        </button>
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.permissions.index') }}"
                            class="btn btn-outline-secondary btn-sm px-4 ms-2">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }


        .btn-light {
            border: 1px solid #dee2e6;
        }

        .border-info {
            border-color: #0dcaf0 !important;
        }

        .bg-info {
            background-color: #0dcaf0 !important;
        }
    </style>
@endsection
