@extends('admin.layouts.master')

@section('content')
<div class="container mt-4">
    <h3>Permission Details</h3>

    <p><strong>Name:</strong> {{ $permission->name }}</p>
    <p><strong>Guard:</strong> {{ $permission->guard_name }}</p>

    <a href="{{ route(auth()->user()->getRoleNames()->first() .'.permissions.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
