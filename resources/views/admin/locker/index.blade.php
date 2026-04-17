@extends('admin.layouts.master')

@section('title') Digital Locker Management @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h4 class="card-title" style="font-weight: 800; color: #1a1a1a; font-size: 22px;">Digital Locker</h4>
                                <p class="text-muted m-0">Upload and manage documents for your customers.</p>
                            </div>
                            <a href="{{ route($role . '.locker.create') }}" class="btn btn-primary waves-effect waves-light" style="border-radius: 12px; padding: 10px 20px; font-weight: 700;">
                                <i class="fas fa-plus-circle me-2"></i> Add New Document
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="lockerTable" class="table table-hover align-middle" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border-radius: 10px 0 0 10px;">Customer</th>
                                        <th>Category</th>
                                        <th>Document Title</th>
                                        <th>File Type</th>
                                        <th>Size</th>
                                        <th>Uploaded Date</th>
                                        <th style="border-radius: 0 10px 10px 0;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $doc)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-12">
                                                        {{ strtoupper(substr($doc->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <span style="font-weight: 600;">{{ $doc->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($doc->category == 'Project')
                                                <span class="badge bg-success-subtle text-success p-2" style="border-radius: 8px;">Project Documents</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning p-2" style="border-radius: 8px;">Government/Legal</span>
                                            @endif
                                        </td>
                                        <td style="font-weight: 700;">{{ $doc->title }}</td>
                                        <td>
                                            @if(strtolower($doc->file_type) == 'pdf')
                                                <i class="fas fa-file-pdf text-danger me-1"></i> PDF
                                            @else
                                                <i class="fas fa-file-image text-info me-1"></i> Image
                                            @endif
                                        </td>
                                        <td>{{ $doc->file_size }}</td>
                                        <td class="text-muted">{{ $doc->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-light btn-sm" style="border-radius: 8px;">
                                                    <i class="fas fa-download text-primary"></i>
                                                </a>
                                                <form action="{{ route($role . '.locker.destroy', $doc->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm" style="border-radius: 8px;" onclick="return confirm('Remove this document?')">
                                                        <i class="fas fa-trash-alt text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
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

@section('script')
<script>
    $(document).ready(function() {
        $('#lockerTable').DataTable({
            "pageLength": 10,
            "language": {
                "search": "Search documents:",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });
</script>
@endsection
