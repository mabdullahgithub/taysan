@extends('admin.layout.app')
@section('title', 'Banner Settings')

@section('content')

<style>
    :root {
        --primary-color: #8B7BA8;
        --primary-light: #A893C4;
        --primary-lighter: #C4B5D8;
        --primary-lightest: #E9E3F0;
        --primary-dark: #6B5B7D;
        --background: #F8F9FA;
        --white: #FFFFFF;
        --text-dark: #2D3748;
        --text-medium: #4A5568;
        --text-light: #718096;
        --border-light: #E2E8F0;
        --success: #48BB78;
        --danger: #F56565;
        --info: #4299E1;
    }

    .settings-container {
        background-color: var(--background);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        opacity: 0.85;
        font-size: 1rem;
        margin: 0;
    }

    .btn-add-banner {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: var(--white);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-banner:hover {
        background: rgba(255, 255, 255, 0.3);
        color: var(--white);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .breadcrumb-custom {
        background: var(--white);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-light);
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .settings-section {
        background: var(--white);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px rgba(139, 123, 168, 0.08);
        margin-bottom: 2rem;
    }

    .section-title {
        color: var(--text-dark);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--primary-lightest);
    }

    .banner-image {
        width: 80px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-light);
    }

    .banner-title {
        font-weight: 600;
        color: var(--text-dark);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-active {
        background: rgba(72, 187, 120, 0.1);
        color: var(--success);
    }

    .status-inactive {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
        align-items: center;
    }

    .action-btn {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid;
    }

    .btn-edit {
        background: rgba(139, 123, 168, 0.1);
        color: var(--primary-color);
        border-color: var(--primary-lighter);
    }

    .btn-edit:hover {
        background: var(--primary-color);
        color: var(--white);
        text-decoration: none;
    }

    .btn-delete {
        background: rgba(245, 101, 101, 0.1);
        color: var(--danger);
        border-color: rgba(245, 101, 101, 0.3);
    }

    .btn-delete:hover {
        background: var(--danger);
        color: var(--white);
    }

    .table thead th {
        background: var(--primary-lightest);
        color: var(--text-dark);
        border: none;
        padding: 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table tbody td {
        padding: 1rem;
        border-color: var(--border-light);
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: rgba(139, 123, 168, 0.02);
    }

    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 40px rgba(139, 123, 168, 0.15);
    }

    .modal-header {
        background: var(--primary-lightest);
        border-bottom: 1px solid var(--border-light);
        border-radius: 16px 16px 0 0;
    }

    .modal-title {
        color: var(--text-dark);
        font-weight: 600;
    }

    .form-control {
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 0.75rem;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(139, 123, 168, 0.1);
    }

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .btn-secondary {
        background: #6c757d;
        border-color: #6c757d;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
    }
</style>

<div class="settings-container">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">
                        <i class="fas fa-cog"></i>
                        Banner Settings
                    </h1>
                    <p class="page-subtitle">Manage home and shop banner configurations</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <button type="button" class="btn-add-banner" data-toggle="modal" data-target="#addBannerModal">
                        <i class="fas fa-plus"></i>
                        Add New Banner
                    </button>
                </div>
            </div>
        </div>

        <!-- Home Banners Section -->
        <div class="settings-section">
            <h4 class="section-title">Home Banners</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($homeBanners as $banner)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $banner->image) }}" 
                                     alt="{{ $banner->title }}" 
                                     class="banner-image">
                            </td>
                            <td>
                                <div class="banner-title">{{ $banner->title }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $banner->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $banner->sort_order }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-edit edit-banner" 
                                            data-banner="{{ $banner }}"
                                            data-toggle="modal" 
                                            data-target="#editBannerModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn btn-delete" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shop Banners Section -->
        <div class="settings-section">
            <h4 class="section-title">Shop Banners</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shopBanners as $banner)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $banner->image) }}" 
                                     alt="{{ $banner->title }}" 
                                     class="banner-image">
                            </td>
                            <td>
                                <div class="banner-title">{{ $banner->title }}</div>
                            </td>
                            <td>
                                <span class="status-badge {{ $banner->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $banner->sort_order }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-edit edit-banner" 
                                            data-banner="{{ $banner }}"
                                            data-toggle="modal" 
                                            data-target="#editBannerModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn btn-delete" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Banner Modal -->
<div class="modal fade" id="addBannerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Banner</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Banner Type</label>
                        <select name="type" class="form-control" required>
                            <option value="home">Home Banner</option>
                            <option value="shop">Shop Banner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="button_text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Button Link</label>
                        <input type="text" name="button_link" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Banner Modal -->
<div class="modal fade" id="editBannerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editBannerForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Banner</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Banner Type</label>
                        <select name="type" class="form-control" required>
                            <option value="home">Home Banner</option>
                            <option value="shop">Shop Banner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Button Text</label>
                        <input type="text" name="button_text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Button Link</label>
                        <input type="text" name="button_link" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle edit banner button click
        $('.edit-banner').click(function() {
            const banner = $(this).data('banner');
            const form = $('#editBannerForm');
            
            // Set form action URL
            form.attr('action', `/admin/banners/${banner.id}`);
            
            // Populate form fields
            form.find('select[name="type"]').val(banner.type);
            form.find('input[name="title"]').val(banner.title);
            form.find('input[name="subtitle"]').val(banner.subtitle);
            form.find('input[name="button_text"]').val(banner.button_text);
            form.find('input[name="button_link"]').val(banner.button_link);
            form.find('input[name="sort_order"]').val(banner.sort_order);
            form.find('select[name="is_active"]').val(banner.is_active ? '1' : '0');
        });
    });
</script>
@endpush

@endsection