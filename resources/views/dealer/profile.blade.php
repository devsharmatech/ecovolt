@extends('admin.layouts.master')
@section('title', 'My Profile')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                {{-- Profile Main Card --}}
                <div class="card text-center p-4 border-0 shadow-sm mb-4" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="position-relative d-inline-block mb-4">
                            @if($user->profile_picture)
                                <img src="{{ $user->profile_picture }}" alt="Avatar" class="rounded-circle img-thumbnail shadow-sm" style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #fff;">
                            @else
                                <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center bg-success text-white" style="width: 130px; height: 130px; font-size: 3rem; border: 4px solid #fff;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <button class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle shadow" 
                                    style="width: 36px; height: 36px;" onclick="document.getElementById('avatarInput').click()">
                                <i class="fas fa-camera"></i>
                            </button>
                            <input type="file" id="avatarInput" hidden accept="image/*" onchange="uploadAvatar()">
                        </div>
                        <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ strtoupper($role) }} PARTNER</p>
                        <div class="p-2 bg-light rounded-pill mb-4 border">
                            @php
                                $prefix = 'EMP';
                                if(strtolower($role) == 'dealer') $prefix = 'DLR';
                                if(strtolower($role) == 'accounts') $prefix = 'ACC';
                            @endphp
                            <span class="text-success small fw-bold">ID: ELV-{{ $prefix }}-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-2">
                             @if($user->verification_status == 'verified')
                                <span class="badge bg-success-subtle text-success p-2 px-3 rounded-pill border border-success">
                                    <i class="fas fa-check-circle me-1"></i> Verified
                                </span>
                             @else
                                <span class="badge bg-warning-subtle text-warning p-2 px-3 rounded-pill border border-warning">
                                    <i class="fas fa-clock me-1"></i> Pending Verification
                                </span>
                             @endif
                        </div>
                    </div>
                </div>

                {{-- Quick Stats / Contact --}}
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body">
                        <h6 class="text-uppercase fw-bold text-muted small mb-3">Quick Contact</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-xs flex-shrink-0 me-3">
                                <span class="avatar-title rounded bg-primary-subtle text-primary">
                                    <i class="fas fa-phone-alt"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small fw-bold">{{ $user->phone ?? 'Not Linked' }}</h6>
                                <p class="text-muted mb-0 font-size-11">Primary Phone</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs flex-shrink-0 me-3">
                                <span class="avatar-title rounded bg-info-subtle text-info">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small fw-bold">{{ $user->email }}</h6>
                                <p class="text-muted mb-0 font-size-11">Work Email</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-4 border-bottom" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active py-3" data-bs-toggle="tab" href="#personal-info" role="tab">
                                    <i class="fas fa-user-circle me-2"></i> Profile Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#business-info" role="tab">
                                    <i class="fas fa-store me-2"></i> Business Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#bank-info" role="tab">
                                    <i class="fas fa-university me-2"></i> Account Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#security" role="tab">
                                    <i class="fas fa-lock me-2"></i> Security
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Personal Settings -->
                            <div class="tab-pane active" id="personal-info" role="tabpanel">
                                <form id="personalForm" class="row">
                                    @csrf
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->name }}" placeholder="Full Name">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->email }}">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Mobile Number</label>
                                        <input type="text" name="phone" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->phone }}">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Gender</label>
                                        <select name="gender" class="form-select form-select-lg bg-light border-0 rounded-4">
                                            <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-4 fw-bold shadow-sm">Update Basic Profile</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Business Details -->
                            <div class="tab-pane" id="business-info" role="tabpanel">
                                <form id="businessForm" class="row">
                                    @csrf
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label fw-bold">Business / Firm name</label>
                                        <input type="text" name="business_name" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->business_name }}" placeholder="EcoVolt Solar Solutions">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">GST Number</label>
                                        <input type="text" name="gst_number" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->gst_number }}" placeholder="Gistin Code">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">PAN Card Number</label>
                                        <input type="text" name="pan_number" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->pan_number }}" placeholder="ABCDE1234F">
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label fw-bold">Business Office Address</label>
                                        <textarea name="business_address" rows="3" class="form-control bg-light border-0 rounded-4">{{ $user->business_address }}</textarea>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold">City</label>
                                        <input type="text" name="business_city" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->business_city }}">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold">State</label>
                                        <input type="text" name="business_state" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->business_state }}">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label fw-bold">Pincode</label>
                                        <input type="text" name="business_pincode" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->business_pincode }}">
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-4 fw-bold shadow-sm">Save Business Details</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Bank Details -->
                            <div class="tab-pane" id="bank-info" role="tabpanel">
                                <form id="bankForm" class="row">
                                    @csrf
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label fw-bold">Account Holder Name</label>
                                        <input type="text" name="account_holder_name" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->account_holder_name }}">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->bank_name }}" placeholder="ICICI Bank">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">Account Number</label>
                                        <input type="text" name="account_number" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->account_number }}">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">IFSC Code</label>
                                        <input type="text" name="ifsc_code" class="form-control form-control-lg bg-light border-0 rounded-4" value="{{ $user->ifsc_code }}">
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-4 fw-bold shadow-sm">Submit Account Details</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Security -->
                            <div class="tab-pane" id="security" role="tabpanel">
                                <form id="securityForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" name="current_password" class="form-control form-control-lg bg-light border-0 rounded-4" placeholder="••••••••">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">New Password</label>
                                            <input type="password" name="new_password" class="form-control form-control-lg bg-light border-0 rounded-4" placeholder="At least 8 chars">
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label fw-bold">Confirm New Password</label>
                                            <input type="password" name="new_password_confirmation" class="form-control form-control-lg bg-light border-0 rounded-4" placeholder="Repeat password">
                                        </div>
                                    </div>
                                    <div class="mt-2 text-end">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-4 fw-bold shadow-sm">Change My Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // AJAX for Profile Updates
    $('#personalForm, #businessForm, #bankForm').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $btn = $form.find('button[type="submit"]');
        
        $btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Saving...').prop('disabled', true);

        $.post('{{ route($role.".profile.update") }}', $form.serialize())
        .done(res => {
            Swal.fire({
                title: 'Data Saved!',
                text: res.message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
            $btn.html('Saved <i class="fas fa-check"></i>').addClass('btn-success');
            setTimeout(() => { $btn.html($btn.data('original-text') || 'Update Profile').prop('disabled', false); }, 1500);
        })
        .fail(err => {
            let errorMsg = 'Could not save data. Please check fields.';
            if(err.responseJSON && err.responseJSON.message) errorMsg = err.responseJSON.message;
            Swal.fire('Error', errorMsg, 'error');
            $btn.html('Try Again').prop('disabled', false);
        });
    });

    $('#securityForm').on('submit', function(e) {
        e.preventDefault();
        $.post('{{ route($role.".profile.change-password") }}', $(this).serialize())
        .done(res => {
            if(res.success) {
                Swal.fire('Password Changed!', res.message, 'success');
                $('#securityForm')[0].reset();
            } else {
                Swal.fire('Validation Error', res.message, 'error');
            }
        });
    });

    function uploadAvatar() {
        const file = document.getElementById('avatarInput').files[0];
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', '{{ csrf_token() }}');

        Swal.fire({title: 'Updating Avatar...', didOpen: () => Swal.showLoading()});

        $.ajax({
            url: '{{ route($role.".profile.update-avatar") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function() { location.reload(); },
            error: function() { Swal.fire('Error', 'Upload failed.', 'error'); }
        });
    }
</script>
@endsection
