@extends('admin.layouts.master')

@section('title')
    Edit Lead - {{ $lead->local_name }}
@endsection

<style>
    :root {
        --primary-color: #249722;
        --primary-hover: #249722;
        --primary-light: #e9f7e9;
        --secondary-color: #6c757d;
        --light-bg: #f8f9fa;
        --border-color: #e0e0e0;
        --warning-color: #ffc107;
        --warning-light: #fff3cd;
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .edit-lead-container {
        max-width: 100%;
        width: 100%;
        padding: 0;
    }

    .form-card {
        background: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }

    .form-header {
        background-color: #e0e0e0;
        color: rgb(0, 0, 0) !important;
        padding: 8px 30px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .form-header h4 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgb(0, 0, 0);
    }

    .form-header h4 i {
        font-size: 1.5rem;
    }

    .form-body {
        padding: 35px 40px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-label.required:after {
        content: '*';
        color: #dc3545;
        margin-left: 4px;
    }

    .form-control,
    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(36, 151, 34, 0.25);
    }

    .form-control:hover,
    .form-select:hover {
        border-color: #b0b0b0;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .btn {
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(36, 151, 34, 0.3);
    }

    .btn-warning {
        background-color: var(--warning-color);
        border-color: var(--warning-color);
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    .btn-secondary {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
        transform: translateY(-2px);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 30px;
        border-top: 1px solid var(--border-color);
        margin-top: 20px;
    }

    .input-group-icon {
        position: relative;
    }

    .input-group-icon .form-control {
        padding-left: 45px;
    }

    .input-group-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
        z-index: 10;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-light);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .form-note {
        background-color: var(--primary-light);
        border-left: 4px solid var(--primary-color);
        padding: 15px;
        border-radius: 0 8px 8px 0;
        margin-bottom: 25px;
        font-size: 14px;
        color: #333;
    }

    .form-note.warning {
        background-color: var(--warning-light);
        border-left-color: var(--warning-color);
    }

    .form-note i {
        margin-right: 8px;
    }

    .form-note.primary i {
        color: var(--primary-color);
    }

    .form-note.warning i {
        color: var(--warning-color);
    }

    .back-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: var(--primary-hover);
        gap: 10px;
    }

    .lead-info-badge {
        background-color: var(--primary-light);
        color: var(--primary-color);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 25px 20px;
        }

        .form-header {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
            gap: 15px;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Custom Select Styling */
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23249722' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px 12px;
        appearance: none;
    }

    /* Custom Date Input */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(48%) sepia(90%) saturate(2548%) hue-rotate(85deg) brightness(85%) contrast(85%);
        cursor: pointer;
    }

    .is-valid {
        border-color: #28a745 !important;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

@section('content')
    <div class="edit-lead-container mt-4">
        <div class="container-fluid">
            <!-- Main Form Card -->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="form-card">
                        <div class="form-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4>
                                    Edit Lead
                                </h4>

                            </div>
                            <a href="{{ route(auth()->user()->getRoleNames()->first() .'.leads.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i>
                                Back to Leads
                            </a>
                        </div>

                        <div class="form-body">


                            <form action="{{ route('admin.leads.update', $lead) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Basic Information Section -->
                                <div class="form-section">
                                    <div class="section-title">
                                        <i class="bi bi-person-badge"></i>
                                        Basic Information
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="local_name" class="form-label required">
                                                <i class="bi bi-person"></i>
                                                Local Name
                                            </label>
                                            <div class="input-group-icon">
                                                <i class="bi bi-person-fill"></i>
                                                <input type="text" class="form-control" id="local_name" name="local_name"
                                                    value="{{ old('local_name', $lead->local_name) }}"
                                                    placeholder="Enter lead's local name" required>
                                                @error('local_name')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="company" class="form-label required">
                                                <i class="bi bi-building"></i>
                                                Company
                                            </label>
                                            <div class="input-group-icon">
                                                <i class="bi bi-building"></i>
                                                <input type="text" class="form-control" id="company" name="company"
                                                    value="{{ old('company', $lead->company) }}"
                                                    placeholder="Enter company name" required>
                                                @error('company')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lead Details Section -->
                                <div class="form-section">
                                    <div class="section-title">
                                        <i class="bi bi-clipboard-data"></i>
                                        Lead Details
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="status" class="form-label required">
                                                <i class="bi bi-flag"></i>
                                                Status
                                            </label>
                                            <select class="form-select" id="status12" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="Open"
                                                    {{ old('status', $lead->status) == 'Open' ? 'selected' : '' }}>Open
                                                </option>
                                                <option value="Contracted"
                                                    {{ old('status', $lead->status) == 'Contracted' ? 'selected' : '' }}>
                                                    Contracted</option>
                                                <option value="Qualified"
                                                    {{ old('status', $lead->status) == 'Qualified' ? 'selected' : '' }}>
                                                    Qualified</option>
                                                <option value="Nurturing"
                                                    {{ old('status', $lead->status) == 'Nurturing' ? 'selected' : '' }}>
                                                    Nurturing</option>
                                                <option value="Closed - Won"
                                                    {{ old('status', $lead->status) == 'Closed - Won' ? 'selected' : '' }}>
                                                    Closed - Won</option>
                                                <option value="Closed - Lost"
                                                    {{ old('status', $lead->status) == 'Closed - Lost' ? 'selected' : '' }}>
                                                    Closed - Lost</option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="owner" class="form-label required">
                                                <i class="bi bi-person-check"></i>
                                                Owner
                                            </label>
                                            <div class="input-group-icon">
                                                <i class="bi bi-person-badge"></i>
                                                <input type="text" class="form-control" id="owner" name="owner"
                                                    value="{{ old('owner', $lead->owner) }}" placeholder="Enter lead owner"
                                                    required>
                                                @error('owner')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="created_date" class="form-label required">
                                                <i class="bi bi-calendar"></i>
                                                Created Date
                                            </label>
                                            <div class="input-group-icon">
                                                <i class="bi bi-calendar-date"></i>
                                                <input type="date" class="form-control" id="created_date"
                                                    name="created_date"
                                                    value="{{ old('created_date', $lead->created_date ? (is_string($lead->created_date) ? date('Y-m-d', strtotime($lead->created_date)) : $lead->created_date->format('Y-m-d')) : '') }}"
                                                    required>
                                                @error('created_date')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- Form Actions -->
                                <div class="form-actions">
                                    <div>

                                        <a href="{{ route(auth()->user()->getRoleNames()->first() .'.leads.index') }}" class="btn btn-secondary me-2">
                                            <i class="bi bi-x-circle"></i>
                                            Cancel
                                        </a>
                                    </div>
                                    @can('leads.update')
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i>
                                        Update Lead
                                    </button>
                                    @endcan
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation and feedback
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required], select[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                // Initialize validation state
                if (input.value.trim() !== '') {
                    input.classList.add('is-valid');
                }
            });

            // Status select styling
            const statusSelect = document.getElementById('status');
            if (statusSelect.value) {
                statusSelect.classList.add('is-valid');
            }

            statusSelect.addEventListener('change', function() {
                if (this.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });

            // Form submit validation
            form.addEventListener('submit', function(e) {
                let valid = true;
                inputs.forEach(input => {
                    if (input.value.trim() === '') {
                        input.classList.add('is-invalid');
                        valid = false;
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    // Scroll to first invalid input
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }
            });

            // Show confirmation before leaving if form has changes
            let formChanged = false;
            const initialFormData = new FormData(form);

            form.querySelectorAll('input, select, textarea').forEach(element => {
                element.addEventListener('input', () => {
                    formChanged = true;
                });
                element.addEventListener('change', () => {
                    formChanged = true;
                });
            });

            window.addEventListener('beforeunload', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                }
            });

            // Reset formChanged when form is submitted
            form.addEventListener('submit', function() {
                formChanged = false;
            });
        });
    </script>
@endsection
