@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Document Details</h4>
                            <div>
                                <span
                                    class="badge {{ $document->status === 'verified' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
                                    {{ ucfirst($document->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Document Information -->
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Document Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Customer Name</label>
                                                    <p class="form-control-static fw-bold">{{ $document->customer_name }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Document Type</label>
                                                    <p class="form-control-static">
                                                        <span
                                                            class="badge bg-info text-dark">{{ $document->document_type }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Uploaded Date</label>
                                                    <p class="form-control-static">
                                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                                        {{ $document->uploaded_date->format('F d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Verified Date</label>
                                                    <p class="form-control-static">
                                                        @if ($document->verified_date)
                                                            <i class="fas fa-calendar-check me-2 text-success"></i>
                                                            {{ $document->verified_date->format('F d, Y') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Created At</label>
                                                    <p class="form-control-static">
                                                        <i class="fas fa-clock me-2 text-secondary"></i>
                                                        {{ $document->created_at->format('F d, Y h:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small">Last Updated</label>
                                                    <p class="form-control-static">
                                                        <i class="fas fa-history me-2 text-secondary"></i>
                                                        {{ $document->updated_at->format('F d, Y h:i A') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($document->notes)
                                            <div class="mt-4">
                                                <label class="form-label text-muted small">Notes</label>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-0">{{ $document->notes }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Document Preview & Actions -->
                            <div class="col-md-4">
                                <!-- Document Preview -->
                                @if ($document->document_path)
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">Document Preview</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            @php
                                                $extension = pathinfo($document->document_path, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                ]);
                                                $isPdf = strtolower($extension) === 'pdf';
                                            @endphp

                                            @if ($isImage)
                                                <img src="{{ Storage::url($document->document_path) }}"
                                                    alt="Document Preview" class="img-fluid rounded mb-3"
                                                    style="max-height: 200px;">
                                            @elseif($isPdf)
                                                <div class="mb-3">
                                                    <i class="fas fa-file-pdf fa-4x text-danger"></i>
                                                    <p class="mt-2">PDF Document</p>
                                                </div>
                                            @else
                                                <div class="mb-3">
                                                    <i class="fas fa-file-alt fa-4x text-primary"></i>
                                                    <p class="mt-2">{{ strtoupper($extension) }} Document</p>
                                                </div>
                                            @endif

                                            <a href="{{ Storage::url($document->document_path) }}" target="_blank"
                                                class="btn btn-primary w-100 mb-2">
                                                <i class="fas fa-download me-2"></i>Download Document
                                            </a>
                                            <small class="text-muted">File:
                                                {{ basename($document->document_path) }}</small>
                                        </div>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            @can('documents.edit')
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.edit', $document) }}"
                                                class="btn btn-warning">
                                                <i class="fas fa-edit me-2"></i>Edit Document
                                            </a>
                                            @endcan
                                            @if ($document->status === 'pending')
                                                <form action="{{ route(auth()->user()->getRoleNames()->first() .'.documents.verify', $document) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to verify this document?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success w-100">
                                                        <i class="fas fa-check me-2"></i>Mark as Verified
                                                    </button>
                                                </form>
                                            @endif
                                            @can('documents.delete')

                                            <form action="{{ route(auth()->user()->getRoleNames()->first() .'.documents.destroy', $document) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this document? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger w-100">
                                                    <i class="fas fa-trash me-2"></i>Delete Document
                                                </button>
                                            </form>
                                            @endcan

                                            @can('documents.index')
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() .'.documents.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Back to List
                                            </a>
                                            @endcan
                                        </div>
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

@section('styles')
    <style>
        .form-control-static {
            padding: 0.375rem 0;
            margin-bottom: 0;
            font-size: 1rem;
            line-height: 1.5;
            color: #212529;
            background-color: transparent;
            border: solid transparent;
            border-width: 1px 0;
        }

        .card-header.bg-light {
            background-color: #f8f9fa !important;
        }

        .d-grid.gap-2 {
            gap: 10px;
        }
    </style>
@endsection
