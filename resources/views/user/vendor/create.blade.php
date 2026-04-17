@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add New Vendor</h1>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Vendors
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Left Column: Personal Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="m-0 font-weight-bold text-white">
                                        Personal Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Name -->
                                    <div class="form-group mb-3">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group mb-3">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group mb-3">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" required>
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-group mb-3">
                                        <label for="password_confirmation">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" required>
                                    </div>

                                    <!-- Phone -->
                                    <div class="form-group mb-3">
                                        <label for="phone">Phone Number </label>
                                        <input type="tel" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="form-group mb-3">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender"
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Profile Picture -->
                                    <div class="form-group mb-3">
                                        <label for="profile_picture">Profile Picture</label>
                                        <div class="custom-file">
                                            <input type="file" name="profile_picture" id="profile_picture"
                                                class="custom-file-input @error('profile_picture') is-invalid @enderror"
                                                accept="image/*">
                                        </div>
                                        <small class="text-muted">Max size: 2MB | Formats: jpeg, png, jpg, gif</small>
                                        @error('profile_picture')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <div class="mt-2 text-center">
                                            <img id="profilePreview"
                                                src="https://via.placeholder.com/150?text=Profile+Picture"
                                                class="img-thumbnail" style="width:150px;height:150px;object-fit:cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Business Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-success text-white">
                                    <h6 class="m-0 font-weight-bold text-white">Business Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- Business Name -->
                                    <div class="form-group mb-3">
                                        <label for="business_name">Business Name <span class="text-danger">*</span></label>
                                        <input type="text" name="business_name" id="business_name"
                                            class="form-control @error('business_name') is-invalid @enderror"
                                            value="{{ old('business_name') }}" required>
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
                                            value="{{ old('gst_number') }}" placeholder="E.g., 27AAAAA0000A1Z5">
                                        @error('gst_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- PAN Number -->
                                    <div class="form-group mb-3">
                                        <label for="pan_number">PAN Number</label>
                                        <input type="text" name="pan_number" id="pan_number"
                                            class="form-control @error('pan_number') is-invalid @enderror"
                                            value="{{ old('pan_number') }}" placeholder="E.g., ABCDE1234F">
                                        @error('pan_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Business Address -->
                                    <div class="form-group mb-3">
                                        <label for="business_address">Business Address</label>
                                        <textarea name="business_address" id="business_address" rows="3"
                                            class="form-control @error('business_address') is-invalid @enderror" placeholder="Full business address">{{ old('business_address') }}</textarea>
                                        @error('business_address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- City -->
                                            <div class="form-group mb-3">
                                                <label for="business_city">City</label>
                                                <input type="text" name="business_city" id="business_city"
                                                    class="form-control @error('business_city') is-invalid @enderror"
                                                    value="{{ old('business_city') }}">
                                                @error('business_city')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- State -->
                                            <div class="form-group mb-3">
                                                <label for="business_state">State</label>
                                                <input type="text" name="business_state" id="business_state"
                                                    class="form-control @error('business_state') is-invalid @enderror"
                                                    value="{{ old('business_state') }}">
                                                @error('business_state')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pincode -->
                                    <div class="form-group mb-3">
                                        <label for="business_pincode">Pincode</label>
                                        <input type="text" name="business_pincode" id="business_pincode"
                                            class="form-control @error('business_pincode') is-invalid @enderror"
                                            value="{{ old('business_pincode') }}">
                                        @error('business_pincode')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Business Description -->
                                    <div class="form-group mb-3">
                                        <label for="business_description">Business Description</label>
                                        <textarea name="business_description" id="business_description" rows="3"
                                            class="form-control @error('business_description') is-invalid @enderror" placeholder="Describe your business...">{{ old('business_description') }}</textarea>
                                        @error('business_description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Bank Details Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="m-0 font-weight-bold text-white"> Bank Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- Bank Name -->
                            <div class="form-group mb-3">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name"
                                    class="form-control @error('bank_name') is-invalid @enderror"
                                    value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Account Number -->
                            <div class="form-group mb-3">
                                <label for="account_number">Account Number</label>
                                <input type="text" name="account_number" id="account_number"
                                    class="form-control @error('account_number') is-invalid @enderror"
                                    value="{{ old('account_number') }}">
                                @error('account_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- IFSC Code -->
                            <div class="form-group mb-3">
                                <label for="ifsc_code">IFSC Code</label>
                                <input type="text" name="ifsc_code" id="ifsc_code"
                                    class="form-control @error('ifsc_code') is-invalid @enderror"
                                    value="{{ old('ifsc_code') }}" placeholder="E.g., SBIN0000123">
                                @error('ifsc_code')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Account Holder Name -->
                            <div class="form-group mb-3">
                                <label for="account_holder_name">Account Holder Name</label>
                                <input type="text" name="account_holder_name" id="account_holder_name"
                                    class="form-control @error('account_holder_name') is-invalid @enderror"
                                    value="{{ old('account_holder_name') }}">
                                @error('account_holder_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="m-0 font-weight-bold text-white"> Documents (Optional)
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="aadhar_card">Aadhar Card</label>
                                        <div class="custom-file">
                                            <input type="file" name="aadhar_card" id="aadhar_card"
                                                class="form-control custom-file-input @error('aadhar_card') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="aadhar_card">Choose file</label>
                                        </div>
                                        <small class="text-muted">PDF, JPG, PNG (Max: 2MB)</small>
                                        @error('aadhar_card')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pan_card">PAN Card</label>
                                        <div class="custom-file">
                                            <input type="file" name="pan_card" id="pan_card"
                                                class="form-control custom-file-input @error('pan_card') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="pan_card">Choose file</label>
                                        </div>
                                        <small class="text-muted">PDF, JPG, PNG (Max: 2MB)</small>
                                        @error('pan_card')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gst_certificate">GST Certificate</label>
                                        <div class="custom-file">
                                            <input type="file" name="gst_certificate" id="gst_certificate"
                                                class="form-control custom-file-input @error('gst_certificate') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="gst_certificate">Choose file</label>
                                        </div>
                                        <small class="text-muted">PDF, JPG, PNG (Max: 2MB)</small>
                                        @error('gst_certificate')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="bank_passbook">Bank Passbook</label>
                                        <div class="custom-file">
                                            <input type="file" name="bank_passbook" id="bank_passbook"
                                                class="form-control custom-file-input @error('bank_passbook') is-invalid @enderror"
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="bank_passbook">Choose file</label>
                                        </div>
                                        <small class="text-muted">PDF, JPG, PNG (Max: 2MB)</small>
                                        @error('bank_passbook')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle"></i> Create Vendor Account
                        </button>
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.index') }}"
                            class="btn btn-secondary btn-sm">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Profile picture preview
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('profilePreview');
            const label = this.nextElementSibling;

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
                label.textContent = file.name;
            }
        });

        // Custom file input label
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const label = this.nextElementSibling;
                const file = e.target.files[0];
                label.textContent = file ? file.name : 'Choose file';
            });
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                document.getElementById('password').focus();
            }
        });
    </script>
@endsection
