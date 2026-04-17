@extends('admin.layouts.master')

<style>
.role-edit-wrap { padding: 32px; background: #fdfdfd; min-height: 100vh; }
.role-card { background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; }
.role-head { background: linear-gradient(135deg, #166534, #15803d); padding: 28px 40px; color: #fff; display: flex; align-items: center; justify-content: space-between; }

.back-btn { 
    background: rgba(255,255,255,0.2); color: #fff; text-decoration: none; padding: 10px 20px; 
    border-radius: 12px; font-weight: 700; font-size: .85rem; transition: .2s; border: 1px solid rgba(255,255,255,0.3);
    display: flex; align-items: center; gap: 8px;
}
.back-btn:hover { background: #fff; color: #166534; }

.form-label { font-size: .85rem; font-weight: 800; color: #64748b; margin-bottom: 12px; display: block; }
.role-input { 
    width: 100%; padding: 16px 20px; border-radius: 16px; border: 1.5px solid #e2e8f0; 
    font-size: 1rem; font-weight: 700; color: #1e293b; outline: none; transition: .2s;
}
.role-input:focus { border-color: #27ae60; box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.1); }

/* Permission Cards */
.module-card { background: #f8fafc; border-radius: 18px; padding: 20px; border: 1px solid #f1f5f9; height: 100%; transition: .2s; }
.module-card:hover { border-color: #27ae60; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
.module-title { font-size: .95rem; font-weight: 800; color: #166534; text-transform: capitalize; margin-bottom: 15px; display: block; border-left: 4px solid #2ecc71; padding-left: 12px; }

.perm-label { display: flex; align-items: center; gap: 10px; font-size: .88rem; font-weight: 600; color: #475569; padding: 6px 0; cursor: pointer; transition: .15s; }
.perm-label:hover { color: #166534; }

.check-green { width: 18px; height: 18px; accent-color: #166534; }

.update-btn { 
    background: #166534; color: #fff; border: none; padding: 16px 48px; border-radius: 16px; 
    font-weight: 800; font-size: 1.1rem; cursor: pointer; box-shadow: 0 10px 20px rgba(22, 101, 52, 0.2); 
}
</style>

@section('content')
<div class="role-edit-wrap">
    <div class="role-card">
        <div class="role-head">
            <div>
                <h2 style="margin: 0; font-weight: 800; color:#fff">Edit Security Role</h2>
                <p style="margin: 5px 0 0; opacity: 0.85; font-size: .9rem;">Configuring access for [{{ $role->name }}]</p>
            </div>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.roles.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Roles
            </a>
        </div>

        <div style="padding: 40px;">
            <form action="{{ route(auth()->user()->getRoleNames()->first() . '.roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="max-width: 500px; margin-bottom: 48px;">
                    <label class="form-label">Defined Role Name</label>
                    <input type="text" name="name" value="{{ $role->name }}" class="role-input" required placeholder="e.g. Sales Manager">
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">
                    <h5 style="margin: 0; font-weight: 800; color: #1e293b;">Assign Module Permissions</h5>
                    <label class="perm-label" style="font-weight: 800; color: #166534;">
                        <input type="checkbox" id="selectAll" class="check-green"> Select All Privileges
                    </label>
                </div>

                <div class="row">
                    @foreach($permissions as $module => $perms)
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="module-card">
                                <span class="module-title">{{ $module }}</span>
                                @foreach($perms as $perm)
                                    <label class="perm-label">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="check-green"
                                               {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>
                                        {{ str_replace($module.'.', '', $perm->name) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 48px; text-align: right;">
                    @can('roles.update')
                        <button type="submit" class="update-btn">Update Security Policies</button>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('selectAll').onclick = function() {
    let checks = document.querySelectorAll('input[type=checkbox][name="permissions[]"]');
    checks.forEach(c => c.checked = this.checked);
};
</script>
@endsection
