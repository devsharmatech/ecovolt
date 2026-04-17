@extends('admin.layouts.master')

@section('content')
    <div class="container mt-4">


        <div class="card-header text-white d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                Create New Role
            </h4>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.roles.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to Role
            </a>
        </div>
        <div class="card shadow mb-4 p-4">

            <form action="{{ route(auth()->user()->getRoleNames()->first() . '.roles.store') }}" method="POST">
                @csrf

                <div class="form-group mt-3">
                    <label>Role Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <h5 class="mt-4">Assign Permissions</h5>

                <label>
                    <input type="checkbox" id="selectAll"> Select All
                </label>

                <div class="row mt-2">
                    @foreach ($permissions as $module => $perms)
                        <div class="col-md-4 border p-2 mb-3">
                            <strong>{{ ucfirst($module) }}</strong>
                            <hr>
                            @foreach ($perms as $perm)
                                <label>
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}">
                                    {{ $perm->name }}
                                </label><br>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <button class="btn btn-primary mt-3">Create</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('selectAll').onclick = function() {
            let checks = document.querySelectorAll('input[type=checkbox][name="permissions[]"]');
            checks.forEach(c => c.checked = this.checked);
        };
    </script>
@endsection
