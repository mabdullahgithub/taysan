@extends('admin.layout.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Details: {{ $user->name }}</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Profile Card -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                             class="rounded-circle mb-3" width="150" height="150">
                    @else
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 150px; height: 150px; font-size: 48px; font-weight: bold;">
                            {{ $user->initials }}
                        </div>
                    @endif
                    
                    <h4 class="text-gray-800">{{ $user->name }}</h4>
                    <p class="text-gray-600 mb-3">{{ $user->email }}</p>
                    
                    <div class="row text-center">
                        <div class="col">
                            <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'secondary' }} badge-lg">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div class="col">
                            <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }} badge-lg">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    @if($user->id !== auth()->id())
                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-{{ $user->is_active ? 'danger' : 'success' }} toggle-status"
                                    data-user-id="{{ $user->id }}">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }} Account
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->orders_count }}</div>
                            <div class="text-xs text-gray-600 text-uppercase">Total Orders</div>
                        </div>
                        <div class="col-6 text-center">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->reviews_count }}</div>
                            <div class="text-xs text-gray-600 text-uppercase">Reviews Written</div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Member since {{ $user->created_at->format('M Y') }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Details -->
        <div class="col-xl-8 col-lg-7">
            <!-- Personal Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" width="40%">Full Name:</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Phone:</td>
                                    <td>{{ $user->phone ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Date of Birth:</td>
                                    <td>{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Gender:</td>
                                    <td>{{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" width="40%">Address:</td>
                                    <td>{{ $user->address ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">City:</td>
                                    <td>{{ $user->city ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Postal Code:</td>
                                    <td>{{ $user->postal_code ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Country:</td>
                                    <td>{{ $user->country ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Full Address:</td>
                                    <td>{{ $user->full_address ?: 'Not provided' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" width="40%">User ID:</td>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Role:</td>
                                    <td>
                                        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'secondary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Status:</td>
                                    <td>
                                        <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="font-weight-bold" width="40%">Email Verified:</td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check me-1"></i>Verified
                                            </span>
                                            <br>
                                            <small class="text-muted">{{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock me-1"></i>Not Verified
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Created:</td>
                                    <td>
                                        {{ $user->created_at->format('M d, Y H:i') }}
                                        <br>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Last Updated:</td>
                                    <td>
                                        {{ $user->updated_at->format('M d, Y H:i') }}
                                        <br>
                                        <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" 
                               class="btn btn-outline-primary btn-block">
                                <i class="fas fa-shopping-cart me-2"></i>View User Orders ({{ $user->orders_count }})
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.reviews.index', ['user_id' => $user->id]) }}" 
                               class="btn btn-outline-info btn-block">
                                <i class="fas fa-star me-2"></i>View User Reviews ({{ $user->reviews_count }})
                            </a>
                        </div>
                    </div>
                    
                    @if($user->id !== auth()->id())
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <button type="button" class="btn btn-outline-warning btn-block toggle-status"
                                        data-user-id="{{ $user->id }}">
                                    <i class="fas fa-power-off me-2"></i>
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }} Account
                                </button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-block">
                                        <i class="fas fa-trash me-2"></i>Delete User
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').click(function() {
        const userId = $(this).data('user-id');
        const button = $(this);
        
        $.ajax({
            url: `/admin/users/${userId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert(response.error || 'An error occurred');
            }
        });
    });

    // Delete confirmation
    $('.delete-form').submit(function(e) {
        if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
@endsection
