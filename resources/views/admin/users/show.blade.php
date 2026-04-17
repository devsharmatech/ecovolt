@extends('admin.layouts.master')

<style>
/* ── Global ─────────────────────────────────────── */
.sv-wrap { padding: 24px; }

/* ── Page Header ────────────────────────────────── */
.sv-header {
    display:flex; align-items:center; justify-content:space-between;
    background:linear-gradient(135deg,#f0fdf4,#dcfce7);
    border:1px solid #bbf7d0; border-radius:16px;
    padding:20px 28px; margin-bottom:28px;
}
.sv-header h2 { font-size:1.45rem; font-weight:700; color:#1a1f36; margin:0; }
.sv-header p  { font-size:.82rem; color:#6b7280; margin:3px 0 0; }
.sv-back-btn {
    display:inline-flex; align-items:center; gap:7px;
    background:#fff; color:#374151; border:1.5px solid #d1d5db;
    border-radius:10px; padding:9px 18px; font-weight:600;
    font-size:.85rem; text-decoration:none; transition:.2s;
}
.sv-back-btn:hover { background:#f9fafb; border-color:#9ca3af; transform:translateY(-1px); color:#111; }

/* ── Layout ─────────────────────────────────────── */
.sv-grid { display:grid; grid-template-columns:300px 1fr; gap:24px; align-items:start; }

/* ── Profile Card ───────────────────────────────── */
.profile-card {
    background:#fff; border-radius:16px;
    box-shadow:0 2px 16px rgba(0,0,0,.07);
    overflow:hidden; text-align:center;
}
.profile-card-bg {
    background:linear-gradient(135deg,#2ecc71,#27ae60);
    height:80px; position:relative;
}
.profile-avatar-wrap {
    margin:-44px auto 0; position:relative;
    width:88px; z-index:1;
}
.profile-avatar {
    width:88px; height:88px; border-radius:50%;
    object-fit:cover; border:4px solid #fff;
    box-shadow:0 4px 14px rgba(0,0,0,.12);
}
.avatar-initials-lg {
    width:88px; height:88px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:2rem; font-weight:800; color:#fff;
    border:4px solid #fff; box-shadow:0 4px 14px rgba(0,0,0,.12);
}
.profile-card-body { padding:16px 20px 24px; }
.profile-card-body h4 { font-size:1.05rem; font-weight:700; color:#1a1f36; margin:10px 0 4px; }
.profile-card-body .email { font-size:.78rem; color:#6b7280; margin:0 0 16px; }
.profile-card-body .code-tag {
    display:inline-block;
    background:linear-gradient(135deg,#636363,#e2e2e2);
    color:#fff; font-size:.7rem; font-weight:700;
    padding:4px 14px; border-radius:20px; letter-spacing:.04em; margin-bottom:16px;
}
.profile-meta { border-top:1px solid #f0f2f7; padding-top:16px; text-align:left; }
.meta-row {
    display:flex; align-items:center; gap:10px;
    padding:8px 0; border-bottom:1px solid #f0f2f7; font-size:.83rem; color:#374151;
}
.meta-row:last-child { border-bottom:none; }
.meta-icon {
    width:30px; height:30px; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    background:#f0fdf4; color:#27ae60; font-size:.78rem; flex-shrink:0;
}
.meta-label { font-size:.7rem; color:#9ca3af; display:block; }
.meta-value { font-size:.82rem; font-weight:600; color:#1a1f36; }

/* ── Info Cards ─────────────────────────────────── */
.sv-card {
    background:#fff; border-radius:16px;
    box-shadow:0 2px 16px rgba(0,0,0,.07);
    overflow:hidden; margin-bottom:20px;
}
.sv-card-header {
    padding:14px 22px; border-bottom:1px solid #f0f2f7;
    display:flex; align-items:center; gap:10px;
}
.sv-card-header .hicon {
    width:34px; height:34px; border-radius:9px;
    background:linear-gradient(135deg,#2ecc71,#27ae60);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:.85rem;
}
.sv-card-header h6 { margin:0; font-weight:700; color:#1a1f36; font-size:.9rem; }
.sv-card-body { padding:20px 22px; }

/* ── Info Grid ──────────────────────────────────── */
.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.info-item {}
.info-item .il { font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#9ca3af; margin-bottom:4px; }
.info-item .iv { font-size:.88rem; font-weight:600; color:#1a1f36; }

/* ── Badges ─────────────────────────────────────── */
.pill-verified   { background:#d1fae5; color:#065f46; }
.pill-unverified { background:#fee2e2; color:#991b1b; }
.status-pill-d   { background:#d1fae5; color:#065f46; }
.pill {
    display:inline-block; border-radius:20px; padding:4px 12px;
    font-size:.72rem; font-weight:700;
}

/* ── Status Select ──────────────────────────────── */
.sv-status-select {
    border:1.5px solid #e5e7eb; border-radius:10px; padding:9px 14px;
    font-size:.875rem; color:#1f2937; outline:none; cursor:pointer;
    transition:.2s; width:100%;
}
.sv-status-select:focus { border-color:#27ae60; box-shadow:0 0 0 3px rgba(39,174,96,.1); }

/* ── Action Buttons ─────────────────────────────── */
.sv-actions { display:flex; gap:10px; flex-wrap:wrap; margin-top:16px; }
.sv-btn {
    display:inline-flex; align-items:center; gap:7px;
    border-radius:10px; padding:9px 18px;
    font-size:.85rem; font-weight:600; text-decoration:none;
    border:none; cursor:pointer; transition:.2s;
}
.sv-btn:hover { transform:translateY(-1px); }
.sv-btn-edit { background:linear-gradient(135deg,#8b5cf6,#7c3aed); color:#fff; box-shadow:0 4px 12px rgba(139,92,246,.3); }
.sv-btn-back { background:#f3f4f6; color:#374151; border:1.5px solid #d1d5db; }

@media(max-width:900px) { .sv-grid { grid-template-columns:1fr; } }
</style>

@section('content')
<div class="sv-wrap">

    {{-- ── HEADER ───────────────────────────────────────────── --}}
    <div class="sv-header">
        <div>
            <h2>
                <i class="fas fa-user-circle" style="color:#27ae60;margin-right:8px;"></i>
                User Details
            </h2>
            <p>Full profile and account information</p>
        </div>
        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}?role={{ $roleName }}"
           class="sv-back-btn">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="sv-grid">

        {{-- ── LEFT: PROFILE CARD ─────────────────────────────── --}}
        <div class="profile-card">
            <div class="profile-card-bg"></div>
            <div class="profile-avatar-wrap">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" class="profile-avatar" alt="{{ $user->name }}">
                @else
                    @php $colors = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899']; $c = $colors[crc32($user->name) % count($colors)]; @endphp
                    <div class="avatar-initials-lg" style="background:{{ $c }}">{{ strtoupper(substr($user->name,0,1)) }}</div>
                @endif
            </div>
            <div class="profile-card-body">
                <h4>{{ $user->name }}</h4>
                <p class="email">{{ $user->email }}</p>
                @if($user->user_code)
                    <div class="code-tag">{{ $user->user_code }}</div>
                @endif
                <div class="profile-meta">
                    @if($user->phone)
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <span class="meta-label">Phone</span>
                            <span class="meta-value">{{ $user->phone }}</span>
                        </div>
                    </div>
                    @endif
                    @if($user->gender)
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-venus-mars"></i></div>
                        <div>
                            <span class="meta-label">Gender</span>
                            <span class="meta-value">{{ ucfirst($user->gender) }}</span>
                        </div>
                    </div>
                    @endif
                    @if($user->locality)
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <span class="meta-label">Locality</span>
                            <span class="meta-value">{{ $user->locality }}</span>
                        </div>
                    </div>
                    @endif
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div>
                            <span class="meta-label">Registered</span>
                            <span class="meta-value">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="meta-row">
                        <div class="meta-icon"><i class="fas fa-user-tag"></i></div>
                        <div>
                            <span class="meta-label">Role</span>
                            <span class="meta-value">{{ ucfirst($roleName) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── RIGHT COLUMN ────────────────────────────────────── --}}
        <div>

            {{-- Account Status Card --}}
            <div class="sv-card">
                <div class="sv-card-header">
                    <div class="hicon"><i class="fas fa-shield-alt"></i></div>
                    <h6>Account Status</h6>
                </div>
                <div class="sv-card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="il">Email Verification</div>
                            @if($user->email_verified_at)
                                <span class="pill pill-verified">✓ Verified — {{ $user->email_verified_at->format('d M Y') }}</span>
                            @else
                                <span class="pill pill-unverified">✗ Not Verified</span>
                            @endif
                        </div>
                        <div class="info-item">
                            <div class="il">Account Status</div>
                            <span class="pill {{ $user->status == 'active' ? 'pill-verified' : 'pill-unverified' }}">
                                {{ $user->status == 'active' ? '● Active' : '● Inactive' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <div class="il">Last Login</div>
                            <div class="iv">
                                @if(isset($user->last_login) && $user->last_login)
                                    {{ $user->last_login->diffForHumans() }}
                                @else
                                    <span style="color:#9ca3af;">Never logged in</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="il">Member Since</div>
                            <div class="iv">{{ $user->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Business Info (Dealer only) --}}
            @if($user->business_name || $user->gst_number)
            <div class="sv-card">
                <div class="sv-card-header">
                    <div class="hicon" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8)"><i class="fas fa-building"></i></div>
                    <h6>Business Information</h6>
                </div>
                <div class="sv-card-body">
                    <div class="info-grid">
                        @if($user->business_name)
                        <div class="info-item">
                            <div class="il">Company Name</div>
                            <div class="iv">{{ $user->business_name }}</div>
                        </div>
                        @endif
                        @if($user->business_type)
                        <div class="info-item">
                            <div class="il">Business Type</div>
                            <div class="iv">{{ $user->business_type }}</div>
                        </div>
                        @endif
                        @if($user->gst_number)
                        <div class="info-item">
                            <div class="il">GST Number</div>
                            <div class="iv">{{ $user->gst_number }}</div>
                        </div>
                        @endif
                        @if($user->pan_number)
                        <div class="info-item">
                            <div class="il">PAN Number</div>
                            <div class="iv">{{ $user->pan_number }}</div>
                        </div>
                        @endif
                        @if($user->business_address)
                        <div class="info-item" style="grid-column:span 2">
                            <div class="il">Business Address</div>
                            <div class="iv">{{ $user->business_address }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Bank Account Info --}}
            @if($user->bank_name || $user->account_number)
            <div class="sv-card">
                <div class="sv-card-header">
                    <div class="hicon" style="background:linear-gradient(135deg,#10b981,#047857)"><i class="fas fa-university"></i></div>
                    <h6>Bank Account Details</h6>
                </div>
                <div class="sv-card-body border-start border-4 border-success">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="il">Bank Name</div>
                            <div class="iv">{{ $user->bank_name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="il">Account Holder</div>
                            <div class="iv">{{ $user->account_holder_name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="il">Account Number</div>
                            <div class="iv" style="letter-spacing: 1px;">{{ $user->account_number }}</div>
                        </div>
                        <div class="info-item">
                            <div class="il">IFSC Code</div>
                            <div class="iv">{{ $user->ifsc_code }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Dealer Insights Card --}}
            @if($roleName == 'dealer')
            @php
                $totalLeads = $user->leads()->count();
                $converted = $user->projects()->count();
                $lostLeads = $user->leads()->where('stage', 'Lost')->count();
                $totalAmt = $user->projects()->sum('total_amount');
                $outAmt = $totalAmt - $user->projects()->sum('part_payment_amount'); // basic proxy outstanding
                $conversionRate = $totalLeads > 0 ? round(($converted / $totalLeads) * 100) : 0;
            @endphp
            <div class="sv-card">
                <div class="sv-card-header" style="background: linear-gradient(135deg,#065f46,#166534); color:#fff; border-bottom:none;">
                    <div class="hicon" style="background:rgba(255,255,255,0.2);"><i class="fas fa-chart-pie" style="color:#fff;"></i></div>
                    <h6 style="color:#fff;">Dealer Business Insights</h6>
                </div>
                <div class="sv-card-body" style="background:#f8fafc;">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="il">Lead Conversion Rate</div>
                            <div class="iv" style="font-size:1.4rem; color:#16a34a;">{{ $conversionRate }}%</div>
                            <div style="width:100%; height:4px; background:#e2e8f0; border-radius:4px; margin-top:8px;">
                                <div style="width:{{ $conversionRate }}%; height:100%; background:#16a34a; border-radius:4px;"></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="il">Total Pipeline</div>
                            <div class="iv" style="margin-top: 6px;">
                                <span style="display:inline-block; margin-right:12px;"><b style="color:#2563eb; font-size:1.1rem;">{{ $totalLeads }}</b> Leads</span>
                                <span style="display:inline-block; margin-right:12px;"><b style="color:#16a34a; font-size:1.1rem;">{{ $converted }}</b> Projects</span>
                                <span style="display:inline-block;"><b style="color:#ef4444; font-size:1.1rem;">{{ $lostLeads }}</b> Cancelled</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="il">Total Generated Value</div>
                            <div class="iv" style="font-size:1.2rem; font-weight:900;">₹{{ number_format($totalAmt) }}</div>
                        </div>
                        <div class="info-item">
                            <div class="il">Est. Payment Outstanding</div>
                            <div class="iv" style="font-size:1.2rem; font-weight:900; color:#d97706;">₹{{ number_format($outAmt) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Change Status Card --}}
            <div class="sv-card">
                <div class="sv-card-header">
                    <div class="hicon" style="background:linear-gradient(135deg,#f59e0b,#d97706)"><i class="fas fa-toggle-on"></i></div>
                    <h6>Manage Account</h6>
                </div>
                <div class="sv-card-body">
                    <label style="font-size:.78rem;font-weight:600;color:#374151;margin-bottom:6px;display:block;">Change Status</label>
                    <select class="sv-status-select" id="status_change" data-user-id="{{ $user->id }}">
                        <option value="active"   {{ $user->status == 'active'   ? 'selected' : '' }}>● Active</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>● Inactive</option>
                    </select>

                    <div class="sv-actions">
                        @can('users.edit')
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.edit', $user) }}"
                           class="sv-btn sv-btn-edit">
                            <i class="fas fa-pen"></i> Edit User
                        </a>
                        @endcan
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}?role={{ $roleName }}"
                           class="sv-btn sv-btn-back">
                            <i class="fas fa-list"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>

        </div>{{-- /right --}}
    </div>{{-- /grid --}}
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('status_change').addEventListener('change', function () {
        var userId = this.dataset.userId;
        var status = this.value;
        var role   = '{{ auth()->user()->getRoleNames()->first() }}';
        fetch('/' + role + '/users/' + userId + '/status', {
            method: 'PATCH',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
            body: JSON.stringify({ status: status })
        })
        .then(r => r.json())
        .then(res => {
            Swal.fire({ toast:true, position:'top-end', icon:'success', title: res.message, showConfirmButton:false, timer:2500 });
        })
        .catch(() => {
            Swal.fire({ toast:true, position:'top-end', icon:'error', title:'Error updating status', showConfirmButton:false, timer:2500 });
        });
    });
</script>
@endpush
