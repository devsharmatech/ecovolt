@extends('admin.layouts.master')

@section('title') Edit {{ $page->title }} @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit {{ $page->title }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.cms.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <form action="{{ route(auth()->user()->getRoleNames()->first() . '.cms.update', $page->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Document Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">JSON Content (Mobile App Structure)</label>
                                <p class="text-muted small mb-2">This content is synced with the Mobile App. Modify with care to maintain the JSON structure.</p>
                                <textarea name="content" class="form-control" rows="15" style="font-family: monospace; font-size: 13px;">{{ $page->content }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-soft-info border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="text-info mb-3"><i class="fas fa-info-circle me-2"></i> How to Update?</h5>
                        <p class="text-dark-50 small">
                            The content is stored in **JSON format** so that the mobile app can render it with rich formatting and icons.
                        </p>
                        <ul class="text-dark-50 small">
                            <li><strong>version:</strong> Version number shown in app.</li>
                            <li><strong>date:</strong> Date shown in app.</li>
                            <li><strong>intro:</strong> The opening paragraph.</li>
                            <li><strong>sections:</strong> A list of points (title and text).</li>
                        </ul>
                        <div class="alert alert-warning mb-0 small">
                             <i class="fas fa-exclamation-triangle me-1"></i> <strong>Note:</strong> Be sure to keep the quotes and brackets balanced, otherwise the mobile app won't be able to display the page.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
