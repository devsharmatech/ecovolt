@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Role Details</h3>

    <p><strong>Name:</strong> {{ $role->name }}</p>

    <h5>Permissions</h5>
    @foreach($rolePermissions as $perm)
        <span class="badge bg-info text-white">{{ $perm->name }}</span>
    @endforeach

    <br><br>
    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.roles.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
