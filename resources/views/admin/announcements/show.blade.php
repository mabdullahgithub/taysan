@extends('admin.layout.app')

@section('title', 'View Announcement')

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
            View Announcement
        </h4>
        <div class="d-flex">
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary mr-2">
                <i class="fa fa-arrow-left mr-2"></i>Back to List
            </a>
            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-primary">
                <i class="fa fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-md-8">
                        <!-- Basic Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Title:</strong></div>
                                    <div class="col-sm-9">{{ $announcement->title }}</div>
                                </div>
                                
                                @if($announcement->subtitle)
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Subtitle:</strong></div>
                                        <div class="col-sm-9">{{ $announcement->subtitle }}</div>
                                    </div>
                                @endif
                                
                                @if($announcement->description)
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Description:</strong></div>
                                        <div class="col-sm-9">
                                            <div class="content-display">
                                                {!! nl2br(e($announcement->description)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Type:</strong></div>
                                    <div class="col-sm-9">
                                        <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $announcement->type)) }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Status:</strong></div>
                                    <div class="col-sm-9">
                                        <span class="badge badge-{{ $announcement->status_color }} badge-lg">
                                            {{ ucfirst($announcement->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Display Order:</strong></div>
                                    <div class="col-sm-9">{{ $announcement->order }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Display Duration:</strong></div>
                                    <div class="col-sm-9">{{ $announcement->display_duration }}ms ({{ number_format($announcement->display_duration / 1000, 1) }}s)</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action & Style Information -->
                        @if($announcement->button_text || $announcement->button_link || $announcement->background_color || $announcement->text_color)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Action & Style Settings</h5>
                                </div>
                                <div class="card-body">
                                    @if($announcement->button_text)
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Button Text:</strong></div>
                                            <div class="col-sm-9">{{ $announcement->button_text }}</div>
                                        </div>
                                    @endif
                                    
                                    @if($announcement->button_link)
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Button Link:</strong></div>
                                            <div class="col-sm-9">
                                                <a href="{{ $announcement->button_link }}" target="_blank">{{ $announcement->button_link }}</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if($announcement->background_color)
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Background Color:</strong></div>
                                            <div class="col-sm-9">
                                                <span style="display: inline-block; width: 30px; height: 30px; background-color: {{ $announcement->background_color }}; border: 1px solid #ddd; border-radius: 4px; vertical-align: middle;"></span>
                                                <span style="margin-left: 10px;">{{ $announcement->background_color }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($announcement->text_color)
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Text Color:</strong></div>
                                            <div class="col-sm-9">
                                                <span style="display: inline-block; width: 30px; height: 30px; background-color: {{ $announcement->text_color }}; border: 1px solid #ddd; border-radius: 4px; vertical-align: middle;"></span>
                                                <span style="margin-left: 10px;">{{ $announcement->text_color }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Countdown Information -->
                        @if($announcement->countdown_date)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Countdown Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Countdown Date:</strong></div>
                                        <div class="col-sm-9">{{ $announcement->countdown_date->format('M d, Y \a\t g:i A') }}</div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Status:</strong></div>
                                        <div class="col-sm-9">
                                            @if($announcement->countdown_date->gt(now()))
                                                <span class="badge badge-success">Active</span>
                                                <small class="text-muted ml-2">{{ $announcement->countdown_date->diffForHumans() }}</small>
                                            @else
                                                <span class="badge badge-secondary">Expired</span>
                                                <small class="text-muted ml-2">{{ $announcement->countdown_date->diffForHumans() }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Schedule Information -->
                        @if($announcement->start_date || $announcement->end_date)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Schedule</h5>
                                </div>
                                <div class="card-body">
                                    @if($announcement->start_date)
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Start Date:</strong></div>
                                            <div class="col-sm-9">{{ $announcement->start_date->format('M d, Y') }}</div>
                                        </div>
                                    @endif
                                    
                                    @if($announcement->end_date)
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>End Date:</strong></div>
                                            <div class="col-sm-9">{{ $announcement->end_date->format('M d, Y') }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Metadata -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Metadata</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Created:</strong></div>
                                    <div class="col-sm-9">{{ $announcement->created_at->format('M d, Y \a\t g:i A') }}</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-3"><strong>Last Updated:</strong></div>
                                    <div class="col-sm-9">{{ $announcement->updated_at->format('M d, Y \a\t g:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <!-- Image -->
                        @if($announcement->image)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Image</h5>
                                </div>
                                <div class="card-body">
                                    <img src="{{ $announcement->image }}" 
                                         alt="{{ $announcement->title }}" 
                                         class="img-fluid rounded">
                                </div>
                            </div>
                        @endif

                        <!-- Quick Actions -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <!-- Toggle Status -->
                                <button type="button" 
                                        class="btn btn-block btn-{{ $announcement->is_active ? 'success' : 'secondary' }} mb-2 toggle-status"
                                        data-id="{{ $announcement->id }}">
                                    <i class="fa fa-{{ $announcement->is_active ? 'toggle-on' : 'toggle-off' }} mr-2"></i>
                                    {{ $announcement->is_active ? 'Deactivate' : 'Activate' }}
                                </button>

                                <!-- Edit -->
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" 
                                   class="btn btn-block btn-primary mb-2">
                                    <i class="fa fa-edit mr-2"></i>Edit Announcement
                                </a>

                                <!-- Delete -->
                                <button type="button" 
                                        class="btn btn-block btn-outline-danger delete-announcement" 
                                        data-id="{{ $announcement->id }}"
                                        data-title="{{ $announcement->title }}">
                                    <i class="fa fa-trash mr-2"></i>Delete Announcement
                                </button>
                            </div>
                        </div>

                        <!-- Preview -->
                        @if($announcement->is_active)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Frontend Preview</h5>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('web.view.index') }}#announcements" 
                                       target="_blank" 
                                       class="btn btn-block btn-info">
                                        <i class="fa fa-external-link-alt mr-2"></i>View on Website
                                    </a>
                                    <small class="form-text text-muted">Opens the homepage where this announcement is displayed</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the announcement "<span id="deleteTitle"></span>"?</p>
                <p class="text-danger small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

.content-display {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
    min-height: 100px;
}
</style>

<script>
$(document).ready(function() {
    // Toggle Status
    $('.toggle-status').click(function() {
        var button = $(this);
        var announcementId = button.data('id');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post('/admin/announcements/' + announcementId + '/toggle-status', function(response) {
            if (response.success) {
                // Update button appearance
                if (response.is_active) {
                    button.removeClass('btn-secondary').addClass('btn-success');
                    button.find('i').removeClass('fa-toggle-off').addClass('fa-toggle-on');
                    button.html('<i class="fa fa-toggle-on mr-2"></i>Deactivate');
                } else {
                    button.removeClass('btn-success').addClass('btn-secondary');
                    button.find('i').removeClass('fa-toggle-on').addClass('fa-toggle-off');
                    button.html('<i class="fa fa-toggle-off mr-2"></i>Activate');
                }
                
                // Show success message
                $.toast({
                    heading: 'Success',
                    text: response.message,
                    icon: 'success',
                    position: 'top-right'
                });

                // Reload page to update status badge and other elements
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        }).fail(function() {
            $.toast({
                heading: 'Error',
                text: 'Failed to update announcement status',
                icon: 'error',
                position: 'top-right'
            });
        });
    });

    // Delete Modal
    $('.delete-announcement').click(function() {
        var announcementId = $(this).data('id');
        var title = $(this).data('title');
        
        $('#deleteTitle').text(title);
        $('#deleteForm').attr('action', '/admin/announcements/' + announcementId);
        $('#deleteModal').modal('show');
    });
});
</script>
@endsection
