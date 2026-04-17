@extends('admin.layouts.master')

@section('title') Quotation Management @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h4 class="card-title" style="font-weight: 800; color: #1a1a1a; font-size: 22px;">Quotation Management</h4>
                                <p class="text-muted m-0">Create and manage investment proposals for customers.</p>
                            </div>
                            <a href="{{ route($role . '.quotes.create') }}" class="btn btn-success waves-effect waves-light" style="border-radius: 12px; padding: 10px 20px; font-weight: 700;">
                                <i class="fas fa-plus-circle me-2"></i> Create New Quote
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="quotesTable" class="table table-hover align-middle" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th style="border-radius: 10px 0 0 10px;">User</th>
                                        <th>Lead ID</th>
                                        <th>Package</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th style="border-radius: 0 10px 10px 0;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quotes as $quote)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-success-subtle text-success font-size-12">
                                                        {{ strtoupper(substr($quote->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <span style="font-weight: 600;">{{ $quote->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($quote->project && $quote->project->lead)
                                                <a href="{{ route($role . '.leads.show', $quote->project->lead->id) }}" style="text-decoration: none;">
                                                    <code style="font-weight: 700; color: #166534; background: #f0fdf4; padding: 4px 8px; border-radius: 6px; border: 1px solid #bbf7d0;">
                                                        {{ $quote->project->lead->lead_code }}
                                                    </code>
                                                </a>
                                            @else
                                                <code style="font-weight: 700; color: #64748b;">N/A</code>
                                            @endif
                                        </td>
                                        <td>{{ $quote->package_name }}</td>
                                        <td style="font-weight: 800;">${{ number_format($quote->total_price, 2) }}</td>
                                        <td>
                                            @if($quote->status == 'accepted')
                                                <span class="badge bg-success-subtle text-success p-2" style="border-radius: 8px;">ACCEPTED</span>
                                            @elseif($quote->status == 'declined')
                                                <span class="badge bg-danger-subtle text-danger p-2" style="border-radius: 8px;">DECLINED</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning p-2" style="border-radius: 8px;">PENDING</span>
                                            @endif
                                        </td>
                                        <td class="text-muted">{{ $quote->quote_date->format('M d, Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="border-radius: 12px; border: none;">
                                                    <li><a class="dropdown-item" href="{{ route($role . '.quotes.show', $quote->id) }}"><i class="fas fa-eye me-2 text-info"></i> View Details</a></li>
                                                    <li><a class="dropdown-item" href="{{ route($role . '.quotes.edit', $quote->id) }}"><i class="fas fa-pen me-2 text-warning"></i> Edit Quote</a></li>
                                                    <li><a class="dropdown-item" href="{{ route($role . '.quotes.download', $quote->id) }}" target="_blank"><i class="fas fa-file-pdf me-2 text-primary"></i> Download PDF</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route($role . '.quotes.destroy', $quote->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-trash-alt me-2"></i> Delete Quote
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
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
        $('#quotesTable').DataTable({
            "pageLength": 10,
            "language": {
                "search": "Search Proposals:",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });
    });
</script>
@endsection
