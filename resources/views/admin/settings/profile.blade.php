@extends('admin.layouts.master')
@section('title')
    Profile
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .property-type-img {
            max-width: 80px;
            max-height: 60px;
            border-radius: 4px;
            object-fit: cover;
        }

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
    </style>
@endsection


@section('content')
    <style>
        :root {
            --eco-dark: #14532d;
            --eco-main: #166534;
            --eco-light: #15803d;
            --eco-gradient: linear-gradient(135deg, var(--eco-dark), var(--eco-light));
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            background-color: #f0f4f8;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 30px;
        }

        .page-header-title {
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-card {
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            background: #fff;
        }

        .profile-sidebar {
            background: var(--eco-gradient);
            position: relative;
            color: white;
            padding: 40px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        
        .profile-sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.6;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid rgba(255, 255, 255, 0.2);
            margin: 0 auto 24px;
            display: block;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            transition: .3s;
        }
        .profile-avatar:hover { transform: scale(1.05); border-color: rgba(255,255,255,0.4); }

        .profile-avatar-edit {
            position: relative;
            display: inline-block;
            cursor: pointer;
            z-index: 1;
        }

        .avatar-edit-icon {
            position: absolute;
            bottom: 25px;
            right: 0px;
            background: #fff;
            color: var(--eco-main);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            transition: .2s;
            font-size: 1.1rem;
        }
        .avatar-edit-icon:hover { transform: scale(1.1); background: #f8fafc; color: var(--eco-dark); }

        .profile-details {
            padding: 40px;
        }

        .profile-name {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 6px;
            color: #fff !important;
            letter-spacing: -0.5px;
            z-index: 1;
        }

        .profile-role-badge {
            background: rgba(255,255,255,0.2);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            backdrop-filter: blur(4px);
            margin-bottom: 16px;
            display: inline-block;
            z-index: 1;
        }

        .profile-info-list {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
            text-align: left;
            width: 100%;
            background: rgba(0,0,0,0.15);
            border-radius: 16px;
            padding: 20px;
            z-index: 1;
        }
        .profile-info-list li {
            font-size: .9rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.9);
        }
        .profile-info-list li:last-child { margin-bottom: 0; }
        .profile-info-list i { color: #a7f3d0; width: 16px; }

        .form-label {
            font-size: .8rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            padding: 14px 18px;
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            font-size: .95rem;
            font-weight: 600;
            color: var(--text-dark);
            background: #f8fafc;
            transition: .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--eco-main);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
        }

        .btn-primary {
            background: var(--eco-gradient);
            border: none;
            padding: 14px 32px;
            border-radius: 14px;
            font-weight: 800;
            box-shadow: 0 6px 15px rgba(22, 101, 52, 0.2);
            transition: .3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(22, 101, 52, 0.3);
            background: linear-gradient(135deg, #166534, #14532d);
        }

        .btn-outline-secondary {
            padding: 14px 32px;
            border-radius: 14px;
            font-weight: 800;
            border: 2px solid #e2e8f0;
            color: var(--text-muted);
            transition: .2s;
        }
        .btn-outline-secondary:hover { background: #f1f5f9; color: var(--text-dark); border-color: #cbd5e1; }

        /* Tab Styles */
        .nav-tabs {
            border-bottom: 2px solid #f1f5f9;
            margin-bottom: 30px;
            gap: 10px;
        }

        .nav-tabs .nav-link {
            border: none;
            color: var(--text-muted);
            font-weight: 700;
            padding: 14px 24px;
            border-radius: 12px 12px 0 0;
            transition: .2s;
            position: relative;
        }
        .nav-tabs .nav-link i { opacity: 0.5; transition: .2s; }

        .nav-tabs .nav-link:hover {
            color: var(--eco-main);
            background-color: transparent;
        }

        .nav-tabs .nav-link.active {
            color: var(--eco-main);
            background-color: transparent;
            font-weight: 800;
        }
        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0; width: 100%; height: 3px;
            background: var(--eco-main);
            border-radius: 3px 3px 0 0;
        }
        .nav-tabs .nav-link.active i { opacity: 1; color: var(--eco-main); }

        .tab-pane {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 14px 14px 0;
            color: var(--text-muted);
        }
        .form-control + .input-group-text { border-left: none; }
    </style>

    <div class="container-fluid profile-container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="page-header-title">
                    <i class="fas fa-user-edit" style="color: var(--eco-main);"></i> Profile Update
                </h2>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <div id="messageContainer"></div>

        <div class="row">
            <div class="col-12">
                <div class="card profile-card">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Left Sidebar with Image -->
                            <div class="col-lg-4 col-md-5 profile-sidebar">
                                <div class="profile-avatar-edit mb-3">
                                    <img src="{{ $user->profile_picture ? asset($user->profile_picture) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80' }}"
                                        alt="Avatar" class="profile-avatar" id="avatarPreview">
                                    <div class="avatar-edit-icon" data-bs-toggle="modal" data-bs-target="#avatarModal">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                </div>

                                <h3 class="profile-name">{{ $user->name }}</h3>
                                <div class="profile-role-badge">
                                    {{ $user->roles->first()->name ?? 'No Role Assigned' }}
                                </div>
                                
                                <ul class="profile-info-list">
                                    <li><i class="fas fa-envelope"></i> {{ $user->email }}</li>
                                    <li><i class="fas fa-phone-alt"></i> {{ $user->phone ?? 'Not Provided' }}</li>
                                    <li><i class="fas fa-map-marker-alt"></i> {{ $user->locality ?? 'Not Available' }}</li>
                                </ul>
                            </div>

                            <!-- Right Side with Tabs and Form -->
                            <div class="col-lg-8 col-md-7 profile-details">
                                <!-- Tabs Navigation -->
                                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="true">
                                            <i class="fas fa-user me-2"></i>Profile Information
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                            data-bs-target="#password" type="button" role="tab"
                                            aria-controls="password" aria-selected="false">
                                            <i class="fas fa-lock me-2"></i>Change Password
                                        </button>
                                    </li>
                                </ul>

                                <!-- Tab Content -->
                                <div class="tab-content" id="profileTabsContent">
                                    <!-- Profile Tab -->
                                    <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <form id="profileForm">
                                            @csrf
                                            <!-- Personal Information Section -->
                                            <div class="profile-section">

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="name" class="form-label">Full Name </label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $user->name }}" required>
                                                        <div class="invalid-feedback" id="nameError"></div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="email" class="form-label">Email Address </label>
                                                        <input type="email" class="form-control" id="email" readonly
                                                            name="email" value="{{ $user->email }}">
                                                        <div class="invalid-feedback" id="emailError"></div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="phone" class="form-label">Phone Number</label>
                                                        <input type="tel" class="form-control" id="phone"
                                                            name="phone" value="{{ $user->phone }}">
                                                        <div class="invalid-feedback" id="phoneError"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="role" class="form-label">Gender</label>
                                                        <select class="form-select" id="gender" name="gender">
                                                            <option value="male"
                                                                {{ $user->gender == 'male' ? 'selected' : '' }}>Male
                                                            </option>
                                                            <option value="female"
                                                                {{ $user->gender == 'female' ? 'selected' : '' }}>Female
                                                            </option>
                                                            <option value="other"
                                                                {{ $user->gender == 'other' ? 'selected' : '' }}>Other
                                                            </option>
                                                        </select>
                                                        <div class="invalid-feedback" id="emailError"></div>
                                                    </div>

                                                </div>


                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    id="cancelBtn">Cancel</button>
                                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                                            aria-hidden="true"></span>
                                                        Update Profile
                                                    </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Password Tab -->
                                    <div class="tab-pane fade" id="password" role="tabpanel"
                                        aria-labelledby="password-tab">
                                        <form id="passwordForm">
                                            @csrf
                                            <!-- Password Change Section -->
                                            <div class="profile-section">

                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="current_password" class="form-label">Current Password
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control"
                                                                id="current_password" name="current_password" required>
                                                            <span class="input-group-text password-toggle">
                                                                <i class="fas fa-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                        <div class="invalid-feedback" id="currentPasswordError"></div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="new_password" class="form-label">New Password </label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control" id="new_password"
                                                                name="new_password" required>
                                                            <span class="input-group-text password-toggle">
                                                                <i class="fas fa-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                        <div class="invalid-feedback" id="newPasswordError"></div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="new_password_confirmation" class="form-label">Confirm
                                                            New Password</label>
                                                        <div class="input-group">
                                                            <input type="password" class="form-control"
                                                                id="new_password_confirmation"
                                                                name="new_password_confirmation" required>
                                                            <span class="input-group-text password-toggle">
                                                                <i class="fas fa-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                        <div class="invalid-feedback" id="confirmPasswordError"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-flex justify-content-between mt-4">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    id="passwordCancelBtn">Cancel</button>
                                                    <button type="submit" class="btn btn-primary" id="passwordSubmitBtn">
                                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                                            aria-hidden="true"></span>
                                                        Change Password
                                                    </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Modal -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avatarModalLabel">Update Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Choose an image</label>
                        <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                        <div class="invalid-feedback" id="avatarError"></div>
                    </div>
                    <div class="text-center">
                        <img src="{{ $user->profile_picture ? asset($user->profile_picture) : 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=500&q=80' }}"
                            alt="Avatar Preview" class="img-fluid rounded" id="modalAvatarPreview"
                            style="max-height: 200px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveAvatarBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    @php
        $role = auth()->user()->getRoleNames()->first();
    @endphp
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tabs
            const triggerTabList = [].slice.call(document.querySelectorAll('#profileTabs button'));
            triggerTabList.forEach(function(triggerEl) {
                new bootstrap.Tab(triggerEl);
            });

            // Elements
            const profileForm = document.getElementById('profileForm');
            const passwordForm = document.getElementById('passwordForm');
            const messageContainer = document.getElementById('messageContainer');
            const submitBtn = document.getElementById('submitBtn');
            const passwordSubmitBtn = document.getElementById('passwordSubmitBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const passwordCancelBtn = document.getElementById('passwordCancelBtn');
            const avatarUpload = document.getElementById('avatar');
            const modalAvatarPreview = document.getElementById('modalAvatarPreview');
            const mainAvatarPreview = document.getElementById('avatarPreview');
            const saveAvatarBtn = document.getElementById('saveAvatarBtn');
            const avatarModal = document.getElementById('avatarModal');
            const modalInstance = new bootstrap.Modal(avatarModal);

            // Password visibility toggle
            document.querySelectorAll('.password-toggle').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    const input = this.parentElement.querySelector('input');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });

            // Avatar preview in modal
            avatarUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Validate file type and size
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                    const maxSize = 2 * 1024 * 1024; // 2MB

                    if (!validImageTypes.includes(file.type)) {
                        showMessage('Please select a valid image file (JPEG, PNG, GIF).', 'danger');
                        this.value = '';
                        return;
                    }

                    if (file.size > maxSize) {
                        showMessage('Image size should be less than 2MB.', 'danger');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        modalAvatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Save avatar button
            saveAvatarBtn.addEventListener('click', function() {
                const file = avatarUpload.files[0];
                if (!file) {
                    showMessage('Please select an image first.', 'danger');
                    return;
                }

                const formData = new FormData();
                formData.append('avatar', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Show loading state
                saveAvatarBtn.disabled = true;
                saveAvatarBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';
                const AVATAR_UPDATE = "{{ route($role . '.profile.update-avatar') }}";

                fetch(AVATAR_UPDATE, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            mainAvatarPreview.src = data.avatar_url;
                            modalInstance.hide();
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'Profile picture updated successfully!',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'small-toast'
                                }
                            });

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            showMessage(data.message || 'Error updating profile picture.', 'danger');
                        }
                    })
                    .catch(error => {
                        showMessage('An error occurred. Please try again.', 'danger');
                    })
                    .finally(() => {
                        saveAvatarBtn.disabled = false;
                        saveAvatarBtn.innerHTML = 'Save Changes';
                    });
            });

            // Profile Form submission
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                clearErrors();

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.querySelector('.spinner-border').classList.remove('d-none');

                // Create FormData object
                const formData = new FormData(this);

                const PROFILE_UPDATE = "{{ route($role . '.profile.update') }}";

                // Send AJAX request
                fetch(PROFILE_UPDATE, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'Profile updated successfully!',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'small-toast'
                                }
                            });

                            // Refresh page after 2 sec
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            // Display validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const errorElement = document.getElementById(field +
                                        'Error');
                                    if (errorElement) {
                                        const input = document.getElementById(field);
                                        if (input) {
                                            input.classList.add('is-invalid');
                                        }
                                        errorElement.textContent = data.errors[field][0];
                                    }
                                });
                                Swal.fire({
                                    toast: true,
                                    icon: 'error',
                                    title: 'Please correct the errors in the form.',
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    customClass: {
                                        popup: 'small-toast'
                                    }
                                });
                            } else {
                                Swal.fire({
                                    toast: true,
                                    icon: 'error',
                                    title: data.message || 'Error updating profile.',
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    customClass: {
                                        popup: 'small-toast'
                                    }
                                });
                            }
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            toast: true,
                            icon: 'error',
                            title: 'An error occurred. Please try again.',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            customClass: {
                                popup: 'small-toast'
                            }
                        });
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.querySelector('.spinner-border').classList.add('d-none');
                    });
            });

            // Password Form submission
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                clearErrors();

                // Validate password confirmation
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('new_password_confirmation').value;

                if (newPassword !== confirmPassword) {
                    document.getElementById('new_password').classList.add('is-invalid');
                    document.getElementById('new_password_confirmation').classList.add('is-invalid');
                    document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';

                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'Passwords do not match.',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            popup: 'small-toast'
                        }
                    });
                    return;
                }

                // Show loading state
                passwordSubmitBtn.disabled = true;
                passwordSubmitBtn.querySelector('.spinner-border').classList.remove('d-none');

                // Create FormData object
                const formData = new FormData(this);
                const CHANGE_PASSWORD_URL = "{{ route($role . '.profile.change-password') }}";


                // Send AJAX request
                fetch(CHANGE_PASSWORD_URL, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: 'Password updated successfully!',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'small-toast'
                                }
                            });

                            // Clear form and reset validation
                            passwordForm.reset();
                            clearErrors();
                        } else {
                            // Display validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const errorElement = document.getElementById(field +
                                        'Error');
                                    if (errorElement) {
                                        const input = document.getElementById(field);
                                        if (input) {
                                            input.classList.add('is-invalid');
                                        }
                                        errorElement.textContent = data.errors[field][0];
                                    }
                                });
                                Swal.fire({
                                    toast: true,
                                    icon: 'error',
                                    title: 'Please correct the errors in the form.',
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    customClass: {
                                        popup: 'small-toast'
                                    }
                                });
                            } else {
                                Swal.fire({
                                    toast: true,
                                    icon: 'error',
                                    title: data.message || 'Error changing password.',
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    customClass: {
                                        popup: 'small-toast'
                                    }
                                });
                            }
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            toast: true,
                            icon: 'error',
                            title: 'An error occurred. Please try again.',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            customClass: {
                                popup: 'small-toast'
                            }
                        });
                    })
                    .finally(() => {
                        passwordSubmitBtn.disabled = false;
                        passwordSubmitBtn.querySelector('.spinner-border').classList.add('d-none');
                    });
            });

            // Cancel buttons
            cancelBtn.addEventListener('click', function() {
                window.location.reload();
            });

            passwordCancelBtn.addEventListener('click', function() {
                passwordForm.reset();
                clearErrors();
            });

            // Helper function to show messages
            function showMessage(message, type) {
                messageContainer.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Auto dismiss after 5 seconds
                setTimeout(() => {
                    const alert = messageContainer.querySelector('.alert');
                    if (alert) {
                        bootstrap.Alert.getOrCreateInstance(alert).close();
                    }
                }, 5000);
            }

            // Helper function to clear validation errors
            function clearErrors() {
                const errorElements = document.querySelectorAll('.invalid-feedback');
                errorElements.forEach(element => {
                    element.textContent = '';
                });

                const invalidInputs = document.querySelectorAll('.is-invalid');
                invalidInputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });
            }
        });
    </script>
@endsection
