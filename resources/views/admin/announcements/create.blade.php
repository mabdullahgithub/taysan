@extends('admin.layout.app')

@section('title', 'Create Announcement')

@section('content')
<!-- Container -->
<div class="container-fluid">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title">
            <span class="pg-title-icon">
                <span class="feather-icon"><i data-feather="megaphone"></i></span>
            </span>
            Create New Announcement
        </h4>
        <div class="d-flex">
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Title -->
                                    <div class="form-group">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('title') is-invalid @enderror" 
                                               id="title" 
                                               name="title" 
                                               value="{{ old('title') }}" 
                                               required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subtitle -->
                                    <div class="form-group">
                                        <label for="subtitle" class="form-label">Subtitle</label>
                                        <input type="text" 
                                               class="form-control @error('subtitle') is-invalid @enderror" 
                                               id="subtitle" 
                                               name="subtitle" 
                                               value="{{ old('subtitle') }}" 
                                               placeholder="Optional subtitle">
                                        @error('subtitle')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="5"
                                                  placeholder="Enter announcement description...">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Type -->
                                    <div class="form-group">
                                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                        <select class="form-control @error('type') is-invalid @enderror" 
                                                id="type" 
                                                name="type" 
                                                required>
                                            <option value="">Select Type</option>
                                            <option value="announcement" {{ old('type') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                                            <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                                            <option value="countdown" {{ old('type') == 'countdown' ? 'selected' : '' }}>Countdown</option>
                                            <option value="product_launch" {{ old('type') == 'product_launch' ? 'selected' : '' }}>Product Launch</option>
                                            <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Button & Action Settings -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Button & Action Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Button Text -->
                                            <div class="form-group">
                                                <label for="button_text" class="form-label">Button Text</label>
                                                <input type="text" 
                                                       class="form-control @error('button_text') is-invalid @enderror" 
                                                       id="button_text" 
                                                       name="button_text" 
                                                       value="{{ old('button_text') }}" 
                                                       placeholder="e.g., Shop Now">
                                                @error('button_text')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Button Link -->
                                            <div class="form-group">
                                                <label for="button_link" class="form-label">Button Link</label>
                                                <input type="text" 
                                                       class="form-control @error('button_link') is-invalid @enderror" 
                                                       id="button_link" 
                                                       name="button_link" 
                                                       value="{{ old('button_link') }}" 
                                                       placeholder="e.g., /shop">
                                                @error('button_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Styling -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Colors & Styling</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Background Color -->
                                            <div class="form-group">
                                                <label for="background_color" class="form-label">Background Color</label>
                                                <input type="color" 
                                                       class="form-control @error('background_color') is-invalid @enderror" 
                                                       id="background_color" 
                                                       name="background_color" 
                                                       value="{{ old('background_color', '#8B7BA8') }}">
                                                @error('background_color')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Text Color -->
                                            <div class="form-group">
                                                <label for="text_color" class="form-label">Text Color</label>
                                                <input type="color" 
                                                       class="form-control @error('text_color') is-invalid @enderror" 
                                                       id="text_color" 
                                                       name="text_color" 
                                                       value="{{ old('text_color', '#FFFFFF') }}">
                                                @error('text_color')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Image Upload -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Image</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="image" class="form-label">Upload Image</label>
                                        <input type="file" 
                                               class="form-control-file @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Recommended: 800x600px or larger</small>
                                    </div>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Scheduling -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Status & Scheduling</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Active Status -->
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" 
                                                   class="custom-control-input" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1" 
                                                   {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">
                                                Active
                                            </label>
                                            <small class="form-text text-muted">Enable to make this announcement visible</small>
                                        </div>
                                    </div>

                                    <!-- Display Order -->
                                    <div class="form-group">
                                        <label for="order" class="form-label">Display Order</label>
                                        <input type="number" 
                                               class="form-control @error('order') is-invalid @enderror" 
                                               id="order" 
                                               name="order" 
                                               value="{{ old('order', 0) }}" 
                                               min="0">
                                        @error('order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Lower numbers appear first</small>
                                    </div>

                                    <!-- Display Duration -->
                                    <div class="form-group">
                                        <label for="display_duration" class="form-label">Display Duration (ms)</label>
                                        <input type="number" 
                                               class="form-control @error('display_duration') is-invalid @enderror" 
                                               id="display_duration" 
                                               name="display_duration" 
                                               value="{{ old('display_duration', 5000) }}" 
                                               min="1000">
                                        @error('display_duration')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">How long to show each announcement (milliseconds)</small>
                                    </div>

                                    <!-- Start Date -->
                                    <div class="form-group">
                                        <label for="start_date" class="form-label">Start Date (Optional)</label>
                                        <input type="date" 
                                               class="form-control @error('start_date') is-invalid @enderror" 
                                               id="start_date" 
                                               name="start_date" 
                                               value="{{ old('start_date') }}">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">When to start showing this announcement</small>
                                    </div>

                                    <!-- End Date -->
                                    <div class="form-group">
                                        <label for="end_date" class="form-label">End Date (Optional)</label>
                                        <input type="date" 
                                               class="form-control @error('end_date') is-invalid @enderror" 
                                               id="end_date" 
                                               name="end_date" 
                                               value="{{ old('end_date') }}">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">When to stop showing this announcement</small>
                                    </div>

                                    <!-- Countdown Date -->
                                    <div class="form-group">
                                        <label for="countdown_date" class="form-label">Countdown Date (Optional)</label>
                                        <input type="datetime-local" 
                                               class="form-control @error('countdown_date') is-invalid @enderror" 
                                               id="countdown_date" 
                                               name="countdown_date" 
                                               value="{{ old('countdown_date') }}">
                                        @error('countdown_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Show countdown to this date/time</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-right">
                                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save mr-2"></i>Create Announcement
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Image preview
    $('#image').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });

    // Date validation
    $('#start_date, #end_date').change(function() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        
        if (startDate && endDate && startDate > endDate) {
            alert('End date must be after start date');
            $(this).val('');
        }
    });

    // Counter target/label dependency
    $('#counter_target').change(function() {
        var hasTarget = $(this).val();
        if (hasTarget && !$('#counter_label').val()) {
            $('#counter_label').focus();
        }
    });
});
</script>
@endsection
