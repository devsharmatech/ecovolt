@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vendor Details</h1>
            <div>
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Vendors
                </a>

            </div>
        </div>

        <div class="row">
            <!-- Left Column: Personal & Business Info -->
            <div class="col-lg-8">
                <!-- Personal Information Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 font-weight-bold text-white"> Personal Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Full Name</label>
                                    <p class="form-control-static">{{ $user->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Email Address</label>
                                    <p class="form-control-static">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Phone Number</label>
                                    <p class="form-control-static">{{ $user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Gender</label>
                                    <p class="form-control-static">{{ ucfirst($user->gender) ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Account Status</label>
                                    <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Member Since</label>
                                    <p class="form-control-static">{{ $user->created_at->format('d M, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Information Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 font-weight-bold text-white"> Business Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Business Name</label>
                                    <p class="form-control-static">{{ $user->business_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Business Type</label>
                                    <p class="form-control-static">{{ $user->business_type ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">GST Number</label>
                                    <p class="form-control-static">{{ $user->gst_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">PAN Number</label>
                                    <p class="form-control-static">{{ $user->pan_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-bold text-black">Business Address</label>
                            <p class="form-control-static">{{ $user->business_address ?? 'N/A' }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">City</label>
                                    <p class="form-control-static">{{ $user->business_city ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">State</label>
                                    <p class="form-control-static">{{ $user->business_state ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Pincode</label>
                                    <p class="form-control-static">{{ $user->business_pincode ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="font-weight-bold text-black">Business Description</label>
                            <p class="form-control-static">{{ $user->business_description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Details Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 font-weight-bold text-white">Bank Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Bank Name</label>
                                    <p class="form-control-static">{{ $user->bank_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Account Number</label>
                                    <p class="form-control-static">{{ $user->account_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">IFSC Code</label>
                                    <p class="form-control-static">{{ $user->ifsc_code ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="font-weight-bold text-black">Account Holder Name</label>
                                    <p class="form-control-static">{{ $user->account_holder_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Profile & Verification -->
            <div class="col-lg-4">
                <!-- Profile Picture Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-warning text-white">
                        <h6 class="m-0 font-weight-bold text-white"> Profile Picture
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : 'https://via.placeholder.com/300x300?text=Profile+Picture' }}"
                            class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;"
                            alt="{{ $user->name }}">
                        <h5 class="mt-2">{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Verification Status Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-secondary text-white">
                        <h6 class="m-0 font-weight-bold text-white">Verification Status
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            @if ($user->verification_status == 'verified')
                                <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-check fa-2x text-white"></i>
                                </div>
                                <h4 class="text-success">Verified</h4>
                            @elseif($user->verification_status == 'pending')
                                <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-clock fa-2x text-white"></i>
                                </div>
                                <h4 class="text-warning">Pending Verification</h4>
                            @elseif($user->verification_status == 'rejected')
                                <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-times fa-2x text-white"></i>
                                </div>
                                <h4 class="text-danger">Rejected</h4>
                            @endif
                        </div>

                        @if ($user->verification_notes)
                            <div class="mb-3">
                                <label class="font-weight-bold text-black">Verification Notes</label>
                                <p class="form-control-static">{{ $user->verification_notes }}</p>
                            </div>
                        @endif

                        <!-- Verification Action Form -->
                        @can('vendors.verify')
                            <form action="{{ route(auth()->user()->getRoleNames()->first() . '.vendors.verify', $user) }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold">Update Verification Status</label>
                                    <select name="verification_status" class="form-control" required>
                                        <option value="pending"
                                            {{ $user->verification_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="verified"
                                            {{ $user->verification_status == 'verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="rejected"
                                            {{ $user->verification_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Verification Notes</label>
                                    <textarea name="verification_notes" class="form-control" rows="3" placeholder="Add verification notes...">{{ old('verification_notes', $user->verification_notes) }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-check"></i> Update Verification
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                <!-- Documents Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-dark text-white">
                        <h6 class="m-0 font-weight-bold text-white"> Documents
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @if ($user->aadhar_card)
                                <a href="{{ Storage::url($user->aadhar_card) }}" target="_blank"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-pdf text-danger mr-2"></i> Aadhar Card</span>
                                    <i class="fas fa-external-link-alt text-muted"></i>
                                </a>
                            @endif

                            @if ($user->pan_card)
                                <a href="{{ Storage::url($user->pan_card) }}" target="_blank"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-pdf text-danger mr-2"></i> PAN Card</span>
                                    <i class="fas fa-external-link-alt text-muted"></i>
                                </a>
                            @endif

                            @if ($user->gst_certificate)
                                <a href="{{ Storage::url($user->gst_certificate) }}" target="_blank"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-pdf text-danger mr-2"></i> GST Certificate</span>
                                    <i class="fas fa-external-link-alt text-muted"></i>
                                </a>
                            @endif

                            @if ($user->bank_passbook)
                                <a href="{{ Storage::url($user->bank_passbook) }}" target="_blank"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-pdf text-danger mr-2"></i> Bank Passbook</span>
                                    <i class="fas fa-external-link-alt text-muted"></i>
                                </a>
                            @endif

                            @if (!$user->aadhar_card && !$user->pan_card && !$user->gst_certificate && !$user->bank_passbook)
                                <p class="text-center text-muted mb-0">No documents uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
