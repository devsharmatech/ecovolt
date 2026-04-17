@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-4">
                <div class="col">
                    <h3 class="page-title">Edit Discount Rule</h3>

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
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Discount Rule: {{ $discountOffer->rule_name }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route(auth()->user()->getRoleNames()->first() .'.discount-offer.update', $discountOffer) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Rule Name -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="rule_name" class="required">Rule Name</label>
                                        <input type="text" class="form-control @error('rule_name') is-invalid @enderror"
                                            id="rule_name" name="rule_name"
                                            value="{{ old('rule_name', $discountOffer->rule_name) }}"
                                            placeholder="e.g., Summer Sale" required>
                                        @error('rule_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Discount Type -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="discount_type" class="required">Discount Type</label>
                                        <select class="form-control @error('discount_type') is-invalid @enderror"
                                            id="discount_type" name="discount_type" required>
                                            <option value="">Select Type</option>
                                            <option value="percentage"
                                                {{ old('discount_type', $discountOffer->discount_type) == 'percentage' ? 'selected' : '' }}>
                                                Percentage</option>
                                            <option value="fixed_amount"
                                                {{ old('discount_type', $discountOffer->discount_type) == 'fixed_amount' ? 'selected' : '' }}>
                                                Fixed Amount</option>
                                        </select>
                                        @error('discount_type')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Value -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="value" class="required">Value</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control @error('value') is-invalid @enderror"
                                                id="value" name="value"
                                                value="{{ old('value', $discountOffer->value) }}" step="0.01"
                                                min="0" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="value_suffix">
                                                    {{ $discountOffer->discount_type == 'percentage' ? '%' : '$' }}
                                                </span>
                                            </div>
                                        </div>
                                        @error('value')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="status" class="required">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status12"
                                            name="status" required>
                                            <option value="active"
                                                {{ old('status', $discountOffer->status) == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ old('status', $discountOffer->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Applicable To -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="applicable_to">Applicable To</label>
                                        <input type="text"
                                            class="form-control @error('applicable_to') is-invalid @enderror"
                                            id="applicable_to" name="applicable_to"
                                            value="{{ old('applicable_to', $discountOffer->applicable_to) }}"
                                            placeholder="e.g., Summer items, First-time customers">
                                        @error('applicable_to')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="description" class="required">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="3" placeholder="Discount description..." required>{{ old('description', $discountOffer->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Minimum Order Amount -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="minimum_order_amount">Minimum Order Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number"
                                                class="form-control @error('minimum_order_amount') is-invalid @enderror"
                                                id="minimum_order_amount" name="minimum_order_amount"
                                                value="{{ old('minimum_order_amount', $discountOffer->minimum_order_amount) }}"
                                                step="0.01" min="0">
                                        </div>
                                        @error('minimum_order_amount')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Repeat Option -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="repeat">Repeat</label>
                                        <select class="form-control @error('repeat') is-invalid @enderror" id="repeat"
                                            name="repeat">
                                            <option value="none"
                                                {{ old('repeat', $discountOffer->repeat) == 'none' ? 'selected' : '' }}>No
                                                Repeat</option>
                                            <option value="daily"
                                                {{ old('repeat', $discountOffer->repeat) == 'daily' ? 'selected' : '' }}>
                                                Daily</option>
                                            <option value="weekly"
                                                {{ old('repeat', $discountOffer->repeat) == 'weekly' ? 'selected' : '' }}>
                                                Weekly</option>
                                            <option value="monthly"
                                                {{ old('repeat', $discountOffer->repeat) == 'monthly' ? 'selected' : '' }}>
                                                Monthly</option>
                                            <option value="yearly"
                                                {{ old('repeat', $discountOffer->repeat) == 'yearly' ? 'selected' : '' }}>
                                                Yearly</option>
                                        </select>
                                        @error('repeat')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Start Date & End Date -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="date"
                                            class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                            name="start_date"
                                            value="{{ old('start_date', $discountOffer->start_date ? $discountOffer->start_date->format('Y-m-d') : '') }}">
                                        @error('start_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date"
                                            value="{{ old('end_date', $discountOffer->end_date ? $discountOffer->end_date->format('Y-m-d') : '') }}">
                                        @error('end_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-3">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                @can('discount-offers.update')
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Discount Rule
                                </button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Update value suffix based on discount type
            $('#discount_type').change(function() {
                const type = $(this).val();
                const suffix = type === 'percentage' ? '%' : '$';
                $('#value_suffix').text(suffix);
            });

            // Trigger change on page load
            $('#discount_type').trigger('change');

            // Date validation
            $('#start_date').change(function() {
                const startDate = $(this).val();
                if (startDate) {
                    $('#end_date').attr('min', startDate);
                }
            });

            $('#end_date').change(function() {
                const endDate = $(this).val();
                const startDate = $('#start_date').val();
                if (endDate && startDate && endDate < startDate) {
                    alert('End date must be after start date');
                    $(this).val('');
                }
            });
        });
    </script>
@endsection
