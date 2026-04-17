@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Edit Role: {{ $role->name }}</h3>

    <form action="{{ route(auth()->user()->getRoleNames()->first() .'.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mt-3">
            <label>Role Name</label>
            <input type="text" name="name" value="{{ $role->name }}" class="form-control" required>
        </div>

        <h5 class="mt-4">Permissions</h5>

        <label>
            <input type="checkbox" id="selectAll"> Select All
        </label>

        <div class="row mt-2">
            @foreach($permissions as $module => $perms)
                <div class="col-md-4 border p-2 mb-3">
                    <strong>{{ ucfirst($module) }}</strong>
                    <hr>
                    @foreach($perms as $perm)
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>
                            {{ $perm->name }}
                        </label><br>
                    @endforeach
                </div>
            @endforeach
        </div>

        @can('roles.update')
        <button class="btn btn-primary mt-3">Update</button>
        @endcan
    </form>
</div>

<script>
document.getElementById('selectAll').onclick = function() {
    let checks = document.querySelectorAll('input[type=checkbox][name="permissions[]"]');
    checks.forEach(c => c.checked = this.checked);
};
</script>
@endsection
