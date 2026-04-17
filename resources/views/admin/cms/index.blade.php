@extends('admin.layouts.master')

@section('title') Legal Documents @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Legal Documents</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                            <li class="breadcrumb-item active">Legal Documents</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table id="cmsTable" class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>Document Title</th>
                                        <th>Slug</th>
                                        <th>Last Updated</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pages as $page)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-3">
                                                    <span class="avatar-title rounded-circle bg-soft-success text-success">
                                                        <i class="fas fa-file-alt"></i>
                                                    </span>
                                                </div>
                                                <span class="fw-bold">{{ $page->title }}</span>
                                            </div>
                                        </td>
                                        <td><code>{{ $page->slug }}</code></td>
                                        <td>{{ $page->updated_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.cms.edit', $page->id) }}" 
                                               class="btn btn-sm btn-soft-primary px-3 rounded-pill">
                                                <i class="fas fa-edit me-1"></i> Edit Content
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#cmsTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "search": "Search documents:",
                "paginate": {
                    "next": "<i class='fas fa-chevron-right'></i>",
                    "previous": "<i class='fas fa-chevron-left'></i>"
                }
            }
        });
    });
</script>
@endsection
