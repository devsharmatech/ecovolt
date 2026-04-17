@extends('admin.layouts.master')

<style>
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card-header {
        border-bottom: none;
    }

    .custom-file-label::after {
        content: "Browse";
    }

    .img-thumbnail {
        border: 2px solid #dee2e6;
        border-radius: 0.35rem;
    }

    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
    }

    .text-danger {
        color: #e74a3b !important;
    }

    .alert-info {
        background-color: #f8f9fa;
        border-color: #d1d3e2;
        color: #5a5c69;
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Vendor</h1>
            <div>
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.index') }}"
                    class="btn btn-secondary ml-2">
                    <i class="fas fa-arrow-left"></i> Back to Vendors
                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.update', $user) }}" method="POST"
                    enctype="multipart/form-data" id="vendorForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column: Personal Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold text-white"> Personal Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Name -->
                                    <div class="form-group mb-3">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group mb-3">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" required readonly
                                            style="background-color: #f8f9fa; cursor: not-allowed;">
                                        <small class="text-muted">Email cannot be changed</small>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="form-group mb-3">
                                        <label for="phone">Phone Number </label>
                                        <input type="tel" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="form-group mb-3">
                                        <label for="gender">Gender </label>
                                        <select name="gender" id="gender"
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Select Gender</option>
                                            <option value="male"
                                                {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female"
                                                {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="other"
                                                {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="form-group mb-3">
                                        <label for="status">Account Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status1"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="active"
                                                {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                            </option>

                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Profile Picture -->
                                    <div class="form-group mb-3">
                                        <label for="profile_picture">Profile Picture</label>
                                        <div class="custom-file">
                                            <input type="file" name="profile_picture" id="profile_picture"
                                                class="form-control custom-file-input @error('profile_picture') is-invalid @enderror"
                                                accept="image/*">

                                        </div>
                                        <small class="text-muted">Leave empty to keep current image. Max size: 2MB</small>
                                        @error('profile_picture')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror

                                        <!-- Current Profile Picture -->
                                        @if ($user->profile_picture)
                                            <div class="mt-3" id="currentProfilePicture">
                                                <p class="mb-1">Current Image:</p>
                                                <img src="{{ Storage::url($user->profile_picture) }}" class="img-thumbnail"
                                                    style="width: 150px; height: 150px; object-fit: cover;"
                                                    alt="Current Profile Picture">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        id="removeProfilePicture">
                                                        <i class="fas fa-trash"></i> Remove Image
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Business Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h6 class="m-0 font-weight-bold text-white"> Business Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Business Name -->
                                    <div class="form-group mb-4">
                                        <label for="business_name">Business Name <span class="text-danger">*</span></label>
                                        <input type="text" name="business_name" id="business_name"
                                            class="form-control @error('business_name') is-invalid @enderror"
                                            value="{{ old('business_name', $user->business_name) }}" required>
                                        @error('business_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Business Type -->
                                    <div class="form-group mb-3">
                                        <label for="business_type">Business Type</label>
                                        <select name="business_type" id="business_type"
                                            class="form-control @error('business_type') is-invalid @enderror">
                                            <option value="">Select Business Type</option>

                                            <option value="solar_installer"
                                                {{ old('business_type') == 'solar_installer' ? 'selected' : '' }}>
                                                Solar Installer
                                            </option>

                                            <option value="solar_vendor"
                                                {{ old('business_type') == 'solar_vendor' ? 'selected' : '' }}>
                                                Solar Vendor / Dealer
                                            </option>

                                            <option value="solar_distributor"
                                                {{ old('business_type') == 'solar_distributor' ? 'selected' : '' }}>
                                                Solar Distributor
                                            </option>

                                            <option value="epc_contractor"
                                                {{ old('business_type') == 'epc_contractor' ? 'selected' : '' }}>
                                                EPC Contractor
                                            </option>

                                            <option value="residential_customer"
                                                {{ old('business_type') == 'residential_customer' ? 'selected' : '' }}>
                                                Residential Customer
                                            </option>

                                            <option value="commercial_customer"
                                                {{ old('business_type') == 'commercial_customer' ? 'selected' : '' }}>
                                                Commercial Customer
                                            </option>

                                            <option value="industrial_customer"
                                                {{ old('business_type') == 'industrial_customer' ? 'selected' : '' }}>
                                                Industrial Customer
                                            </option>

                                            <option value="solar_consultant"
                                                {{ old('business_type') == 'solar_consultant' ? 'selected' : '' }}>
                                                Solar Consultant
                                            </option>

                                            <option value="maintenance_provider"
                                                {{ old('business_type') == 'maintenance_provider' ? 'selected' : '' }}>
                                                Solar Maintenance Provider
                                            </option>

                                            <option value="solar_manufacturer"
                                                {{ old('business_type') == 'solar_manufacturer' ? 'selected' : '' }}>
                                                Solar Manufacturer
                                            </option>

                                            <option value="other"
                                                {{ old('business_type') == 'other' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>

                                        @error('business_type')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- GST Number -->
                                    <div class="form-group mb-3">
                                        <label for="gst_number">GST Number</label>
                                        <input type="text" name="gst_number" id="gst_number"
                                            class="form-control @error('gst_number') is-invalid @enderror"
                                            value="{{ old('gst_number', $user->gst_number) }}">
                                        @error('gst_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- PAN Number -->
                                    <div class="form-group mb-3">
                                        <label for="pan_number">PAN Number</label>
                                        <input type="text" name="pan_number" id="pan_number"
                                            class="form-control @error('pan_number') is-invalid @enderror"
                                            value="{{ old('pan_number', $user->pan_number) }}">
                                        @error('pan_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Business Address -->
                                    <div class="form-group mb-3">
                                        <label for="business_address">Business Address</label>
                                        <textarea name="business_address" id="business_address" rows="3"
                                            class="form-control @error('business_address') is-invalid @enderror">{{ old('business_address', $user->business_address) }}</textarea>
                                        @error('business_address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- City -->
                                            <div class="form-group mb-3">
                                                <label for="business_city">City</label>
                                                <input type="text" name="business_city" id="business_city"
                                                    class="form-control @error('business_city') is-invalid @enderror"
                                                    value="{{ old('business_city', $user->business_city) }}">
                                                @error('business_city')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- State -->
                                            <div class="form-group mb-3">
                                                <label for="business_state">State</label>
                                                <input type="text" name="business_state" id="business_state"
                                                    class="form-control @error('business_state') is-invalid @enderror"
                                                    value="{{ old('business_state', $user->business_state) }}">
                                                @error('business_state')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Pincode -->
                                            <div class="form-group mb-3">
                                                <label for="business_pincode">Pincode</label>
                                                <input type="text" name="business_pincode" id="business_pincode"
                                                    class="form-control @error('business_pincode') is-invalid @enderror"
                                                    value="{{ old('business_pincode', $user->business_pincode) }}">
                                                @error('business_pincode')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Description -->
                                    <div class="form-group mb-3">
                                        <label for="business_description">Business Description</label>
                                        <textarea name="business_description" id="business_description" rows="3"
                                            class="form-control @error('business_description') is-invalid @enderror">{{ old('business_description', $user->business_description) }}</textarea>
                                        @error('business_description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Details Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="m-0 font-weight-bold text-white"> Bank Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Bank Name -->
                                    <div class="form-group mb-3">
                                        <label for="bank_name">Bank Name</label>
                                        <input type="text" name="bank_name" id="bank_name"
                                            class="form-control @error('bank_name') is-invalid @enderror"
                                            value="{{ old('bank_name', $user->bank_name) }}">
                                        @error('bank_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Account Number -->
                                    <div class="form-group mb-3">
                                        <label for="account_number">Account Number</label>
                                        <input type="text" name="account_number" id="account_number"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            value="{{ old('account_number', $user->account_number) }}">
                                        @error('account_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- IFSC Code -->
                                    <div class="form-group mb-3">
                                        <label for="ifsc_code">IFSC Code</label>
                                        <input type="text" name="ifsc_code" id="ifsc_code"
                                            class="form-control @error('ifsc_code') is-invalid @enderror"
                                            value="{{ old('ifsc_code', $user->ifsc_code) }}">
                                        @error('ifsc_code')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Account Holder Name -->
                                    <div class="form-group mb-3">
                                        <label for="account_holder_name">Account Holder Name</label>
                                        <input type="text" name="account_holder_name" id="account_holder_name"
                                            class="form-control @error('account_holder_name') is-invalid @enderror"
                                            value="{{ old('account_holder_name', $user->account_holder_name) }}">
                                        @error('account_holder_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="m-0 font-weight-bold text-white"> Documents
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="aadhar_card">Aadhar Card</label>
                                        <div class="custom-file">
                                            <input type="file" name="aadhar_card" id="aadhar_card"
                                                class="custom-file-input @error('aadhar_card') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="aadhar_card" id="aadharCardLabel">
                                                {{ $user->aadhar_card ? 'Change file...' : 'Choose file' }}
                                            </label>
                                        </div>
                                        @error('aadhar_card')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        @if ($user->aadhar_card)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> File uploaded
                                                <a href="{{ Storage::url($user->aadhar_card) }}" target="_blank"
                                                    class="ml-2">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pan_card">PAN Card</label>
                                        <div class="custom-file">
                                            <input type="file" name="pan_card" id="pan_card"
                                                class="custom-file-input @error('pan_card') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="pan_card" id="panCardLabel">
                                                {{ $user->pan_card ? 'Change file...' : 'Choose file' }}
                                            </label>
                                        </div>
                                        @error('pan_card')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        @if ($user->pan_card)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> File uploaded
                                                <a href="{{ Storage::url($user->pan_card) }}" target="_blank"
                                                    class="ml-2">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gst_certificate">GST Certificate</label>
                                        <div class="custom-file">
                                            <input type="file" name="gst_certificate" id="gst_certificate"
                                                class="custom-file-input @error('gst_certificate') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="gst_certificate"
                                                id="gstCertificateLabel">
                                                {{ $user->gst_certificate ? 'Change file...' : 'Choose file' }}
                                            </label>
                                        </div>
                                        @error('gst_certificate')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        @if ($user->gst_certificate)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> File uploaded
                                                <a href="{{ Storage::url($user->gst_certificate) }}" target="_blank"
                                                    class="ml-2">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </small>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bank_passbook">Bank Passbook</label>
                                        <div class="custom-file">
                                            <input type="file" name="bank_passbook" id="bank_passbook"
                                                class="custom-file-input @error('bank_passbook') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="bank_passbook" id="bankPassbookLabel">
                                                {{ $user->bank_passbook ? 'Change file...' : 'Choose file' }}
                                            </label>
                                        </div>
                                        @error('bank_passbook')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        @if ($user->bank_passbook)
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> File uploaded
                                                <a href="{{ Storage::url($user->bank_passbook) }}" target="_blank"
                                                    class="ml-2">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle"></i>
                                <strong>Note:</strong> Leave document fields empty to keep current files.
                                Allowed formats: PDF, JPG, JPEG, PNG (Max: 2MB each)
                            </div>
                        </div>
                    </div>

                    <!-- Hidden field for removing profile picture -->
                    <input type="hidden" name="remove_profile_picture" id="removeProfilePictureFlag" value="0">

                    <!-- Submit Buttons -->
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Update Vendor
                        </button>
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.index') }}"
                            class="btn btn-secondary btn-sm ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Bootstrap file input label update
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                let label = $(this).siblings('.custom-file-label');
                if (fileName) {
                    label.text(fileName);
                } else {
                    label.text('Choose file');
                }
            });

            // Remove profile picture functionality
            $('#removeProfilePicture').on('click', function() {
                if (confirm('Are you sure you want to remove the profile picture?')) {
                    $('#currentProfilePicture').hide();
                    $('#profilePictureLabel').text('Choose file');
                    $('#profile_picture').val('');
                    $('#removeProfilePictureFlag').val('1');
                }
            });

            // Reset remove flag if new file is selected
            $('#profile_picture').on('change', function() {
                if ($(this).val()) {
                    $('#removeProfilePictureFlag').val('0');
                }
            });

            // Form validation
            $('#vendorForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    phone: {
                        minlength: 10,
                        maxlength: 15
                    },
                    business_name: {
                        required: true,
                        minlength: 3
                    },
                    gst_number: {
                        pattern: /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/
                    },
                    pan_number: {
                        pattern: /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/
                    }
                },
                messages: {
                    name: {
                        required: "Please enter vendor's full name",
                        minlength: "Name must be at least 3 characters long"
                    },
                    phone: {
                        minlength: "Phone number must be at least 10 digits",
                        maxlength: "Phone number cannot exceed 15 digits"
                    },
                    business_name: {
                        required: "Please enter business name",
                        minlength: "Business name must be at least 3 characters long"
                    },
                    gst_number: {
                        pattern: "Please enter a valid GST number"
                    },
                    pan_number: {
                        pattern: "Please enter a valid PAN number"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            // File size validation
            $('input[type="file"]').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // in MB
                    if (fileSize > 2) {
                        alert('File size must be less than 2MB');
                        $(this).val('');
                        $(this).siblings('.custom-file-label').text('Choose file');
                    }
                }
            });
        });
    </script>
@endsection
