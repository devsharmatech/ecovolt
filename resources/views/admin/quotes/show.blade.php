@extends('admin.layouts.master')

@section('title') View Quotation - {{ $quote->proposal_id }} @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none; overflow: hidden;">
                    <div class="card-header bg-success p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-1" style="font-weight: 800;">Quotation Details</h4>
                            <div class="d-flex gap-2">
                                <span class="badge bg-white text-success">ID: {{ $quote->proposal_id }}</span>
                                @if($quote->project && $quote->project->lead)
                                    <span class="badge bg-success-light text-white border border-white">LEAD: {{ $quote->project->lead->lead_code }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route($role . '.quotes.download', $quote->id) }}" class="btn btn-light" style="border-radius: 10px; font-weight: 700;">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> Download PDF
                            </a>
                            <a href="{{ route($role . '.quotes.index') }}" class="btn btn-success-light text-white border-white" style="border-radius: 10px; font-weight: 700;">
                                <i class="fas fa-arrow-left me-2"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <div class="row mb-5">
                            <div class="col-sm-6">
                                <h5 class="text-muted mb-3" style="font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px;">Customer Information</h5>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <span class="avatar-title rounded-circle bg-success-subtle text-success font-size-16" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                            {{ strtoupper(substr($quote->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h5 class="mb-1" style="font-weight: 700;">{{ $quote->user->name }}</h5>
                                        <p class="text-muted mb-0">{{ $quote->user->email }}</p>
                                        <p class="text-muted mb-0">{{ $quote->user->phone ?? 'No phone provided' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h5 class="text-muted mb-3" style="font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 1px;">Proposal Summary</h5>
                                <h4 class="text-success mb-1" style="font-weight: 800;">${{ number_format($quote->total_price, 2) }}</h4>
                                <p class="text-muted mb-1">Date: <strong>{{ $quote->created_at->format('M d, Y') }}</strong></p>
                                <div class="mt-2">
                                    @if($quote->status == 'accepted')
                                        <span class="badge bg-success p-2 px-3" style="border-radius: 8px;">ACCEPTED</span>
                                    @elseif($quote->status == 'declined')
                                        <span class="badge bg-danger p-2 px-3" style="border-radius: 8px;">DECLINED</span>
                                    @else
                                        <span class="badge bg-warning p-2 px-3" style="border-radius: 8px;">PENDING</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <h5 class="mb-3" style="font-weight: 700; color: #1a1a1a;">Package: {{ $quote->package_name }}</h5>
                            <div class="p-4 bg-light" style="border-radius: 15px;">
                                <p class="mb-0" style="line-height: 1.8; color: #4a4a4a;">
                                    {!! nl2br(e($quote->timeline)) !!}
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-4" style="font-weight: 700; color: #1a1a1a;">Component Breakdown</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="font-weight: 700;">Component Type</th>
                                            <th style="font-weight: 700;">Specifications</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $components = is_array($quote->components) ? $quote->components : json_decode($quote->components, true) ?? []; @endphp
                                        @foreach($components as $key => $value)
                                        <tr>
                                            <td class="text-capitalize" style="font-weight: 600; width: 30%;">{{ str_replace('_', ' ', $key) }}</td>
                                            <td>{{ $value ?: 'Standard specification included' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 shadow-sm mt-5" style="border-radius: 15px; background: #e3f2fd; color: #0d47a1;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-3" style="font-size: 24px;"></i>
                                <div>
                                    <h6 class="mb-1" style="font-weight: 700;">Important Note</h6>
                                    <p class="mb-0">This is a generated investment proposal based on the current system rates. Prices are subject to final site survey and technical verification.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
