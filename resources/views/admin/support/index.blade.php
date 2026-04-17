@extends('admin.layouts.master')
@section('title')
    Support & FAQ Management
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .page-header {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #249722;
        }

        .support-tabs {
            display: flex;
            gap: 24px;
            border-bottom: 2px solid #eaeaea;
            margin-bottom: 24px;
        }

        .support-tab-link {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 600;
            padding: 12px 10px;
            border: none;
            background: transparent;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
        }

        .support-tab-link.active {
            color: #249722;
            border-bottom: 3px solid #249722;
        }

        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #eaeaea;
            padding: 16px 20px;
            font-weight: 700;
        }

        .btn-primary {
            background: #249722;
            border-color: #249722;
        }

        .btn-primary:hover {
            background: #1e7e1c;
            border-color: #1e7e1c;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="fw-bold mb-1">Support & FAQ Management</h3>
            <p class="text-muted mb-0">Configure contact settings and manage frequent questions</p>
        </div>

        <!-- Tabs -->
        <div class="support-tabs">
            <button class="support-tab-link active" id="settingsTab" onclick="showTab('settings-section', this)">
                <i class="fas fa-cog me-2"></i>Support Settings
            </button>
            <button class="support-tab-link" id="faqTab" onclick="showTab('faq-section', this)">
                <i class="fas fa-question-circle me-2"></i>FAQ Management
            </button>
        </div>

        <!-- Support Settings Section -->
        <div id="settings-section" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <span>Support Contact Details</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.support.settings.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">WhatsApp Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white"><i class="fab fa-whatsapp"></i></span>
                                        <input type="text" class="form-control" name="whatsapp" value="{{ $settings->whatsapp }}" placeholder="+91..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Helpline Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control" name="helpline" value="{{ $settings->helpline }}" placeholder="1800..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Support Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-info text-white"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" value="{{ $settings->email }}" placeholder="support@..." required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary px-4">Save Configuration</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- FAQ Management Section -->
        <div id="faq-section" class="tab-content" style="display: none;">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Frequently Asked Questions</span>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#faqCreateModal">
                        <i class="fas fa-plus me-1"></i> Add New FAQ
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($faqs as $faq)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $faq->question }}</strong></td>
                                        <td>{{ \Illuminate\Support\Str::limit($faq->answer, 100) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary me-1" 
                                                onclick="openEditFAQ({{ $faq->id }}, '{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.support.faqs.destroy', $faq->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this FAQ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No FAQs found. Add one to get started.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create FAQ Modal -->
    <div class="modal fade" id="faqCreateModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('admin.support.faqs.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control" name="answer" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit FAQ Modal -->
    <div class="modal fade" id="faqEditModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" id="editFaqForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit FAQ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" id="editFaqQuestion" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control" name="answer" id="editFaqAnswer" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showTab(tab, el) {
            document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
            document.querySelectorAll('.support-tab-link').forEach(l => l.classList.remove('active'));
            
            document.getElementById(tab).style.display = 'block';
            el.classList.add('active');
        }

        function openEditFAQ(id, question, answer) {
            document.getElementById('editFaqQuestion').value = question;
            document.getElementById('editFaqAnswer').value = answer;
            document.getElementById('editFaqForm').action = "{{ url('admin/support/faqs') }}/" + id;
            var faqEditModal = new bootstrap.Modal(document.getElementById('faqEditModal'));
            faqEditModal.show();
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection
