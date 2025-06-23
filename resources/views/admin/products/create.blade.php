@extends('admin.layout.app')
@section('title', 'Add New Product')

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
    }

    .create-container {
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

    .breadcrumb-custom .breadcrumb-item.active {
        color: var(--text-medium);
    }

    .form-container {
        background: var(--white);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(139, 123, 168, 0.08);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-medium);
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid var(--border-light);
        border-radius: 8px;
        padding: 0.75rem;
        transition: border-color 0.2s ease;
        font-size: 0.9rem;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(139, 123, 168, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
    }

    .invalid-feedback {
        color: var(--danger);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

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

    .image-upload-area {
        border: 2px dashed var(--border-light);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.2s ease;
        background: var(--background);
        cursor: pointer;
        position: relative;
    }

    .image-upload-area:hover {
        border-color: var(--primary-color);
        background: var(--primary-lightest);
    }

    .image-upload-area.dragover {
        border-color: var(--primary-color);
        background: var(--primary-lightest);
    }

    .additional-images-upload-area {
        border: 2px dashed var(--border-light);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.2s ease;
        background: var(--background);
        cursor: pointer;
        position: relative;
    }

    .additional-images-upload-area:hover {
        border-color: var(--primary-color);
        background: var(--primary-lightest);
    }

    .upload-icon {
        font-size: 3rem;
        color: var(--text-light);
        margin-bottom: 1rem;
    }

    .upload-text {
        color: var(--text-medium);
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .image-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 1px solid var(--border-light);
        margin: 1rem auto;
        display: none;
    }

    .additional-images-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 1rem;
        justify-content: center;
    }

    .additional-image-preview {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 8px;
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .additional-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .additional-image-preview .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: var(--danger);
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.7rem;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-check-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-custom {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: rgba(245, 101, 101, 0.1);
        color: var(--danger);
        border-left: 4px solid var(--danger);
    }

    .form-actions {
        background: var(--background);
        margin: 2rem -2rem -2rem;
        padding: 1.5rem 2rem;
        border-radius: 0 0 16px 16px;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .create-container {
            padding: 1rem 0;
        }
        
        .page-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .page-title {
            font-size: 1.5rem;
            justify-content: center;
        }
        
        .form-container {
            padding: 1.5rem;
        }

        .form-actions {
            margin: 2rem -1.5rem -1.5rem;
            padding: 1rem 1.5rem;
            flex-direction: column;
        }
    }
</style>

<div class="create-container">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Product</li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="page-title">
                        <i class="fas fa-plus-circle"></i>
                        Add New Product
                    </h1>
                    <p class="page-subtitle">Create a new product for your inventory</p>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-custom">
                <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create Form -->
        <div class="form-container">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="createProductForm">
                @csrf
                
                <div class="row">
                    <!-- Product Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               placeholder="Enter product name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control @error('category_id') is-invalid @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3" 
                              required 
                              placeholder="Enter short product description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Detailed Description -->
                <div class="mb-3">
                    <label for="detailed_description" class="form-label">Detailed Description</label>
                    <textarea class="form-control @error('detailed_description') is-invalid @enderror" 
                              id="detailed_description" 
                              name="detailed_description" 
                              rows="5" 
                              placeholder="Enter detailed product description (optional)">{{ old('detailed_description') }}</textarea>
                    @error('detailed_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Price -->
                    <div class="col-md-4 mb-3">
                        <label for="price" class="form-label">Price (PKR) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               id="price" 
                               name="price" 
                               step="1" 
                               min="0" 
                               value="{{ old('price') }}" 
                               required 
                               placeholder="0">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-4 mb-3">
                        <label for="stock" class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('stock') is-invalid @enderror" 
                               id="stock" 
                               name="stock" 
                               min="0" 
                               value="{{ old('stock') }}" 
                               required 
                               placeholder="0">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div class="col-md-4 mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" 
                               class="form-control @error('sku') is-invalid @enderror" 
                               id="sku" 
                               name="sku" 
                               value="{{ old('sku') }}" 
                               placeholder="Product SKU (optional)">
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Weight -->
                    <div class="col-md-6 mb-3">
                        <label for="weight" class="form-label">Weight (grams)</label>
                        <input type="number" 
                               class="form-control @error('weight') is-invalid @enderror" 
                               id="weight" 
                               name="weight" 
                               step="0.01" 
                               min="0" 
                               value="{{ old('weight') }}" 
                               placeholder="0.00">
                        @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dimensions -->
                    <div class="col-md-6 mb-3">
                        <label for="dimensions" class="form-label">Dimensions</label>
                        <input type="text" 
                               class="form-control @error('dimensions') is-invalid @enderror" 
                               id="dimensions" 
                               name="dimensions" 
                               value="{{ old('dimensions') }}" 
                               placeholder="L x W x H (e.g., 10 x 5 x 3 cm)">
                        @error('dimensions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Origin Country -->
                <div class="mb-3">
                    <label for="origin_country" class="form-label">Origin Country</label>
                    <input type="text" 
                           class="form-control @error('origin_country') is-invalid @enderror" 
                           id="origin_country" 
                           name="origin_country" 
                           value="{{ old('origin_country') }}" 
                           placeholder="Country of origin (optional)">
                    @error('origin_country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ingredients -->
                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ingredients</label>
                    <textarea class="form-control @error('ingredients') is-invalid @enderror" 
                              id="ingredients" 
                              name="ingredients" 
                              rows="4" 
                              placeholder="List all ingredients (optional)">{{ old('ingredients') }}</textarea>
                    @error('ingredients')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Benefits -->
                <div class="mb-3">
                    <label for="benefits" class="form-label">Benefits</label>
                    <textarea class="form-control @error('benefits') is-invalid @enderror" 
                              id="benefits" 
                              name="benefits" 
                              rows="4" 
                              placeholder="List product benefits (optional)">{{ old('benefits') }}</textarea>
                    @error('benefits')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Usage Instructions -->
                <div class="mb-3">
                    <label for="usage_instructions" class="form-label">Usage Instructions</label>
                    <textarea class="form-control @error('usage_instructions') is-invalid @enderror" 
                              id="usage_instructions" 
                              name="usage_instructions" 
                              rows="4" 
                              placeholder="How to use this product (optional)">{{ old('usage_instructions') }}</textarea>
                    @error('usage_instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tags -->
                <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <input type="text" 
                           class="form-control @error('tags') is-invalid @enderror" 
                           id="tags" 
                           name="tags" 
                           value="{{ old('tags') }}" 
                           placeholder="Enter tags separated by commas (e.g., natural, handmade, soap)">
                    <small class="text-muted">Enter tags separated by commas for better product categorization</small>
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Product Certifications -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Product Certifications</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_organic" name="is_organic" value="1" {{ old('is_organic') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_organic">
                                        <i class="fas fa-leaf text-success"></i> Organic
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_vegan" name="is_vegan" value="1" {{ old('is_vegan') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_vegan">
                                        <i class="fas fa-seedling text-success"></i> Vegan
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_cruelty_free" name="is_cruelty_free" value="1" {{ old('is_cruelty_free') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_cruelty_free">
                                        <i class="fas fa-heart text-success"></i> Cruelty-Free
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Main Product Image</label>
                    <div class="image-upload-area" onclick="document.getElementById('image').click()">
                        <div class="upload-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="upload-text">Click to upload main product image</div>
                        <div class="upload-hint">PNG, JPG, JPEG up to 2MB</div>
                        <input type="file" 
                               class="form-control @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*" 
                               style="display: none;">
                    </div>
                    <img id="imagePreview" class="image-preview" alt="Preview">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Additional Images -->
                <div class="mb-3">
                    <label for="additional_images" class="form-label">Additional Images (Optional)</label>
                    <div class="additional-images-upload-area" onclick="document.getElementById('additional_images').click()">
                        <div class="upload-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <div class="upload-text">Click to upload additional product images</div>
                        <div class="upload-hint">PNG, JPG, JPEG up to 2MB each. You can select multiple images.</div>
                        <input type="file" 
                               class="form-control @error('additional_images.*') is-invalid @enderror" 
                               id="additional_images" 
                               name="additional_images[]" 
                               accept="image/*" 
                               multiple
                               style="display: none;">
                    </div>
                    <div id="additionalImagesPreview" class="additional-images-preview"></div>
                    @error('additional_images.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Product Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status" 
                            required>
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <small class="text-muted">Active products will be visible to customers</small>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Product Flag -->
                <div class="mb-3">
                    <label for="flag" class="form-label">Product Flag</label>
                    <select class="form-control @error('flag') is-invalid @enderror" 
                            id="flag" 
                            name="flag">
                        <option value="All Items" {{ old('flag') == 'All Items' ? 'selected' : '' }}>All Items</option>
                        <option value="New Arrivals" {{ old('flag') == 'New Arrivals' ? 'selected' : '' }}>New Arrivals</option>
                        <option value="Featured" {{ old('flag') == 'Featured' ? 'selected' : '' }}>Featured</option>
                        <option value="On Sale" {{ old('flag') == 'On Sale' ? 'selected' : '' }}>On Sale</option>
                    </select>
                    <small class="text-muted">Choose how this product should be categorized on the site</small>
                    @error('flag')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary-custom">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-custom" id="submitBtn">
                        <span id="submitText">
                            <i class="fas fa-save"></i>
                            Create Product
                        </span>
                        <span id="submitSpinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                            Creating...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const uploadArea = document.querySelector('.image-upload-area');
    const additionalImagesInput = document.getElementById('additional_images');
    const additionalUploadArea = document.querySelector('.additional-images-upload-area');
    const additionalImagesPreview = document.getElementById('additionalImagesPreview');
    const form = document.getElementById('createProductForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');

    let additionalImagesFiles = [];

    // Main image preview functionality
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadArea.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    // Additional images preview functionality
    additionalImagesInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        additionalImagesFiles = [...additionalImagesFiles, ...files];
        updateAdditionalImagesPreview();
    });

    function updateAdditionalImagesPreview() {
        additionalImagesPreview.innerHTML = '';
        
        if (additionalImagesFiles.length > 0) {
            additionalUploadArea.style.display = 'none';
        } else {
            additionalUploadArea.style.display = 'block';
        }

        additionalImagesFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.classList.add('additional-image-preview');
                previewDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Additional Image ${index + 1}">
                    <button type="button" class="remove-image" onclick="removeAdditionalImage(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                additionalImagesPreview.appendChild(previewDiv);
            };
            reader.readAsDataURL(file);
        });

        // Add button to add more images
        if (additionalImagesFiles.length > 0) {
            const addMoreDiv = document.createElement('div');
            addMoreDiv.classList.add('additional-image-preview');
            addMoreDiv.style.border = '2px dashed var(--border-light)';
            addMoreDiv.style.display = 'flex';
            addMoreDiv.style.alignItems = 'center';
            addMoreDiv.style.justifyContent = 'center';
            addMoreDiv.style.cursor = 'pointer';
            addMoreDiv.innerHTML = `
                <i class="fas fa-plus" style="font-size: 1.5rem; color: var(--text-light);"></i>
            `;
            addMoreDiv.onclick = function() {
                additionalImagesInput.click();
            };
            additionalImagesPreview.appendChild(addMoreDiv);
        }
    }

    window.removeAdditionalImage = function(index) {
        additionalImagesFiles.splice(index, 1);
        updateAdditionalImagesPreview();
        
        // Update the file input
        const dt = new DataTransfer();
        additionalImagesFiles.forEach(file => dt.items.add(file));
        additionalImagesInput.files = dt.files;
    };

    // Drag and drop functionality for main image
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });

    // Form submission handling
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitText.style.display = 'none';
        submitSpinner.style.display = 'inline';
    });

    // Reset main image preview if clicked again
    imagePreview.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        uploadArea.style.display = 'block';
    });
});
</script>

@endsection