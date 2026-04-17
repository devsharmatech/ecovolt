@extends('admin.layouts.master')

<style>
.role-show-wrap { padding: 32px; background: #fdfdfd; min-height: 100vh; }
.role-card { background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; }
.role-head { background: linear-gradient(135deg, #166534, #15803d); padding: 32px 40px; color: #fff; display: flex; align-items: center; justify-content: space-between; }

.back-btn { 
    background: rgba(255,255,255,0.2); color: #fff; text-decoration: none; padding: 10px 20px; 
    border-radius: 12px; font-weight: 700; font-size: .85rem; transition: .2s; border: 1px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; gap: 8px;
}
.back-btn:hover { background: #fff; color: #166534; }

.role-badge { background: #fff; color: #166534; padding: 8px 16px; border-radius: 12px; font-weight: 800; font-size: .9rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

.perm-title { font-size: .85rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 32px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; display: flex; align-items: center; gap: 10px; }

.module-card { background: #ffffff; border-radius: 20px; padding: 24px; border: 1px solid #f1f5f9; transition: .3s; height: 100%; border-left: 5px solid #2ecc71; }
.module-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.05); }
.module-name { font-size: .95rem; font-weight: 800; color: #1e293b; text-transform: capitalize; margin-bottom: 15px; display: block; }

.perm-pill { 
    display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; color: #166534; 
    padding: 6px 12px; border-radius: 8px; font-size: .78rem; font-weight: 700; border: 1.5px solid #dcfce7;
    margin: 4px;
}
</style>

@section('content')
<div class="role-show-wrap">
    <div class="role-card">
        <div class="role-head">
            <div>
                <h2 style="margin: 0; font-weight: 800; color:#fff"><i class="fas fa-shield-alt"></i> Security Role Profile</h2>
                <p style="margin: 5px 0 0; opacity: 0.85; font-size: .95rem;">Reviewing capabilities assigned to the role.</p>
            </div>
            <div style="display: flex; gap: 15px; align-items: center;">
                <span class="role-badge">{{ $role->name }}</span>
                <a href="{{ route(auth()->user()->getRoleNames()->first() . '.roles.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Roles
                </a>
            </div>
        </div>

        <div style="padding: 40px;">
            <div class="perm-title"><i class="fas fa-key"></i> Authorized Module Permissions</div>

            @if($rolePermissions->count() > 0)
                @php
                    $groupedPermissions = $rolePermissions->groupBy(function($p) {
                        return explode('.', $p->name)[0];
                    });
                @endphp

                <div class="row">
                    @foreach($groupedPermissions as $module => $perms)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="module-card">
                                <span class="module-name">{{ $module }} Control</span>
                                <div style="display: flex; flex-wrap: wrap;">
                                    @foreach($perms as $perm)
                                        <span class="perm-pill">
                                            <i class="fas fa-check-circle"></i> {{ explode('.', $perm->name)[1] ?? $perm->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 60px; color: #94a3b8; background: #f8fafc; border-radius: 20px;">
                    <i class="fas fa-lock" style="font-size: 3rem; margin-bottom: 16px;"></i>
                    <h4>No Permissions Assigned</h4>
                    <p>This role currently has no active access policies.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
