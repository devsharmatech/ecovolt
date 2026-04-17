@extends('admin.layouts.master')

@section('title') Enquiry Details #{{ $enquiry->id }} @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title text-success m-0" style="font-weight: 800;">Enquiry Information</h4>
                            <a href="{{ route($role . '.enquiries.index') }}" class="btn btn-light btn-sm rounded-pill px-3">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <label class="text-muted small text-uppercase fw-bold">Customer Name</label>
                                <p class="fs-5 fw-bold text-dark">{{ $enquiry->name }}</p>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small text-uppercase fw-bold">Mobile Number</label>
                                <p class="fs-5 fw-bold text-dark">{{ $enquiry->mobile }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small text-uppercase fw-bold">Site Address</label>
                            <p class="fs-6 text-dark">{{ $enquiry->address }}</p>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <label class="text-muted small text-uppercase fw-bold d-block mb-1">Load Req.</label>
                                    <span class="fs-4 fw-bold text-success">{{ $enquiry->load_requirement }} kW</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <label class="text-muted small text-uppercase fw-bold d-block mb-1">Panel Cap.</label>
                                    <span class="fs-5 fw-bold text-dark">{{ $enquiry->panel_capacity ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <label class="text-muted small text-uppercase fw-bold d-block mb-1">Package</label>
                                    <span class="fs-5 fw-bold text-dark">{{ $enquiry->package_name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <h4 class="card-title text-success mb-3" style="font-weight: 800;">Site Architecture</h4>
                        @if($enquiry->site_photo)
                            <img src="{{ asset('storage/' . $enquiry->site_photo) }}" class="img-fluid rounded-4 shadow-sm" alt="Site Photo" style="width: 100%; object-fit: cover; max-height: 400px;">
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $enquiry->site_photo) }}" target="_blank" class="btn btn-outline-success btn-sm w-100 rounded-3">
                                    <i class="fas fa-expand-alt me-2"></i> View Full Image
                                </a>
                            </div>
                        @else
                            <div class="text-center py-5 bg-light rounded-4">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <p class="text-muted m-0">No site photo uploaded</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
