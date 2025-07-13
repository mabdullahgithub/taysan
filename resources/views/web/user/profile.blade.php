@extends('web.layouts.main')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                             class="rounded-circle mb-3" width="120" height="120">
                    @else
                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3"
                             style="width: 120px; height: 120px; font-size: 36px; font-weight: bold;">
                            {{ $user->initials }}
                        </div>
                    @endif
                    
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('web.user.edit-profile') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('web.user.change-password') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-key me-2"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Menu -->
            <div class="card shadow mt-3">
                <div class="list-group list-group-flush">
                    <a href="{{ route('web.user.profile') }}" 
                       class="list-group-item list-group-item-action {{ request()->routeIs('web.user.profile') ? 'active' : '' }}">
                        <i class="fas fa-user me-2"></i>Profile
                    </a>
                    <a href="{{ route('web.user.orders') }}" 
                       class="list-group-item list-group-item-action {{ request()->routeIs('web.user.orders') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart me-2"></i>My Orders 
                        <span class="badge bg-primary rounded-pill">{{ $user->orders_count }}</span>
                    </a>
                    <a href="{{ route('web.user.reviews') }}" 
                       class="list-group-item list-group-item-action {{ request()->routeIs('web.user.reviews') ? 'active' : '' }}">
                        <i class="fas fa-star me-2"></i>My Reviews 
                        <span class="badge bg-info rounded-pill">{{ $user->reviews_count }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Personal Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Full Name:</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Phone:</td>
                                    <td>{{ $user->phone ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Date of Birth:</td>
                                    <td>{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Gender:</td>
                                    <td>{{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Address Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Address:</td>
                                    <td>{{ $user->address ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">City:</td>
                                    <td>{{ $user->city ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Postal Code:</td>
                                    <td>{{ $user->postal_code ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Country:</td>
                                    <td>{{ $user->country ?: 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <div class="display-6 text-primary">{{ $user->orders_count }}</div>
                            <h6 class="text-muted">Total Orders</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <div class="display-6 text-info">{{ $user->reviews_count }}</div>
                            <h6 class="text-muted">Reviews Written</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="card shadow mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Account Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Member Since:</strong> {{ $user->created_at->format('M Y') }}</p>
                            <p><strong>Account Status:</strong> 
                                <span class="badge bg-success">Active</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email Verified:</strong> 
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>Verified
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Not Verified
                                    </span>
                                @endif
                            </p>
                            <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card shadow mt-3 border-danger">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">Danger Zone</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Once you delete your account, there is no going back. Please be certain.
                    </p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash me-2"></i>Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('web.user.delete-account') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Warning!</strong> This action cannot be undone. All your data will be permanently deleted.
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Enter your password to confirm:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
