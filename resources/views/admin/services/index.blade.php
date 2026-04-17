@extends('admin.layouts.master')

@section('title') Service Requests Management @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <div class="mb-4">
                            <h4 class="card-title" style="font-weight: 800; color: #1a1a1a; font-size: 22px;">Service Requests</h4>
                            <p class="text-muted m-0">Monitor and manage technical visit requests from customers.</p>
                        </div>

                        <div class="table-responsive">
                            <table id="serviceTable" class="table table-hover align-middle" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border-radius: 10px 0 0 10px;">ID</th>
                                        <th>Customer</th>
                                        <th>Issue Type</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th style="border-radius: 0 10px 10px 0;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $request)
                                    <tr>
                                        <td>#{{ $request->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-success-subtle text-success font-size-12">
                                                        {{ strtoupper(substr($request->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <span style="font-weight: 600;">{{ $request->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info p-2" style="border-radius: 8px;">{{ $request->issue_type }}</span>
                                        </td>
                                        <td style="max-width: 300px;">
                                            <p class="mb-0 text-truncate" title="{{ $request->description }}">{{ $request->description }}</p>
                                        </td>
                                        <td>
                                            <form action="{{ route($role . '.services.status.update', $request->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="border-radius: 10px; border-color: #eee;">
                                                    <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="in-progress" {{ $request->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="resolved" {{ $request->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="text-muted">{{ $request->created_at->format('d M Y, h:i A') }}</td>
                                        <td>
                                            <form action="{{ route($role . '.services.destroy', $request->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm" style="border-radius: 8px;" onclick="return confirm('Remove this request?')">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </button>
                                            </form>
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
        $('#serviceTable').DataTable({
            "pageLength": 10,
            "order": [[0, "desc"]],
            "language": {
                "search": "Search requests:",
            }
        });
    });
</script>
@endsection
