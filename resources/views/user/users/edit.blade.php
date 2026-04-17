@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}" class="btn btn-secondary"><i
                    class="fas fa-arrow-left"></i> Back</a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.users.update', $user) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Name -->
                            <div class="form-group mb-3">
                                <label for="name">Full Name *</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label for="email">Email *</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>



                            <!-- Phone -->
                            <div class="form-group mb-3">
                                <label for="phone">Phone </label>
                                <input type="tel" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="form-group mb-3">
                                <label for="gender">Gender </label>
                                <select name="gender" id="gender"
                                    class="form-control @error('gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                        Male
                                    </option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                        Female
                                    </option>
                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                        Other
                                    </option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Role -->
                            <!-- Locality -->
                            <div class="form-group mb-3">
                                <label for="locality">Locality</label>
                                <input type="text" name="locality" id="locality" class="form-control"
                                    value="{{ old('locality', $user->locality) }}" placeholder="Enter locality">
                            </div>

                        </div>

                        <!-- Profile Picture -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="profile_picture">Profile Picture</label>
                                <input type="file" name="profile_picture" id="profile_picture"
                                    class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*">
                                @error('profile_picture')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-3 text-center">
                                <img id="profilePreview"
                                    src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/200x200?text=Profile' }}"
                                    class="img-thumbnail" style="width:200px;height:200px;object-fit:cover;">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        @can('users.update')
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update User</button>
                        @endcan
                        <a href="{{ route(auth()->user()->getRoleNames()->first() . '.users.index') }}"
                            class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('profilePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
