@extends('admin.layouts.master')

@section('title') User Enquiries Management @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        z

        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title" style="font-weight: 800; color: #1a1a1a; font-size: 20px;">Solar Enquiries</h4>
                                <p class="text-muted m-0">Review and manage site enquiries from potential customers.</p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="enquiryTable" class="table table-hover align-middle" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border-radius: 10px 0 0 10px;">ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Load (kW)</th>
                                        <th>Status</th>
                                        <th>Submitted On</th>
                                        <th style="border-radius: 0 10px 10px 0;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enquiries as $enquiry)
                                    <tr>
                                        <td>#{{ $enquiry->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary font-size-12">
                                                        {{ strtoupper(substr($enquiry->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span style="font-weight: 600; display: block;">{{ $enquiry->name }}</span>
                                                    <small class="text-muted">{{ $enquiry->address }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $enquiry->mobile }}</td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success p-2" style="border-radius: 8px;">{{ $enquiry->load_requirement }} kW</span>
                                        </td>
                                        <td>
                                            <form action="{{ route($role . '.enquiries.status.update', $enquiry->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="border-radius: 10px; border-color: #eee;">
                                                    <option value="pending" {{ $enquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="contacted" {{ $enquiry->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                    <option value="visited" {{ $enquiry->status == 'visited' ? 'selected' : '' }}>Site Visited</option>
                                                    <option value="converted" {{ $enquiry->status == 'converted' ? 'selected' : '' }}>Converted</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="text-muted">{{ $enquiry->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route($role . '.enquiries.show', $enquiry->id) }}" class="btn btn-light btn-sm" style="border-radius: 8px;">
                                                    <i class="fas fa-eye text-primary"></i>
                                                </a>
                                                <form action="{{ route($role . '.enquiries.destroy', $enquiry->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm" style="border-radius: 8px;" onclick="return confirm('Delete this enquiry?')">
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
        $('#enquiryTable').DataTable({
            "pageLength": 10,
            "order": [[0, "desc"]],
            "language": {
                "search": "Filter enquiries:",
            }
        });
    });
</script>
@endsection
