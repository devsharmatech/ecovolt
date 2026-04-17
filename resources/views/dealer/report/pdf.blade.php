<!DOCTYPE html>
<html>

<head>
    <title>Leads Report</title>
    <style>
        /* Simplified CSS for better PDF compatibility */
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .header h1 {
            color: #2e7d32;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header .report-date {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .filter-info {
            background: #f1f8e9;
            padding: 12px 15px;
            border-radius: 6px;
            border-left: 4px solid #4caf50;
            margin-top: 15px;
            font-size: 14px;
            color: #2e7d32;
        }

        .summary-section {
            display: block;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .summary-box {
            background: #f1f8e9;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            float: left;
            width: 18%;
            margin: 0 1.5%;
            border: 1px solid #c8e6c9;
            box-sizing: border-box;
        }

        .summary-box h3 {
            color: #2e7d32;
            margin: 0 0 10px 0;
            font-size: 13px;
            font-weight: 600;
        }

        .summary-value {
            font-size: 21px;
            font-weight: 700;
            color: #1b5e20;
            margin: 3px 0;
        }

        .summary-label {
            font-size: 10px;
            color: #558b2f;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #2e7d32;
            color: white;
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        td {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px;
            font-size: 14px;
            vertical-align: top;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-verified {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .document-id {
            font-weight: 700;
            color: #2e7d32;
        }

        .notes-cell {
            max-width: 200px;
            word-wrap: break-word;
        }

        .notes-content {
            font-size: 13px;
            color: #555;
            line-height: 1.4;
        }

        .empty-notes {
            color: #999;
            font-style: italic;
            font-size: 13px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        /* Clear float for summary section */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Leads Report</h1>
        <p class="report-date">Generated on: {{ date('Y-m-d H:i:s') }}</p>

        @if (isset($requestData['start_date']) || isset($requestData['end_date']) || isset($requestData['status']))
            <div class="filter-info">
                <p>
                    @if (isset($requestData['start_date']) && $requestData['start_date'])
                        <strong>From:</strong> {{ $requestData['start_date'] }}
                    @endif
                    @if (isset($requestData['end_date']) && $requestData['end_date'])
                        @if (isset($requestData['start_date']) && $requestData['start_date'])
                            &nbsp;|&nbsp;
                        @endif
                        <strong>To:</strong> {{ $requestData['end_date'] }}
                    @endif
                    @if (isset($requestData['status']) && $requestData['status'] && $requestData['status'] != 'All')
                        @if (
                            (isset($requestData['start_date']) && $requestData['start_date']) ||
                                (isset($requestData['end_date']) && $requestData['end_date']))
                            &nbsp;|&nbsp;
                        @endif
                        <strong>Status:</strong> {{ ucfirst($requestData['status']) }}
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Summary Section -->
    <div class="summary-section clearfix">
        <div class="summary-box">
            <h3>Total Documents</h3>
            <div class="summary-value">{{ $summary['total_documents'] ?? 0 }}</div>
            <div class="summary-label">All Documents</div>
        </div>

        <div class="summary-box">
            <h3>Verified</h3>
            <div class="summary-value">{{ $summary['verified_documents'] ?? 0 }}</div>
            <div class="summary-label">Successfully Verified</div>
        </div>

        <div class="summary-box">
            <h3>Pending</h3>
            <div class="summary-value">{{ $summary['pending_documents'] ?? 0 }}</div>
            <div class="summary-label">Awaiting Verification</div>
        </div>

        <div class="summary-box">
            <h3>Verification Rate</h3>
            <div class="summary-value">{{ $summary['verification_rate'] ?? 0 }}%</div>
            <div class="summary-label">Overall Success Rate</div>
        </div>
    </div>

    <!-- Documents Table - Fixed Structure -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Document Type</th>
                <th>File Name</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Lead Name</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($documents as $document)
                <tr>
                    <td><span class="document-id">#{{ $document->id }}</span></td>
                    <td>{{ $document->document_type ?? 'N/A' }}</td>
                    <td>{{ $document->file_name ?? 'N/A' }}</td>
                    <td>
                        @php
                            $statusClass = 'status-pending';
                            if (isset($document->status)) {
                                if ($document->status === 'verified') {
                                    $statusClass = 'status-verified';
                                } elseif ($document->status === 'rejected') {
                                    $statusClass = 'status-rejected';
                                }
                            }
                        @endphp
                        <span
                            class="status-badge {{ $statusClass }}">{{ ucfirst($document->status ?? 'pending') }}</span>
                    </td>
                    <td class="notes-cell">
                        @if (!empty($document->notes))
                            <div class="notes-content">
                                {{ $document->notes }}
                            </div>
                        @else
                            <span class="empty-notes">No notes</span>
                        @endif
                    </td>
                    <td>
                        @if ($document->lead)
                            {{ $document->lead->local_name ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ isset($document->created_at) ? $document->created_at->format('M d, Y') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #666;">
                        No documents found for the selected filters.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Report generated by Leads Management System </p>
        <p>Total Records: {{ $documents->count() }}</p>
    </div>
</body>

</html>
