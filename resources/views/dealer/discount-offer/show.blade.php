@extends('admin.layouts.master')

<style>
    /* Add these styles to your admin.css file */
    .required:after {
        content: " *";
        color: #dc3545;
    }

    .table th {
        background-color: #343a40;
        color: white;
    }

    .badge-info {
        background-color: #17a2b8;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .btn-group .btn {
        margin-right: 5px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h3 class="page-title">Discount Rule Details</h3>

                </div>
                <div class="col-auto">
                    @can('discount-offers.view')
                    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    @endcan

                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column - Discount Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Rule Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Rule Name:</label>
                                    <p class="font-weight-bold">{{ $discountOffer->rule_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Status:</label>
                                    <p>
                                        <span
                                            class="badge badge-{{ $discountOffer->status == 'active' ? 'success' : ($discountOffer->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($discountOffer->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Discount Type:</label>
                                    <p>
                                        <span
                                            class="badge badge-{{ $discountOffer->discount_type == 'percentage' ? 'info' : 'success' }}">
                                            {{ ucfirst(str_replace('_', ' ', $discountOffer->discount_type)) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Value:</label>
                                    <p class="font-weight-bold h5">{{ $discountOffer->formatted_value }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-item">
                                    <label>Description:</label>
                                    <p>{{ $discountOffer->description }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Applicable To:</label>
                                    <p>{{ $discountOffer->applicable_to ?? 'All Items' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Minimum Order Amount:</label>
                                    <p>
                                        @if ($discountOffer->minimum_order_amount)
                                            ${{ number_format($discountOffer->minimum_order_amount, 2) }}
                                        @else
                                            <span class="text-muted">No minimum</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Start Date:</label>
                                    <p>{{ $discountOffer->start_date ? $discountOffer->start_date->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>End Date:</label>
                                    <p>{{ $discountOffer->end_date ? $discountOffer->end_date->format('d/m/Y') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Repeat:</label>
                                    <p>{{ ucfirst($discountOffer->repeat) }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Created By:</label>
                                    <p>{{ $discountOffer->created_by }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Created At:</label>
                                    <p>{{ $discountOffer->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Last Updated:</label>
                                    <p>{{ $discountOffer->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            @if ($discountOffer->approved_by)
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Approved By:</label>
                                        <p>{{ $discountOffer->approved_by }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label>Approved Date:</label>
                                        <p>{{ $discountOffer->approved_date->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if ($discountOffer->rejection_reason)
                                <div class="col-12">
                                    <div class="info-item">
                                        <label>Rejection Reason:</label>
                                        <p class="text-danger">{{ $discountOffer->rejection_reason }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Approval History -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Approval History</h5>
                    </div>
                    <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                        @if ($approvalHistory->count() > 0)
                            <div class="timeline">
                                @foreach ($approvalHistory as $history)
                                    <div class="timeline-item">
                                        <div
                                            class="timeline-marker 
                                    {{ $history->action == 'approved'
                                        ? 'bg-success'
                                        : ($history->action == 'rejected'
                                            ? 'bg-danger'
                                            : 'bg-warning') }}">
                                        </div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1">{{ ucfirst($history->action) }}</h6>
                                                <small
                                                    class="text-muted">{{ $history->acted_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            <p class="mb-1"><strong>By:</strong> {{ $history->acted_by }}</p>
                                            @if ($history->comments)
                                                <p class="mb-0"><strong>Comments:</strong> {{ $history->comments }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">No approval history available</p>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>

    @if ($discountOffer->status == 'pending')
        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.approve', $discountOffer) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Approve Discount Rule</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to approve <strong>{{ $discountOffer->rule_name }}</strong>?</p>
                            <div class="form-group">
                                <label for="comments">Comments (Optional)</label>
                                <textarea class="form-control" id="comments" name="comments" rows="3" placeholder="Add comments..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.reject', $discountOffer) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Discount Rule</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to reject <strong>{{ $discountOffer->rule_name }}</strong>?</p>
                            <div class="form-group">
                                <label for="rejection_reason" class="required">Reason for Rejection</label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required
                                    placeholder="Please provide a reason..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
