@extends('admin.layouts.master')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .swal2-toast {
        font-size: 12px !important;
        padding: 6px 10px !important;
        min-width: auto !important;
        width: 220px !important;
        line-height: 1.3em !important;
    }

    .swal2-toast .swal2-icon {
        width: 24px !important;
        height: 24px !important;
        margin-right: 6px !important;
    }

    .swal2-toast .swal2-title {
        font-size: 13px !important;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
</style>

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-black">Notifications & Alerts</h4>
                        <p class="card-subtitle">Configure how you receive notifications and alerts for overdue documents.
                        </p>
                    </div>
                    <div class="card-body">
                        <form id="notificationSettingsForm"
                            action="{{ route(auth()->user()->getRoleNames()->first() . '.notification.settings.update') }}"
                            method="POST">
                            @csrf

                            <!-- Admin Panel Push Notifications -->
                            <div class="mb-5">
                                <h5 class="mb-3">Admin Panel Push Notifications</h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Alert Trigger</th>
                                                <th>Recipient</th>
                                                <th>Frequency</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($settings->where('notification_type', 'admin_panel_push') as $setting)
                                                <tr>
                                                    <td>
                                                        <input type="text"
                                                            name="settings[{{ $setting->id }}][alert_trigger]"
                                                            class="form-control" value="{{ $setting->alert_trigger }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="settings[{{ $setting->id }}][recipient]"
                                                            class="form-control" value="{{ $setting->recipient }}">
                                                    </td>
                                                    <td>
                                                        <select name="settings[{{ $setting->id }}][frequency]"
                                                            class="form-select">
                                                            <option value="Immediately"
                                                                {{ $setting->frequency == 'Immediately' ? 'selected' : '' }}>
                                                                Immediately</option>
                                                            <option value="Daily Digest"
                                                                {{ $setting->frequency == 'Daily Digest' ? 'selected' : '' }}>
                                                                Daily Digest</option>
                                                            <option value="Weekly"
                                                                {{ $setting->frequency == 'Weekly' ? 'selected' : '' }}>
                                                                Weekly</option>
                                                            <option value="Monthly"
                                                                {{ $setting->frequency == 'Monthly' ? 'selected' : '' }}>
                                                                Monthly</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox"
                                                                name="settings[{{ $setting->id }}][is_active]"
                                                                value="1" class="form-check-input" role="switch"
                                                                {{ $setting->is_active ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Email Alerts -->
                            <div class="mb-5">
                                <h5 class="mb-3">Email Alerts</h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Alert Trigger</th>
                                                <th>Recipient</th>
                                                <th>Frequency</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($settings->where('notification_type', 'email_alerts') as $setting)
                                                <tr>
                                                    <td>
                                                        <input type="text"
                                                            name="settings[{{ $setting->id }}][alert_trigger]"
                                                            class="form-control" value="{{ $setting->alert_trigger }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="settings[{{ $setting->id }}][recipient]"
                                                            class="form-control" value="{{ $setting->recipient }}">
                                                    </td>
                                                    <td>
                                                        <select name="settings[{{ $setting->id }}][frequency]"
                                                            class="form-select">
                                                            <option value="Immediately"
                                                                {{ $setting->frequency == 'Immediately' ? 'selected' : '' }}>
                                                                Immediately</option>
                                                            <option value="Daily Digest"
                                                                {{ $setting->frequency == 'Daily Digest' ? 'selected' : '' }}>
                                                                Daily Digest</option>
                                                            <option value="Weekly"
                                                                {{ $setting->frequency == 'Weekly' ? 'selected' : '' }}>
                                                                Weekly</option>
                                                            <option value="Monthly"
                                                                {{ $setting->frequency == 'Monthly' ? 'selected' : '' }}>
                                                                Monthly</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox"
                                                                name="settings[{{ $setting->id }}][is_active]"
                                                                value="1" class="form-check-input" role="switch"
                                                                {{ $setting->is_active ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Horizontal Rule -->
                            <hr class="my-4">

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route(auth()->user()->getRoleNames()->first() . '.notification.test.form') }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-vial me-2"></i>Test Notifications
                                    </a>
                                    {{-- <button type="button" class="btn btn-warning" id="testNotificationBtn">
                                        <i class="fas fa-vial me-2"></i>Test Notifications
                                    </button> --}}

                                    <a href="javascript:void(0)" class="btn btn-info ms-2" id="quickOverdueTest">
                                        <i class="fas fa-bolt me-2"></i>Quick Test
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logs Modal -->
    <div class="modal fade" id="logsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification Logs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="logsContent">
                        <p>Loading logs...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // JavaScript mein testNotificationBtn ke liye handler add karo
            $('#testNotificationBtn').click(function() {
                Swal.fire({
                    title: 'Test Notification',
                    html: `
            <div class="text-start">
                <div class="mb-3">
                    <label class="form-label">Select Trigger Type:</label>
                    <select id="testTrigger" class="form-select">
                        <option value="Document Overdue">Document Overdue</option>
                        <option value="Document Approval Required">Document Approval Required</option>
                        <option value="System Maintenance">System Maintenance</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Test Email (Optional):</label>
                    <input type="email" id="testEmail" class="form-control" placeholder="test@example.com">
                    <small class="form-text text-muted">Leave empty to use default recipients</small>
                </div>
            </div>
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Send Test',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const trigger = document.getElementById('testTrigger').value;
                        const email = document.getElementById('testEmail').value;

                        if (!trigger) {
                            Swal.showValidationMessage('Please select a trigger type');
                            return false;
                        }

                        return {
                            trigger: trigger,
                            email: email
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = result.value;

                        Swal.fire({
                            title: 'Sending...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '{{ route(auth()->user()->getRoleNames()->first() . '.notification.test') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                trigger: data.trigger,
                                test_email: data.email
                            },
                            success: function(response) {
                                Swal.close();

                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        html: `
                                <p>${response.message}</p>
                                <div class="text-start mt-3">
                                    <strong>Details:</strong>
                                    <div class="bg-light p-3 mt-2 rounded small">
                                        <strong>Trigger:</strong> ${data.trigger}<br>
                                        <strong>Sent To:</strong> ${data.email || 'Default Recipients'}<br>
                                        <strong>Time:</strong> ${new Date().toLocaleTimeString()}
                                    </div>
                                </div>
                            `,
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error',
                                    text: 'Failed to send test notification'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            // Quick test button (existing) - isko bhi update karo
            $('#quickOverdueTest').click(function() {
                Swal.fire({
                    title: 'Send Quick Test?',
                    text: 'This will send a Document Overdue test notification',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Send Test',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route(auth()->user()->getRoleNames()->first() . '.notification.test') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                trigger: 'Document Overdue'
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Sending...',
                                    text: 'Please wait',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function(response) {
                                Swal.close();

                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        html: `
                            <p>${response.message}</p>
                            <div class="text-start mt-3">
                                <strong>Test Data:</strong>
                                <pre class="bg-light p-2 mt-2 rounded">${JSON.stringify(response.data, null, 2)}</pre>
                            </div>
                        `,
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.close();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error',
                                    text: 'Failed to send test notification'
                                });
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });



        });
    </script>
@endsection
