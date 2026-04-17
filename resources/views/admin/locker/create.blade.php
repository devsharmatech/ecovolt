@extends('admin.layouts.master')

@section('title') Add Document to Locker @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11 mx-auto">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <h4 class="card-title text-green mb-4" style="font-weight: 800; font-size: 22px;">Add Document to Digital Locker</h4>
                        
                        <form action="{{ route($role . '.locker.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 700;">Select Customer</label>
                                <select name="user_id" class="form-select" style="border-radius: 12px; height: 50px;" required>
                                    <option value="">-- Choose User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 700;">Category</label>
                                <select name="category" class="form-select" style="border-radius: 12px; height: 50px;" required>
                                    <option value="Project">Project Documents</option>
                                    <option value="Legal">Government / Legal</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 700;">Document Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Installation Manual" required style="border-radius: 12px; height: 50px;">
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 700;">Select File (PDF or Image)</label>
                                <input type="file" name="file" class="form-control" required style="border-radius: 12px; padding: 10px;">
                                <small class="text-muted">Max size: 10MB</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route($role . '.locker.index') }}" class="btn btn-light" style="border-radius: 12px; padding: 12px 30px;">Cancel</a>
                                <button type="submit" class="btn btn-primary" style="border-radius: 12px; padding: 12px 40px; font-weight: 700;">Upload to Locker</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
