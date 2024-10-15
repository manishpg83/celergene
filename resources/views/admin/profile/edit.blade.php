@extends('layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold fs-4 py-3 mb-2">Edit Profile</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header fw-bold fs-6">Profile Details</h5>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ old('name', $admin->name) }}" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ old('email', $admin->email) }}" required />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">New Password</label>
                                    <input class="form-control" type="password" id="password" name="password" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input class="form-control" type="password" id="password_confirmation"
                                        name="password_confirmation" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="image" class="form-label">Profile Image</label>
                                    <input class="form-control" type="file" id="image" name="image"
                                        accept="image/*" />
                                </div>
                            </div>
                            @if ($admin->profile_image)
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Current Profile Image</label>
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ asset('storage/' . $admin->profile_image) }}" alt="Current Image"
                                            class="rounded" height="100" width="100" />
                                    </div>
                                </div>
                            @endif
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <a href="{{ route('admin.profile.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
