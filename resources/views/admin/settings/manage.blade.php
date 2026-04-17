@extends('admin.layouts.master')

@section('title', 'White-label Settings')

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

    .color-preview {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .primary-color-sample,
    .secondary-color-sample {
        min-width: 150px;
        text-align: center;
        transition: all 0.3s ease;
    }

    input[type="color"] {
        cursor: pointer;
        padding: 0;
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">White-label Settings</h4>
                        <p class="card-category">Customise the branding and appearance of your application for each tenant.
                        </p>
                    </div>
                    <div class="card-body">



                        <form method="POST" action="{{ route('admin.settings.update') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">
                                    <h5>Application Logo</h5>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo_url">
                                            <strong>Logo URL</strong>
                                        </label>
                                        <input type="text" class="form-control" id="logo_url" name="logo_url"
                                            value="{{ old('logo_url', $settings->logo_url ?? '') }}"
                                            placeholder="Enter the URL for the application logo">
                                        <small class="form-text text-muted">
                                            Enter the full URL of your logo image
                                        </small>
                                    </div>
                                </div>

                                @if ($settings->logo_url)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Logo Preview</label>
                                            <div class="mt-2">
                                                <img src="{{ $settings->logo_url }}" alt="Logo Preview"
                                                    class="img-thumbnail" style="max-height: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Branding</h5>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primary_color">
                                            <strong>Primary Color</strong>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="primary_color"
                                                name="primary_color"
                                                value="{{ old('primary_color', $settings->primary_color ?? '#007bff') }}"
                                                placeholder="Enter the primary color for the application">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <input type="color" id="primary_color_picker"
                                                        value="{{ old('primary_color', $settings->primary_color ?? '#007bff') }}"
                                                        style="width: 30px; height: 30px; border: none;">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="secondary_color">
                                            <strong>Secondary Color</strong>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="secondary_color"
                                                name="secondary_color"
                                                value="{{ old('secondary_color', $settings->secondary_color ?? '#6c757d') }}"
                                                placeholder="Enter the secondary color for the application">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <input type="color" id="secondary_color_picker"
                                                        value="{{ old('secondary_color', $settings->secondary_color ?? '#6c757d') }}"
                                                        style="width: 30px; height: 30px; border: none;">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="color-preview p-3 rounded">
                                        <h6>Color Preview:</h6>
                                        <div class="d-flex">
                                            <div class="primary-color-sample mr-3 p-3 rounded"
                                                style="background-color: {{ $settings->primary_color ?? '#007bff' }}; color: white; margin-right: 12px;">
                                                Primary Color
                                            </div>
                                            <div class="secondary-color-sample p-3 rounded"
                                                style="background-color: {{ $settings->secondary_color ?? '#6c757d' }}; color: white;">
                                                Secondary Color
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Subdomain Settings</h5>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subdomain_prefix">
                                            <strong>Subdomain Prefix</strong>
                                        </label>
                                        <input type="text" class="form-control" id="subdomain_prefix"
                                            name="subdomain_prefix"
                                            value="{{ old('subdomain_prefix', $settings->subdomain_prefix ?? '') }}"
                                            placeholder="Enter the subdomain prefix for the tenant">
                                        <small class="form-text text-muted">
                                            Only letters, numbers, dashes and underscores allowed
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>Email Templates</h5>
                                    <hr>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="welcome_email_template">
                                            <strong>Welcome Email Template</strong>
                                        </label>
                                        <input type="text" class="form-control" id="welcome_email_template"
                                            name="welcome_email_template"
                                            value="{{ old('welcome_email_template', $settings->welcome_email_template ?? '') }}"
                                            placeholder="Enter the URL or path for the welcome email template">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_reset_email_template">
                                            <strong>Password Reset Email Template</strong>
                                        </label>
                                        <input type="text" class="form-control" id="password_reset_email_template"
                                            name="password_reset_email_template"
                                            value="{{ old('password_reset_email_template', $settings->password_reset_email_template ?? '') }}"
                                            placeholder="Enter the URL or path for the password reset email template">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <hr>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Settings
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                                    </a>
                                </div>
                            </div>
                        </form>
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
        // Color picker functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Primary color picker
            const primaryColorInput = document.getElementById('primary_color');
            const primaryColorPicker = document.getElementById('primary_color_picker');
            const primaryColorSample = document.querySelector('.primary-color-sample');

            primaryColorPicker.addEventListener('input', function() {
                primaryColorInput.value = this.value;
                if (primaryColorSample) {
                    primaryColorSample.style.backgroundColor = this.value;
                }
            });

            primaryColorInput.addEventListener('input', function() {
                primaryColorPicker.value = this.value;
                if (primaryColorSample) {
                    primaryColorSample.style.backgroundColor = this.value;
                }
            });

            // Secondary color picker
            const secondaryColorInput = document.getElementById('secondary_color');
            const secondaryColorPicker = document.getElementById('secondary_color_picker');
            const secondaryColorSample = document.querySelector('.secondary-color-sample');

            secondaryColorPicker.addEventListener('input', function() {
                secondaryColorInput.value = this.value;
                if (secondaryColorSample) {
                    secondaryColorSample.style.backgroundColor = this.value;
                }
            });

            secondaryColorInput.addEventListener('input', function() {
                secondaryColorPicker.value = this.value;
                if (secondaryColorSample) {
                    secondaryColorSample.style.backgroundColor = this.value;
                }
            });
        });
    </script>
@endsection
