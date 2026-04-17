@extends('admin.layouts.master')

<style>
/* ── Global ─────────────────────────────────────── */
.eu-wrap { padding: 24px; }

/* ── Page Header ────────────────────────────────── */
.eu-header {
    display:flex; align-items:center; justify-content:space-between;
    background:linear-gradient(135deg,#f0fdf4,#dcfce7);
    border:1px solid #bbf7d0; border-radius:16px;
    padding:20px 28px; margin-bottom:28px;
}
.eu-header h2 { font-size:1.45rem; font-weight:700; color:#1a1f36; margin:0; }
.eu-header p  { font-size:.82rem; color:#6b7280; margin:4px 0 0; }
.eu-back-btn {
    display:inline-flex; align-items:center; gap:7px;
    background:#fff; color:#374151; border:1.5px solid #d1d5db;
    border-radius:10px; padding:9px 18px; font-weight:600;
    font-size:.85rem; text-decoration:none; transition:.2s;
}
.eu-back-btn:hover { background:#f9fafb; border-color:#9ca3af; color:#111; transform:translateY(-1px); }

/* ── Main Grid ──────────────────────────────────── */
.eu-grid { display:grid; grid-template-columns:260px 1fr; gap:24px; align-items:start; }

/* ── Avatar Sidebar ─────────────────────────────── */
.eu-avatar-card {
    background:#fff; border-radius:16px;
    box-shadow:0 2px 16px rgba(0,0,0,.07); overflow:hidden; text-align:center;
}
.eu-avatar-bg {
    background:linear-gradient(135deg,#2ecc71,#27ae60); height:70px;
}
.eu-avatar-wrap {
    margin:-40px auto 0; width:82px; position:relative; z-index:1;
}
.eu-avatar-img {
    width:82px; height:82px; border-radius:50%;
    object-fit:cover; border:4px solid #fff;
    box-shadow:0 4px 14px rgba(0,0,0,.12);
}
.eu-avatar-initials {
    width:82px; height:82px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:1.8rem; font-weight:800; color:#fff;
    border:4px solid #fff; box-shadow:0 4px 14px rgba(0,0,0,.12);
}
.eu-avatar-body { padding:12px 18px 20px; }
.eu-avatar-body h5 { font-size:.95rem; font-weight:700; color:#1a1f36; margin:10px 0 2px; }
.eu-avatar-body p  { font-size:.73rem; color:#6b7280; margin:0 0 10px; }
.eu-code-tag {
    display:inline-block;
    background:linear-gradient(135deg,#636363,#e2e2e2);
    color:#fff; font-size:.68rem; font-weight:700;
    padding:3px 12px; border-radius:20px; letter-spacing:.04em;
}
.eu-upload-hint { font-size:.72rem; color:#9ca3af; margin-top:10px; display:block; }

/* ── Form Card ──────────────────────────────────── */
.eu-card {
    background:#fff; border-radius:16px;
    box-shadow:0 2px 16px rgba(0,0,0,.07); overflow:hidden;
}
.eu-card-header {
    padding:15px 22px; border-bottom:1px solid #f0f2f7;
    display:flex; align-items:center; gap:10px;
}
.eu-card-header .hicon {
    width:34px; height:34px; border-radius:9px;
    background:linear-gradient(135deg,#2ecc71,#27ae60);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:.85rem;
}
.eu-card-header h6 { margin:0; font-weight:700; color:#1a1f36; font-size:.9rem; }
.eu-card-body { padding:24px 24px 4px; }

/* ── Form Fields ────────────────────────────────── */
.eu-label {
    display:block; font-size:.77rem; font-weight:600;
    color:#374151; margin-bottom:6px; letter-spacing:.02em;
}
.eu-label .req { color:#ef4444; margin-left:2px; }
.eu-input, .eu-select {
    width:100%; border:1.5px solid #e5e7eb; border-radius:10px;
    padding:10px 14px; font-size:.875rem; color:#1f2937;
    background:#fff; transition:border-color .2s, box-shadow .2s; outline:none;
}
.eu-input:focus, .eu-select:focus {
    border-color:#27ae60; box-shadow:0 0 0 3px rgba(39,174,96,.12);
}
.eu-input.is-invalid { border-color:#ef4444; }
.invalid-feedback { font-size:.75rem; color:#ef4444; display:block; margin-top:4px; }
.form-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-field  { margin-bottom:20px; }

/* ── Password Section ───────────────────────────── */
.eu-pass-section {
    background:#f8f9fc; border:1.5px dashed #e5e7eb;
    border-radius:12px; padding:16px 20px; margin-bottom:20px;
}
.eu-pass-section .pass-hint {
    font-size:.75rem; color:#6b7280; margin-bottom:12px;
    display:flex; align-items:center; gap:7px;
}
.eu-pass-section .pass-hint i { color:#f59e0b; }

/* ── File Upload ────────────────────────────────── */
.eu-file-box {
    border:2px dashed #d1d5db; border-radius:10px; padding:18px;
    text-align:center; cursor:pointer; position:relative; transition:.2s;
}
.eu-file-box:hover { border-color:#27ae60; background:#f0fdf4; }
.eu-file-box input { position:absolute; inset:0; opacity:0; cursor:pointer; }
.eu-file-box .fu-icon { font-size:1.5rem; color:#9ca3af; margin-bottom:6px; }
.eu-file-box p { font-size:.75rem; color:#6b7280; margin:0; }

/* ── Footer ─────────────────────────────────────── */
.eu-footer { padding:18px 24px; border-top:1px solid #f0f2f7; display:flex; gap:12px; align-items:center; }
.btn-update {
    display:inline-flex; align-items:center; gap:8px;
    background:linear-gradient(135deg,#2ecc71,#27ae60);
    color:#fff; border:none; border-radius:10px;
    padding:11px 24px; font-weight:700; font-size:.875rem;
    cursor:pointer; box-shadow:0 4px 14px rgba(39,174,96,.3); transition:.2s;
}
.btn-update:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(39,174,96,.4); }
.btn-cancel-link {
    display:inline-flex; align-items:center; gap:7px;
    background:#fff; color:#374151; border:1.5px solid #d1d5db;
    border-radius:10px; padding:10px 20px; font-weight:600;
    font-size:.875rem; text-decoration:none; transition:.2s;
}
.btn-cancel-link:hover { background:#f3f4f6; color:#111; }

@media(max-width:900px) { .eu-grid { grid-template-columns:1fr; } }
</style>

@section('content')
<div class="eu-wrap">

    {{-- ── HEADER ─────────────────────────────────────── --}}
    <div class="eu-header">
        <div>
            <h2><i class="fas fa-user-edit" style="color:#27ae60;margin-right:8px;"></i>Edit User</h2>
            <p>Update details for <strong>{{ $user->name }}</strong></p>
        </div>
        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}?role={{ $roleName }}"
           class="eu-back-btn">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route(auth()->user()->getRoleNames()->first() . '.users.update', $user) }}"
          method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="eu-grid">

            {{-- ── LEFT: AVATAR + UPLOAD ─────────────────────── --}}
            <div>
                <div class="eu-avatar-card">
                    <div class="eu-avatar-bg"></div>
                    <div class="eu-avatar-wrap">
                        @if($user->profile_picture)
                            <img id="profilePreview" src="{{ asset('storage/' . $user->profile_picture) }}" class="eu-avatar-img" alt="{{ $user->name }}">
                        @else
                            @php $colors = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6']; $c = $colors[crc32($user->name) % count($colors)]; @endphp
                            <img id="profilePreview" src="https://via.placeholder.com/82x82/{{ ltrim($c,'#') }}/ffffff?text={{ strtoupper(substr($user->name,0,1)) }}"
                                 class="eu-avatar-img" alt="{{ $user->name }}">
                        @endif
                    </div>
                    <div class="eu-avatar-body">
                        <h5>{{ $user->name }}</h5>
                        <p>{{ $user->email }}</p>
                        @if($user->user_code)<div class="eu-code-tag">{{ $user->user_code }}</div>@endif

                        <div class="eu-file-box mt-3">
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                            <div class="fu-icon"><i class="fas fa-camera"></i></div>
                            <p id="fileLabel">Click to change photo</p>
                        </div>
                        <span class="eu-upload-hint">JPG, PNG · Max 2 MB</span>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: FORM ────────────────────────────────── --}}
            <div class="eu-card">
                <div class="eu-card-header">
                    <div class="hicon"><i class="fas fa-id-card"></i></div>
                    <h6>Personal Information</h6>
                </div>
                <div class="eu-card-body">

                    <div class="form-row-2">
                        <div class="form-field">
                            <label class="eu-label">Full Name <span class="req">*</span></label>
                            <input type="text" name="name" id="name"
                                   class="eu-input @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-field">
                            <label class="eu-label">Email Address <span class="req">*</span></label>
                            <input type="email" name="email" id="email"
                                   class="eu-input @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-field">
                            <label class="eu-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="eu-input"
                                   value="{{ old('phone', $user->phone) }}"
                                   minlength="10" maxlength="10" pattern="\d{10}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                        </div>
                        <div class="form-field">
                            <label class="eu-label">Gender</label>
                            <select name="gender" id="gender" class="eu-select">
                                <option value="">Select Gender</option>
                                <option value="male"   {{ old('gender', $user->gender) == 'male'   ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other"  {{ old('gender', $user->gender) == 'other'  ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="eu-label">Locality / Area</label>
                        <input type="text" name="locality" id="locality" class="eu-input"
                               value="{{ old('locality', $user->locality) }}" placeholder="City / Area">
                    </div>

                    {{-- Password Change Section --}}
                    <div class="eu-pass-section">
                        <div class="pass-hint">
                            <i class="fas fa-info-circle"></i>
                            Leave password blank to keep the current password unchanged.
                        </div>
                        <div class="form-row-2">
                            <div class="form-field" style="margin-bottom:0">
                                <label class="eu-label">New Password</label>
                                <input type="password" name="password" id="password"
                                       class="eu-input @error('password') is-invalid @enderror"
                                       placeholder="Leave blank to keep current">
                                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-field" style="margin-bottom:0">
                                <label class="eu-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="eu-input" placeholder="Repeat new password">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="eu-footer">
                    @can('users.update')
                    <button type="submit" class="btn-update">
                        <i class="fas fa-save"></i> Update User
                    </button>
                    @endcan
                    <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}?role={{ $roleName }}"
                       class="btn-cancel-link">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>

        </div>{{-- /grid --}}
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('profile_picture').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = ev => {
                document.getElementById('profilePreview').src = ev.target.result;
                document.getElementById('fileLabel').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
