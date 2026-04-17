@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Add New Document</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route(auth()->user()->getRoleNames()->first() .'.documents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name *</label>
                                        <input type="text"
                                            class="form-control @error('customer_name') is-invalid @enderror"
                                            id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                                            required>
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="document_type" class="form-label">Document Type *</label>
                                        <select class="form-select @error('document_type') is-invalid @enderror"
                                            id="document_type" name="document_type" required>
                                            <option value="">Select Document Type</option>
                                            <option value="KYC" {{ old('document_type') == 'KYC' ? 'selected' : '' }}>KYC
                                            </option>
                                            <option value="Agreement"
                                                {{ old('document_type') == 'Agreement' ? 'selected' : '' }}>Agreement
                                            </option>
                                            <option value="Certificate"
                                                {{ old('document_type') == 'Certificate' ? 'selected' : '' }}>Certificate
                                            </option>
                                            <option value="License"
                                                {{ old('document_type') == 'License' ? 'selected' : '' }}>License</option>
                                            <option value="Invoice"
                                                {{ old('document_type') == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                                            <option value="Contract"
                                                {{ old('document_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                        </select>
                                        @error('document_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status12"
                                            name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="verified" {{ old('status') == 'verified' ? 'selected' : '' }}>
                                                Verified</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="uploaded_date" class="form-label">Uploaded Date *</label>
                                        <input type="date"
                                            class="form-control @error('uploaded_date') is-invalid @enderror"
                                            id="uploaded_date" name="uploaded_date"
                                            value="{{ old('uploaded_date', date('Y-m-d')) }}" required>
                                        @error('uploaded_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6" id="verified_date_field"
                                    style="{{ old('status') == 'verified' ? '' : 'display: none;' }}">
                                    <div class="mb-3">
                                        <label for="verified_date" class="form-label">Verified Date</label>
                                        <input type="date"
                                            class="form-control @error('verified_date') is-invalid @enderror"
                                            id="verified_date" name="verified_date"
                                            value="{{ old('verified_date', date('Y-m-d')) }}">
                                        @error('verified_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="document_file" class="form-label">Document File</label>
                                        <input type="file"
                                            class="form-control @error('document_file') is-invalid @enderror"
                                            id="document_file" name="document_file">
                                        <small class="text-muted">Supported formats: PDF, JPG, JPEG, PNG, DOC, DOCX (Max:
                                            2MB)</small>
                                        @error('document_file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to List
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Document
                                </button>
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
        document.getElementById('status').addEventListener('change', function() {
            const verifiedDateField = document.getElementById('verified_date_field');
            if (this.value === 'verified') {
                verifiedDateField.style.display = 'block';
                document.getElementById('verified_date').required = true;
            } else {
                verifiedDateField.style.display = 'none';
                document.getElementById('verified_date').required = false;
            }
        });
    </script>
@endsection
