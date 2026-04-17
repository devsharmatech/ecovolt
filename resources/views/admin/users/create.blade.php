@extends('admin.layouts.master')

<style>
/* ── Global ─────────────────────────────────────── */
.cf-wrap { padding: 24px; }

/* ── Page Header ────────────────────────────────── */
.cf-header {
    display: flex; align-items: center; justify-content: space-between;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #bbf7d0;
    border-radius: 16px; padding: 20px 28px; margin-bottom: 28px;
}
.cf-header-left h2 { font-size:1.5rem; font-weight:700; color:#1a1f36; margin:0; }
.cf-header-left p  { font-size:.82rem; color:#6b7280; margin:4px 0 0; }
.cf-back-btn {
    display:inline-flex; align-items:center; gap:7px;
    background:#fff; color:#374151; border:1.5px solid #d1d5db;
    border-radius:10px; padding:9px 18px; font-weight:600; font-size:.85rem;
    text-decoration:none; transition:all .2s;
}
.cf-back-btn:hover { background:#f9fafb; border-color:#9ca3af; color:#111; transform:translateY(-1px); }

/* ── Card ───────────────────────────────────────── */
.cf-card {
    background:#fff; border-radius:16px;
    box-shadow:0 2px 16px rgba(0,0,0,.07); overflow:hidden; margin-bottom:24px;
}
.cf-card-header {
    padding:16px 24px; border-bottom:1px solid #f0f2f7;
    display:flex; align-items:center; gap:10px;
}
.cf-card-header .hicon {
    width:36px; height:36px; border-radius:10px;
    background:linear-gradient(135deg,#2ecc71,#27ae60);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:.9rem;
}
.cf-card-header h6 { margin:0; font-weight:700; color:#1a1f36; font-size:.95rem; }
.cf-card-body { padding:28px 28px 8px; }

/* ── ID Preview ─────────────────────────────────── */
.id-preview-box {
    display:flex; align-items:center; gap:14px;
    background:linear-gradient(135deg,#f8f9fc,#eef0f8);
    border:1.5px dashed #c7d2fe; border-radius:12px;
    padding:14px 20px; margin-bottom:24px;
}
.id-preview-box .id-icon {
    width:42px; height:42px; border-radius:10px;
    background:linear-gradient(135deg,#636363,#e2e2e2);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:1rem; flex-shrink:0;
}
.id-preview-box .id-text span { font-size:.72rem; color:#6b7280; display:block; }
.id-preview-box .id-text strong { font-size:1.1rem; font-weight:800; color:#1a1f36; letter-spacing:.05em; }

/* ── Form Label + Input ─────────────────────────── */
.cf-label {
    display:block; font-size:.78rem; font-weight:600;
    color:#374151; margin-bottom:6px; letter-spacing:.02em;
}
.cf-label .req { color:#ef4444; margin-left:2px; }
.cf-input, .cf-select, .cf-textarea {
    width:100%; border:1.5px solid #e5e7eb; border-radius:10px;
    padding:10px 14px; font-size:.875rem; color:#1f2937;
    background:#fff; transition:border-color .2s, box-shadow .2s;
    outline:none;
}
.cf-input:focus, .cf-select:focus, .cf-textarea:focus {
    border-color:#27ae60; box-shadow:0 0 0 3px rgba(39,174,96,.12);
}
.cf-input.is-invalid, .cf-select.is-invalid { border-color:#ef4444; }
.cf-input:disabled { background:#f3f4f6; color:#9ca3af; }
.invalid-feedback { font-size:.75rem; color:#ef4444; display:block; margin-top:4px; }

/* ── Input Group (password) ─────────────────────── */
.pw-group { display:flex; }
.pw-group .cf-input { border-radius:10px 0 0 10px; }
.pw-btn {
    padding:10px 16px; border:1.5px solid #e5e7eb; border-left:none;
    border-radius:0 10px 10px 0; background:#f9fafb; color:#374151;
    font-size:.82rem; font-weight:600; cursor:pointer; white-space:nowrap;
    transition:.2s; display:flex; align-items:center; gap:6px;
}
.pw-btn:hover { background:#27ae60; color:#fff; border-color:#27ae60; }

/* ── Section subheader ──────────────────────────── */
.section-divider {
    display:flex; align-items:center; gap:14px; margin:28px 0 20px;
}
.section-divider .sd-icon {
    width:34px; height:34px; border-radius:9px;
    background:linear-gradient(135deg,#3b82f6,#1d4ed8);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:.8rem; flex-shrink:0;
}
.section-divider h5 { margin:0; font-size:.9rem; font-weight:700; color:#1a1f36; }
.section-divider::after {
    content:''; flex:1; height:1px; background:#f0f2f7;
}

/* ── File Upload ────────────────────────────────── */
.file-upload-box {
    border:2px dashed #d1d5db; border-radius:12px; padding:24px;
    text-align:center; cursor:pointer; transition:.2s;
    position:relative;
}
.file-upload-box:hover { border-color:#27ae60; background:#f0fdf4; }
.file-upload-box input[type=file] { position:absolute; inset:0; opacity:0; cursor:pointer; }
.file-upload-box .fu-icon { font-size:1.8rem; color:#9ca3af; margin-bottom:8px; }
.file-upload-box p { font-size:.8rem; color:#6b7280; margin:0; }

/* ── Buttons ─────────────────────────────────────── */
.cf-footer { padding:20px 28px; border-top:1px solid #f0f2f7; display:flex; gap:12px; align-items:center; }
.btn-create {
    display:inline-flex; align-items:center; gap:8px;
    background:linear-gradient(135deg,#2ecc71,#27ae60);
    color:#fff; border:none; border-radius:10px;
    padding:11px 24px; font-weight:700; font-size:.875rem;
    cursor:pointer; box-shadow:0 4px 14px rgba(39,174,96,.3);
    transition:transform .2s, box-shadow .2s;
}
.btn-create:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(39,174,96,.4); }
.btn-cancel {
    display:inline-flex; align-items:center; gap:7px;
    background:#fff; color:#374151; border:1.5px solid #d1d5db;
    border-radius:10px; padding:10px 20px; font-weight:600;
    font-size:.875rem; text-decoration:none; transition:.2s;
}
.btn-cancel:hover { background:#f3f4f6; }

/* ── Form Row ────────────────────────────────────── */
.form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-field  { margin-bottom:20px; }

@media(max-width:768px) { .form-row-2 { grid-template-columns:1fr; } }
</style>

@section('content')
<div class="cf-wrap">

    {{-- ── PAGE HEADER ──────────────────────────────────── --}}
    <div class="cf-header">
        <div class="cf-header-left">
            <h2>
                <i class="fas fa-user-plus" style="color:#27ae60;margin-right:8px;"></i>
                Create New {{ $requestedRole == 'user' ? 'User' : ucfirst($requestedRole) }}
            </h2>
            <p>Fill in the details below to add a new {{ strtolower($requestedRole == 'user' ? 'user' : ucfirst($requestedRole)) }} to the system</p>
        </div>
        <a href="{{ route('admin.users.index') }}?role={{ $requestedRole }}" class="cf-back-btn">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route(auth()->user()->getRoleNames()->first() . '.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="role" value="{{ $requestedRole ?? 'user' }}">

        {{-- ── MAIN INFO CARD ─────────────────────────────── --}}
        <div class="cf-card">
            <div class="cf-card-header">
                <div class="hicon"><i class="fas fa-id-card"></i></div>
                <h6>Account Information</h6>
            </div>
            <div class="cf-card-body">

                {{-- ID Preview --}}
                <div class="id-preview-box">
                    <div class="id-icon"><i class="fas fa-fingerprint"></i></div>
                    <div class="id-text">
                        <span>Auto-Generated System ID (Read Only)</span>
                        <strong>{{ $nextId }}</strong>
                    </div>
                    <i class="fas fa-lock" style="color:#9ca3af;margin-left:auto;"></i>
                </div>

                {{-- Name + Email --}}
                <div class="form-row-2">
                    <div class="form-field">
                        <label class="cf-label">Full Name <span class="req">*</span></label>
                        <input type="text" name="name" id="name" class="cf-input @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Enter full name" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-field">
                        <label class="cf-label">Email Address <span class="req">*</span></label>
                        <input type="email" name="email" id="email" class="cf-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="email@example.com" required>
                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                {{-- Password + Confirm --}}
                <div class="form-row-2">
                    <div class="form-field">
                        <label class="cf-label">Password <span class="req">*</span></label>
                        <div class="pw-group">
                            <input type="password" name="password" id="password" class="cf-input @error('password') is-invalid @enderror" required>
                            <button type="button" class="pw-btn" onclick="generatePassword()">
                                <i class="fas fa-magic"></i> Generate
                            </button>
                        </div>
                        @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-field">
                        <label class="cf-label">Confirm Password <span class="req">*</span></label>
                        <div class="pw-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="cf-input" required>
                            <button type="button" class="pw-btn" onclick="togglePasswordVisibility()" title="Toggle visibility">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Phone + Gender --}}
                <div class="form-row-2">
                    <div class="form-field">
                        <label class="cf-label">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="cf-input"
                               value="{{ old('phone') }}" placeholder="10-digit mobile number"
                               minlength="10" maxlength="10" pattern="\d{10}"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                    </div>
                    <div class="form-field">
                        <label class="cf-label">Gender</label>
                        <select name="gender" id="gender" class="cf-select">
                            <option value="">Select Gender</option>
                            <option value="male"   {{ old('gender') == 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('gender') == 'other'  ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                {{-- Locality --}}
                <div class="form-field">
                    <label class="cf-label">Locality / Area</label>
                    <input type="text" name="locality" id="locality" class="cf-input"
                           value="{{ old('locality') }}" placeholder="City / Area / Locality">
                </div>

                {{-- Profile Picture --}}
                <div class="form-field">
                    <label class="cf-label">Profile Picture</label>
                    <div class="file-upload-box" id="fileDropZone">
                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                        <div class="fu-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <p id="fileLabel">Click or drag an image here to upload</p>
                    </div>
                    <div class="mt-2 text-center" style="display:none;" id="previewWrap">
                        <img id="profilePreview" src="" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #27ae60;">
                    </div>
                </div>

            </div>{{-- /card-body --}}

            {{-- ── DEALER EXTRA SECTIONS ─────────────────────── --}}
            @if($requestedRole === 'Dealer')
            <div class="cf-card-body">
                <div class="section-divider">
                    <div class="sd-icon"><i class="fas fa-building"></i></div>
                    <h5>Business Information</h5>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label class="cf-label">Business / Company Name</label>
                        <input type="text" name="business_name" id="business_name" class="cf-input"
                               placeholder="Enter company name" value="{{ old('business_name') }}">
                    </div>
                    <div class="form-field">
                        <label class="cf-label">Business Type</label>
                        <select name="business_type" id="business_type" class="cf-select">
                            <option value="">Select Type</option>
                            <option value="Proprietorship">Proprietorship</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Private Limited">Private Limited</option>
                            <option value="Public Limited">Public Limited</option>
                            <option value="LLP">LLP</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label class="cf-label">GST Number</label>
                        <input type="text" name="gst_number" id="gst_number" class="cf-input"
                               placeholder="GST (optional)" value="{{ old('gst_number') }}">
                    </div>
                    <div class="form-field">
                        <label class="cf-label">PAN Number</label>
                        <input type="text" name="pan_number" id="pan_number" class="cf-input"
                               placeholder="PAN number" value="{{ old('pan_number') }}">
                    </div>
                    <div class="form-field" style="grid-column:span 2">
                        <label class="cf-label">Complete Business Address</label>
                        <textarea name="business_address" id="business_address" class="cf-textarea" rows="2"
                                  placeholder="Full address">{{ old('business_address') }}</textarea>
                    </div>
                </div>

                <div class="section-divider">
                    <div class="sd-icon"><i class="fas fa-university"></i></div>
                    <h5>Bank Details</h5>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label class="cf-label">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" class="cf-input" value="{{ old('bank_name') }}">
                    </div>
                    <div class="form-field">
                        <label class="cf-label">Account Number</label>
                        <input type="text" name="account_number" id="account_number" class="cf-input" value="{{ old('account_number') }}">
                    </div>
                    <div class="form-field">
                        <label class="cf-label">IFSC Code</label>
                        <input type="text" name="ifsc_code" id="ifsc_code" class="cf-input" value="{{ old('ifsc_code') }}">
                    </div>
                    <div class="form-field">
                        <label class="cf-label">Account Holder Name</label>
                        <input type="text" name="account_holder_name" id="account_holder_name" class="cf-input" value="{{ old('account_holder_name') }}">
                    </div>
                </div>
            </div>
            @endif

            {{-- Footer Buttons --}}
            <div class="cf-footer">
                <button type="submit" class="btn-create">
                    <i class="fas fa-save"></i>
                    Create {{ $requestedRole == 'user' ? 'User' : rtrim(ucfirst($requestedRole), 's') }}
                </button>
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}?role={{ $requestedRole }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    // Profile picture preview
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('profilePreview').src = ev.target.result;
                document.getElementById('previewWrap').style.display = 'block';
                document.getElementById('fileLabel').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    });

    function generatePassword() {
        var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
        var password = "";
        for (var i = 0; i < 12; i++) {
            password += chars[Math.floor(Math.random() * chars.length)];
        }
        document.getElementById("password").value = password;
        document.getElementById("password_confirmation").value = password;
        document.getElementById("password").type = "text";
        document.getElementById("password_confirmation").type = "text";
        document.getElementById("togglePasswordIcon").className = "fas fa-eye-slash";
    }

    function togglePasswordVisibility() {
        var pass    = document.getElementById("password");
        var confirm = document.getElementById("password_confirmation");
        var icon    = document.getElementById("togglePasswordIcon");
        if (pass.type === "password") {
            pass.type = confirm.type = "text";
            icon.className = "fas fa-eye-slash";
        } else {
            pass.type = confirm.type = "password";
            icon.className = "fas fa-eye";
        }
    }
</script>
@endsection
