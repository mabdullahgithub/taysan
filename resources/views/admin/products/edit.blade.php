@extends('admin.layout.app')
@section('title', 'Edit Product')

@section('content')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        --warning: #ED8936;
        --danger: #F56565;
        --info: #4299E1;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .edit-container {
        background-color: var(--background);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        color: var(--white);
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
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
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        margin: 0;
    }

    .form-container {
        background: var(--white);
        border-radius: 16px;
        box-shadow: var(--shadow);
        overflow: hidden;
        margin: 0 auto;
    }

    .section-header {
        background: var(--primary-lightest);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-light);
        margin: 0 -2rem 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-section {
        padding: 0 2rem 2rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.95rem;
    }

    .required {
        color: var(--danger);
        font-size: 1rem;
    }

    /* Improved spacing between form elements */
    .form-row .form-group:last-child {
        margin-bottom: 0;
    }

    /* Better textarea styling */
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Small text styling */
    .text-muted {
        color: var(--text-light) !important;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-control {
        border: 2px solid var(--border-light);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: var(--white);
        width: 100%;
        box-sizing: border-box;
        line-height: 1.5;
        color: var(--text-dark);
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(245, 101, 101, 0.1);
    }

    .form-control:hover:not(:focus) {
        border-color: var(--primary-lighter);
    }

    /* Select dropdown styling */
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        cursor: pointer;
    }

    select.form-control:focus {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%238B7BA8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    }

    select.form-control option {
        padding: 0.75rem;
        background: var(--white);
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    /* Better touch targets for mobile */
    @media (max-width: 768px) {
        .form-control {
            min-height: 44px; /* iOS recommended touch target */
            font-size: 16px; /* Prevents zoom on iOS */
        }
        
        .btn-primary-custom,
        .btn-secondary-custom {
            min-height: 44px;
            touch-action: manipulation;
        }
        
        .remove-image {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        
        .tag-remove {
            width: 20px;
            height: 20px;
        }
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* Image Upload Styles */
    .current-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .current-image-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid var(--border-light);
        background: var(--background);
        transition: all 0.3s ease;
    }

    .current-image-item.removing {
        opacity: 0.5;
        transform: scale(0.95);
    }

    .current-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .current-image-item:hover .image-overlay {
        opacity: 1;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: var(--danger);
        color: var(--white);
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
        opacity: 0.9;
    }

    .remove-image:hover {
        opacity: 1;
        transform: scale(1.1);
        background: #e53e3e;
    }

    @media (max-width: 768px) {
        .remove-image {
            opacity: 1; /* Always visible on mobile */
            width: 28px;
            height: 28px;
            font-size: 0.8rem;
        }
    }

    .image-upload-area {
        border: 2px dashed var(--border-light);
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--background);
    }

    .image-upload-area:hover {
        border-color: var(--primary-color);
        background: var(--primary-lightest);
    }

    .upload-icon {
        font-size: 2.5rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    .upload-text {
        color: var(--text-medium);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        color: var(--text-light);
        font-size: 0.875rem;
    }

    /* Checkbox and Switch Styles */
    .checkbox-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border: 2px solid var(--border-light);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .custom-checkbox:hover {
        border-color: var(--primary-color);
        background: var(--primary-lightest);
    }

    .custom-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
    }

    .custom-checkbox input[type="checkbox"]:checked + .checkbox-content {
        color: var(--primary-color);
        font-weight: 600;
    }

    .checkbox-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-medium);
        transition: all 0.2s ease;
    }

    /* Tag Input */
    .tag-input-container {
        border: 2px solid var(--border-light);
        border-radius: 10px;
        padding: 0.5rem;
        min-height: 50px;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: flex-start;
        background: var(--white);
        cursor: text;
    }

    .tag-input-container:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    .tag-item {
        background: var(--primary-color);
        color: var(--white);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .tag-remove {
        background: none;
        border: none;
        color: var(--white);
        cursor: pointer;
        padding: 0;
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .tag-remove:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .tag-input {
        border: none;
        outline: none;
        flex: 1;
        min-width: 100px;
        padding: 0.25rem;
        font-size: 0.95rem;
    }

    /* Button Styles */
    .btn-primary-custom {
        background: var(--primary-color);
        border: 1px solid var(--primary-color);
        color: var(--white);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary-custom:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        color: var(--white);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-secondary-custom {
        background: var(--background);
        border: 1px solid var(--border-light);
        color: var(--text-medium);
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary-custom:hover {
        background: var(--border-light);
        color: var(--text-dark);
        text-decoration: none;
    }

    .form-actions {
        background: var(--background);
        margin: 2rem -2rem -2rem;
        padding: 1.5rem 2rem;
        border-radius: 0 0 16px 16px;
        border-top: 1px solid var(--border-light);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    /* Responsive */
    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }
        
        .form-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
        
        .form-section {
            padding: 0 3rem 2rem;
        }
        
        .section-header {
            margin: 0 -3rem 2rem;
            padding: 1.5rem 3rem;
        }
        
        .form-actions {
            margin: 2rem -3rem -2rem;
            padding: 1.5rem 3rem;
        }
    }
    
    @media (max-width: 1199px) and (min-width: 992px) {
        .container {
            max-width: 960px;
            padding: 0 1.5rem;
        }
        
        .form-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .form-section {
            padding: 0 2.5rem 2rem;
        }
        
        .section-header {
            margin: 0 -2.5rem 2rem;
            padding: 1.5rem 2.5rem;
        }
        
        .form-actions {
            margin: 2rem -2.5rem -2rem;
            padding: 1.5rem 2.5rem;
        }
        
        .current-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }
    }
    
    @media (max-width: 991px) and (min-width: 769px) {
        .container {
            max-width: 720px;
            padding: 0 1.25rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        
        .form-section {
            padding: 0 2rem 1.5rem;
        }
        
        .section-header {
            margin: 0 -2rem 1.5rem;
            padding: 1.25rem 2rem;
        }
        
        .form-actions {
            margin: 1.5rem -2rem -1.5rem;
            padding: 1.25rem 2rem;
        }
        
        .current-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }

    @media (max-width: 1024px) {
        .container {
            max-width: 100%;
            padding: 0 1rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        
        .current-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .edit-container {
            padding: 1rem 0;
        }
        
        .container {
            padding: 0 0.75rem;
        }
        
        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .page-subtitle {
            font-size: 0.9rem;
        }
        
        .form-container {
            border-radius: 12px;
        }
        
        .section-header {
            margin: 0 -1.5rem 1.5rem;
            padding: 1rem 1.5rem;
        }
        
        .section-title {
            font-size: 1.1rem;
        }
        
        .form-section {
            padding: 0 1.5rem 1.5rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .form-actions {
            flex-direction: column;
            margin: 1.5rem -1.5rem -1.5rem;
            padding: 1rem 1.5rem;
            gap: 0.75rem;
        }
        
        .checkbox-group {
            grid-template-columns: 1fr;
        }
        
        .current-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.75rem;
        }
        
        .image-upload-area {
            padding: 1.5rem 1rem;
        }
        
        .upload-icon {
            font-size: 2rem;
        }
        
        .tag-input-container {
            padding: 0.75rem;
        }
        
        .custom-checkbox {
            padding: 1rem;
        }
        
        .btn-primary-custom,
        .btn-secondary-custom {
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 480px) {
        .edit-container {
            padding: 0.5rem 0;
        }
        
        .container {
            padding: 0 0.5rem;
        }
        
        .page-header {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
        }
        
        .page-title {
            font-size: 1.25rem;
            flex-direction: column;
            gap: 0.25rem;
            text-align: center;
        }
        
        .page-subtitle {
            text-align: center;
            font-size: 0.85rem;
        }
        
        .form-container {
            border-radius: 10px;
        }
        
        .section-header {
            margin: 0 -1rem 1rem;
            padding: 0.75rem 1rem;
        }
        
        .section-title {
            font-size: 1rem;
        }
        
        .form-section {
            padding: 0 1rem 1rem;
        }
        
        .form-control {
            padding: 0.6rem 0.8rem;
            font-size: 0.9rem;
        }
        
        .form-actions {
            margin: 1rem -1rem -1rem;
            padding: 0.75rem 1rem;
        }
        
        .btn-primary-custom,
        .btn-secondary-custom {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
        
        .current-images-grid {
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 0.5rem;
        }
        
        .image-upload-area {
            padding: 1rem 0.75rem;
        }
        
        .upload-icon {
            font-size: 1.5rem;
        }
        
        .upload-text {
            font-size: 0.9rem;
        }
        
        .upload-hint {
            font-size: 0.8rem;
        }
    }
</style>

<div class="edit-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-edit"></i>
                Edit Product
            </h1>
            <p class="page-subtitle">Update product information, images, and details</p>
        </div>

        <!-- Display Errors -->
        @if ($errors->any())
            <div class="alert alert-danger" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
                <h5 style="margin: 0 0 0.5rem 0; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-exclamation-triangle"></i> 
                    Please fix the following errors:
                </h5>
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom: 0.25rem;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editProductForm">
            @csrf
            @method('PUT')
            
            <!-- Hidden input to track removed images -->
            <input type="hidden" name="removed_images" id="removedImagesInput" value="">
            
            <div class="form-container">
                <!-- Basic Information Section -->
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h2>
                </div>
                
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Product Name <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}" 
                                   required 
                                   placeholder="Enter product name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id" class="form-label">
                                Category <span class="required">*</span>
                            </label>
                            <select class="form-control @error('category_id') is-invalid @enderror" 
                                    id="category_id" 
                                    name="category_id" 
                                    required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" 
                                   class="form-control @error('sku') is-invalid @enderror" 
                                   id="sku" 
                                   name="sku" 
                                   value="{{ old('sku', $product->sku) }}" 
                                   placeholder="Product SKU (optional)">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="flag" class="form-label">Product Flag</label>
                            <select class="form-control @error('flag') is-invalid @enderror" 
                                    id="flag" 
                                    name="flag">
                                <option value="">No Flag</option>
                                <option value="New Arrivals" {{ old('flag', $product->flag) == 'New Arrivals' ? 'selected' : '' }}>New Arrivals</option>
                                <option value="Featured" {{ old('flag', $product->flag) == 'Featured' ? 'selected' : '' }}>Featured</option>
                                <option value="On Sale" {{ old('flag', $product->flag) == 'On Sale' ? 'selected' : '' }}>On Sale</option>
                                <option value="Best Seller" {{ old('flag', $product->flag) == 'Best Seller' ? 'selected' : '' }}>Best Seller</option>
                            </select>
                            @error('flag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">
                            Short Description <span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  required 
                                  placeholder="Brief product description for listings">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="detailed_description" class="form-label">
                            Detailed Description
                        </label>
                        <textarea class="form-control @error('detailed_description') is-invalid @enderror" 
                                  id="detailed_description" 
                                  name="detailed_description" 
                                  rows="6" 
                                  placeholder="Comprehensive product description with all details">{{ old('detailed_description', $product->detailed_description) }}</textarea>
                        @error('detailed_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Inventory Section -->
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-dollar-sign"></i>
                        Pricing & Inventory
                    </h2>
                </div>
                
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="price" class="form-label">
                                Price (PKR) <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   id="price" 
                                   name="price" 
                                   step="0.01" 
                                   min="0" 
                                   value="{{ old('price', number_format((float)$product->price, 2, '.', '')) }}" 
                                   required 
                                   placeholder="0.00">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock" class="form-label">
                                Stock Quantity <span class="required">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   min="0" 
                                   value="{{ old('stock', $product->stock) }}" 
                                   required 
                                   placeholder="0">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="weight" class="form-label">Weight (grams)</label>
                            <input type="number" 
                                   class="form-control @error('weight') is-invalid @enderror" 
                                   id="weight" 
                                   name="weight" 
                                   step="0.1" 
                                   min="0" 
                                   value="{{ old('weight', $product->weight) }}" 
                                   placeholder="Product weight in grams">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="dimensions" class="form-label">Dimensions</label>
                            <input type="text" 
                                   class="form-control @error('dimensions') is-invalid @enderror" 
                                   id="dimensions" 
                                   name="dimensions" 
                                   value="{{ old('dimensions', $product->dimensions) }}" 
                                   placeholder="e.g., 10cm x 5cm x 3cm">
                            @error('dimensions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="origin_country" class="form-label">Origin Country</label>
                        <input type="text" 
                               class="form-control @error('origin_country') is-invalid @enderror" 
                               id="origin_country" 
                               name="origin_country" 
                               value="{{ old('origin_country', $product->origin_country) }}" 
                               placeholder="Country of origin">
                        @error('origin_country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Product Images Section -->
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-images"></i>
                        Product Images
                    </h2>
                </div>
                
                <div class="form-section">
                    <!-- Current Images -->
                    @if($product->hasMultipleImages())
                        <div class="form-group">
                            <label class="form-label">Current Images</label>
                            <div class="current-images-grid" id="currentImagesGrid">
                                @foreach($product->all_images as $index => $image)
                                    <div class="current-image-item" data-index="{{ $index }}">
                                        <img src="{{ $image }}" alt="Product image {{ $index + 1 }}" class="current-image">
                                        <div class="image-overlay">
                                            <i class="fas fa-eye text-white"></i>
                                        </div>
                                        <button type="button" class="remove-image" onclick="removeCurrentImage({{ $index }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif($product->image)
                        <div class="form-group">
                            <label class="form-label">Current Image</label>
                            <div class="current-images-grid" id="currentImagesGrid">
                                <div class="current-image-item" data-index="0">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product image" class="current-image">
                                    <div class="image-overlay">
                                        <i class="fas fa-eye text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Image Upload -->
                    <div class="form-group">
                        <label for="images" class="form-label">
                            {{ $product->hasImages() ? 'Add More Images' : 'Product Images' }}
                        </label>
                        <div class="image-upload-area" onclick="document.getElementById('images').click()">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">
                                Click to upload or drag and drop
                            </div>
                            <div class="upload-hint">PNG, JPG, JPEG up to 2MB each. You can select multiple files.</div>
                            <input type="file" 
                                   class="form-control @error('images') is-invalid @enderror" 
                                   id="images" 
                                   name="images[]" 
                                   accept="image/*" 
                                   multiple
                                   style="display: none;">
                        </div>
                        
                        <!-- New Images Preview -->
                        <div id="newImagesPreview" class="current-images-grid" style="margin-top: 1rem; display: none;"></div>
                        
                        @error('images')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-list-alt"></i>
                        Product Details
                    </h2>
                </div>
                
                <div class="form-section">
                    <div class="form-group">
                        <label for="ingredients" class="form-label">Ingredients</label>
                        <textarea class="form-control @error('ingredients') is-invalid @enderror" 
                                  id="ingredients" 
                                  name="ingredients" 
                                  rows="4" 
                                  placeholder="List all ingredients used in this product">{{ old('ingredients', $product->ingredients) }}</textarea>
                        @error('ingredients')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="benefits" class="form-label">Benefits</label>
                        <textarea class="form-control @error('benefits') is-invalid @enderror" 
                                  id="benefits" 
                                  name="benefits" 
                                  rows="4" 
                                  placeholder="Describe the key benefits and advantages of this product">{{ old('benefits', $product->benefits) }}</textarea>
                        @error('benefits')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="usage_instructions" class="form-label">Usage Instructions</label>
                        <textarea class="form-control @error('usage_instructions') is-invalid @enderror" 
                                  id="usage_instructions" 
                                  name="usage_instructions" 
                                  rows="4" 
                                  placeholder="Provide clear instructions on how to use this product">{{ old('usage_instructions', $product->usage_instructions) }}</textarea>
                        @error('usage_instructions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Product Attributes Section -->
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-tags"></i>
                        Product Attributes
                    </h2>
                </div>
                
                <div class="form-section">
                    <!-- Product Certifications -->
                    <div class="form-group">
                        <label class="form-label">Product Certifications</label>
                        <div class="checkbox-group">
                            <label class="custom-checkbox">
                                <input type="hidden" name="is_organic" value="0">
                                <input type="checkbox" 
                                       name="is_organic" 
                                       value="1" 
                                       {{ old('is_organic', $product->is_organic) ? 'checked' : '' }}>
                                <div class="checkbox-content">
                                    <i class="fas fa-leaf text-success"></i>
                                    Organic Certified
                                </div>
                            </label>

                            <label class="custom-checkbox">
                                <input type="hidden" name="is_vegan" value="0">
                                <input type="checkbox" 
                                       name="is_vegan" 
                                       value="1" 
                                       {{ old('is_vegan', $product->is_vegan) ? 'checked' : '' }}>
                                <div class="checkbox-content">
                                    <i class="fas fa-seedling text-success"></i>
                                    Vegan Friendly
                                </div>
                            </label>

                            <label class="custom-checkbox">
                                <input type="hidden" name="is_cruelty_free" value="0">
                                <input type="checkbox" 
                                       name="is_cruelty_free" 
                                       value="1" 
                                       {{ old('is_cruelty_free', $product->is_cruelty_free) ? 'checked' : '' }}>
                                <div class="checkbox-content">
                                    <i class="fas fa-heart text-danger"></i>
                                    Cruelty Free
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Product Tags -->
                    <div class="form-group">
                        <label for="tags" class="form-label">Product Tags</label>
                        <div class="tag-input-container" id="tagContainer">
                            @if($product->tags)
                                @foreach($product->tags as $tag)
                                    <span class="tag-item">
                                        {{ $tag }}
                                        <button type="button" class="tag-remove" onclick="removeTag(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </span>
                                @endforeach
                            @endif
                            <input type="text" 
                                   class="tag-input" 
                                   id="tagInput" 
                                   placeholder="Type a tag and press Enter..."
                                   onkeydown="handleTagInput(event)">
                        </div>
                        <input type="hidden" name="tags" id="tagsHidden" value="{{ json_encode(old('tags', $product->tags ?? [])) }}">
                        <small class="text-muted">Press Enter to add tags. Tags help customers find your product more easily.</small>
                        @error('tags')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Product Status Section -->
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-toggle-on"></i>
                        Product Status
                    </h2>
                </div>
                
                <div class="form-section">
                    <div class="form-group">
                        <label for="status" class="form-label">Availability Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>
                                Active (Visible to customers)
                            </option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive (Hidden from customers)
                            </option>
                        </select>
                        <small class="text-muted">Only active products will be visible in your store</small>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary-custom">
                        <i class="fas fa-arrow-left"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-save"></i>
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Track removed images
    let removedImages = [];
    
    // Image preview and handling
    document.getElementById('images').addEventListener('change', function(e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('newImagesPreview');
        
        if (files.length > 0) {
            previewContainer.style.display = 'grid';
            previewContainer.innerHTML = '';
            
            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'current-image-item';
                        previewItem.innerHTML = `
                            <img src="${e.target.result}" alt="New image ${index + 1}" class="current-image">
                            <div class="image-overlay">
                                <i class="fas fa-eye text-white"></i>
                            </div>
                        `;
                        previewContainer.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            previewContainer.style.display = 'none';
        }
    });

    // Tag input handling
    let tags = JSON.parse(document.getElementById('tagsHidden').value || '[]');

    function updateTagsDisplay() {
        const container = document.getElementById('tagContainer');
        const input = document.getElementById('tagInput');
        
        // Clear existing tags
        const existingTags = container.querySelectorAll('.tag-item');
        existingTags.forEach(tag => tag.remove());
        
        // Add current tags
        tags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'tag-item';
            tagElement.innerHTML = `
                ${tag}
                <button type="button" class="tag-remove" onclick="removeTag(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.insertBefore(tagElement, input);
        });
        
        // Update hidden input
        document.getElementById('tagsHidden').value = JSON.stringify(tags);
    }

    function handleTagInput(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const input = event.target;
            const value = input.value.trim();
            
            if (value && !tags.includes(value)) {
                tags.push(value);
                input.value = '';
                updateTagsDisplay();
            }
        }
    }

    function removeTag(button) {
        const tagItem = button.closest('.tag-item');
        const tagText = tagItem.textContent.trim();
        tags = tags.filter(tag => tag !== tagText);
        updateTagsDisplay();
    }

    // Image removal functionality
    function removeCurrentImage(index) {
        if (confirm('Are you sure you want to remove this image?')) {
            const imageItem = document.querySelector(`[data-index="${index}"]`);
            if (imageItem) {
                // Add removing class for animation
                imageItem.classList.add('removing');
                
                // Add removed indicator
                const removedBadge = document.createElement('div');
                removedBadge.style.position = 'absolute';
                removedBadge.style.top = '50%';
                removedBadge.style.left = '50%';
                removedBadge.style.transform = 'translate(-50%, -50%)';
                removedBadge.style.background = 'rgba(245, 101, 101, 0.95)';
                removedBadge.style.color = 'white';
                removedBadge.style.padding = '0.5rem 0.75rem';
                removedBadge.style.borderRadius = '6px';
                removedBadge.style.fontSize = '0.8rem';
                removedBadge.style.fontWeight = 'bold';
                removedBadge.style.textAlign = 'center';
                removedBadge.innerHTML = 'REMOVED<br><small>Will be deleted on save</small>';
                removedBadge.style.zIndex = '100';
                removedBadge.style.boxShadow = '0 2px 8px rgba(0,0,0,0.3)';
                imageItem.appendChild(removedBadge);
                
                // Hide the remove button
                const removeButton = imageItem.querySelector('.remove-image');
                if (removeButton) {
                    removeButton.style.display = 'none';
                }
                
                // Add to removed images array
                if (!removedImages.includes(index)) {
                    removedImages.push(index);
                    updateRemovedImagesInput();
                }
            }
        }
    }

    function updateRemovedImagesInput() {
        document.getElementById('removedImagesInput').value = removedImages.join(',');
    }

    // Drag and drop for image upload
    const uploadArea = document.querySelector('.image-upload-area');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--primary-color)';
        this.style.background = 'var(--primary-lightest)';
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--border-light)';
        this.style.background = 'var(--background)';
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--border-light)';
        this.style.background = 'var(--background)';
        
        const files = e.dataTransfer.files;
        const fileInput = document.getElementById('images');
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    });

    // Price field formatting
    document.getElementById('price').addEventListener('input', function(e) {
        const value = parseFloat(e.target.value);
        if (!isNaN(value)) {
            e.target.value = value.toFixed(2);
        }
    });

    // Character count for textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        if (maxLength) {
            const counter = document.createElement('small');
            counter.className = 'text-muted';
            counter.style.display = 'block';
            counter.style.textAlign = 'right';
            counter.style.marginTop = '0.25rem';
            
            const updateCounter = () => {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = `${remaining} characters remaining`;
                counter.style.color = remaining < 50 ? 'var(--danger)' : 'var(--text-light)';
            };
            
            textarea.addEventListener('input', updateCounter);
            textarea.parentNode.appendChild(counter);
            updateCounter();
        }
    });

    // Form submission validation
    document.getElementById('editProductForm').addEventListener('submit', function(e) {
        const priceField = document.getElementById('price');
        const priceValue = parseFloat(priceField.value);
        
        if (isNaN(priceValue) || priceValue < 0) {
            e.preventDefault();
            alert('Please enter a valid price (must be a positive number).');
            priceField.focus();
            return false;
        }
        
        // Format price to 2 decimal places before submission
        priceField.value = priceValue.toFixed(2);
    });

    // Auto-save draft functionality (optional)
    let autoSaveTimeout;
    const formInputs = document.querySelectorAll('input, textarea, select');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Could implement auto-save to localStorage here
                console.log('Auto-saving draft...');
            }, 2000);
        });
    });
</script>

@endsection