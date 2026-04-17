@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-black">Test Notifications</h4>
                        <p class="card-subtitle">Send test notifications to verify your settings</p>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}

                                @if (session('test_data'))
                                    <div class="mt-3">
                                        <h6>Test Data Sent:</h6>
                                        <pre class="bg-light p-3 rounded">{{ json_encode(session('test_data'), JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                @endif

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route(auth()->user()->getRoleNames()->first() . '.notification.test') }}"
                            method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Notification Trigger *</label>
                                        <select name="trigger" class="form-select" required>
                                            <option value="">Select Trigger</option>
                                            @foreach ($triggers as $trigger)
                                                <option value="{{ $trigger }}"
                                                    {{ old('trigger') == $trigger ? 'selected' : '' }}>
                                                    {{ $trigger }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Channels *</label>
                                        <select name="channels" class="form-select" required>
                                            <option value="">Select Channel</option>
                                            @foreach ($channels as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('channels') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Recipient Type *</label>
                                        <select name="recipient_type" class="form-select" required>
                                            <option value="">Select Recipient Type</option>
                                            @foreach ($recipientTypes as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('recipient_type') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Test Email (Optional)</label>
                                        <input type="email" name="test_email" class="form-control"
                                            placeholder="Enter email for testing" value="{{ old('test_email') }}">
                                        <small class="text-muted">If provided, notification will be sent only to this
                                            email</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle me-2"></i>Instructions:</h6>
                                        <ul class="mb-0">
                                            <li>Select a trigger from the list</li>
                                            <li>Choose notification channels</li>
                                            <li>Select recipient type</li>
                                            <li>Optionally enter a test email</li>
                                            <li>Click "Send Test Notification"</li>
                                            <li>Check database notifications table and logs</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.notification.settings') }}"
                                    class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Settings
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Send Test Notification
                                </button>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Quick test via AJAX
            $('.quick-test').click(function() {
                const trigger = $(this).data('trigger');

                Swal.fire({
                    title: 'Sending Test',
                    text: 'Sending test notification for: ' + trigger,
                    icon: 'info',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });

                $.ajax({
                    url: '{{ route(auth()->user()->getRoleNames()->first() . '.notification.test') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        trigger: trigger
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.success) {
                            $('#quickTestResult').html(`
                        <div class="alert alert-success">
                            <h6><i class="fas fa-check-circle me-2"></i>Success!</h6>
                            <p>${response.message}</p>
                            <pre class="mt-2 mb-0">${JSON.stringify(response.data, null, 2)}</pre>
                        </div>
                    `);

                            // Auto-hide after 5 seconds
                            setTimeout(() => {
                                $('#quickTestResult').fadeOut();
                            }, 5000);
                        } else {
                            $('#quickTestResult').html(`
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-circle me-2"></i>Error!</h6>
                            <p>${response.message}</p>
                        </div>
                    `);
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        $('#quickTestResult').html(`
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-circle me-2"></i>Server Error!</h6>
                        <p>Failed to send test notification. Please check console.</p>
                    </div>
                `);
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
