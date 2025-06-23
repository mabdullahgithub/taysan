@extends('admin.layout.app')

@section('title', 'Announcements Management')

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
            Announcements Management
        </h4>
        <div class="d-flex">
            <div class="btn-group mr-2">
                <button type="button" class="btn btn-success btn-sm" id="enableAllBtn">
                    <i class="fa fa-toggle-on mr-1"></i>Enable All
                </button>
                <button type="button" class="btn btn-secondary btn-sm" id="disableAllBtn">
                    <i class="fa fa-toggle-off mr-1"></i>Disable All
                </button>
            </div>
            <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                <i class="fa fa-plus mr-2"></i>Add Announcement
            </a>
        </div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <table id="announcementsTable" class="table table-hover w-100 display pb-30">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Schedule</th>
                                        <th>Countdown</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($announcements as $announcement)
                                        <tr>
                                            <td>
                                                @if($announcement->image)
                                                    <img src="{{ $announcement->image }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <div style="width: 50px; height: 50px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 4px; color: #666;">
                                                        <i class="fa fa-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $announcement->title }}</strong>
                                                    @if($announcement->subtitle)
                                                        <div class="text-muted small">{{ $announcement->subtitle }}</div>
                                                    @endif
                                                    @if($announcement->description)
                                                        <div class="text-muted small">
                                                            {{ Str::limit(strip_tags($announcement->description), 50) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $announcement->status_color }}">
                                                    {{ ucfirst($announcement->status) }}
                                                </span>
                                                <div class="small text-muted mt-1">{{ ucfirst($announcement->type) }}</div>
                                            </td>
                                            <td>
                                                @if($announcement->start_date || $announcement->end_date)
                                                    <div class="small">
                                                        @if($announcement->start_date)
                                                            <div><strong>Start:</strong> {{ $announcement->start_date->format('M d, Y') }}</div>
                                                        @endif
                                                        @if($announcement->end_date)
                                                            <div><strong>End:</strong> {{ $announcement->end_date->format('M d, Y') }}</div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">No schedule</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($announcement->countdown_date)
                                                    <div class="small">
                                                        <strong>Countdown:</strong>
                                                        <div class="text-muted">{{ $announcement->countdown_date->format('M d, Y H:i') }}</div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">No countdown</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $announcement->order }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!-- Toggle Status -->
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-{{ $announcement->is_active ? 'success' : 'secondary' }} mr-2 toggle-status"
                                                            data-id="{{ $announcement->id }}"
                                                            title="{{ $announcement->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="fa fa-{{ $announcement->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                                    </button>

                                                    <!-- View -->
                                                    <a href="{{ route('admin.announcements.show', $announcement) }}" 
                                                       class="btn btn-sm btn-outline-info mr-2" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" 
                                                       class="btn btn-sm btn-outline-primary mr-2" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <!-- Delete -->
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-danger delete-announcement" 
                                                            data-id="{{ $announcement->id }}"
                                                            data-title="{{ $announcement->title }}"
                                                            title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#announcementsTable').DataTable({
        responsive: true,
        order: [[5, 'asc']], // Sort by order column
        columnDefs: [
            { orderable: false, targets: [0, 6] } // Disable sorting on image and actions columns
        ]
    });

    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Toggle Status
    $('.toggle-status').click(function() {
        var button = $(this);
        var announcementId = button.data('id');
        var row = button.closest('tr');
        
        console.log('Toggle status clicked for announcement ID:', announcementId);
        
        // Disable button during request
        button.prop('disabled', true);
        
        $.post('/admin/announcements/' + announcementId + '/toggle-status')
            .done(function(response) {
                console.log('Toggle response:', response);
                if (response.success) {
                    // Update button appearance
                    if (response.is_active) {
                        button.removeClass('btn-outline-secondary').addClass('btn-outline-success');
                        button.find('i').removeClass('fa-toggle-off').addClass('fa-toggle-on');
                        button.attr('title', 'Deactivate');
                    } else {
                        button.removeClass('btn-outline-success').addClass('btn-outline-secondary');
                        button.find('i').removeClass('fa-toggle-on').addClass('fa-toggle-off');
                        button.attr('title', 'Activate');
                    }
                    
                    // Update status badge in the same row
                    var statusBadge = row.find('.badge:first');
                    statusBadge.removeClass('badge-success badge-warning badge-secondary badge-danger');
                    statusBadge.addClass('badge-' + response.status_color);
                    statusBadge.text(response.status.charAt(0).toUpperCase() + response.status.slice(1));
                    
                    // Show success message
                    showToast('Success', response.message, 'success');
                } else {
                    showToast('Error', 'Failed to update announcement status', 'error');
                }
            })
            .fail(function(xhr) {
                console.error('Toggle status failed:', xhr);
                console.error('Response text:', xhr.responseText);
                showToast('Error', 'Failed to update announcement status', 'error');
            })
            .always(function() {
                // Re-enable button
                button.prop('disabled', false);
            });
    });

    // Bulk Enable All
    $('#enableAllBtn').click(function() {
        if (confirm('Are you sure you want to enable all announcements?')) {
            toggleAllAnnouncements(true, $(this));
        }
    });

    // Bulk Disable All
    $('#disableAllBtn').click(function() {
        if (confirm('Are you sure you want to disable all announcements?')) {
            toggleAllAnnouncements(false, $(this));
        }
    });

    // Delete Modal
    $('.delete-announcement').click(function() {
        var announcementId = $(this).data('id');
        var title = $(this).data('title');
        
        $('#deleteTitle').text(title);
        $('#deleteForm').attr('action', '/admin/announcements/' + announcementId);
        $('#deleteModal').modal('show');
    });

    // Prevent double form submission
    $('#deleteForm').submit(function() {
        $(this).find('button[type="submit"]').prop('disabled', true);
    });

    // Function to toggle all announcements
    function toggleAllAnnouncements(status, button) {
        console.log('Toggle all announcements:', status);
        var originalText = button.html();
        button.html('<i class="fa fa-spinner fa-spin mr-1"></i>Processing...').prop('disabled', true);
        
        $.post('/admin/announcements/toggle-all-status', {
            status: status
        })
        .done(function(response) {
            console.log('Bulk toggle response:', response);
            if (response.success) {
                showToast('Success', response.message, 'success');
                // Reload the page to reflect changes
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                showToast('Error', 'Failed to update announcements', 'error');
            }
        })
        .fail(function(xhr) {
            console.error('Bulk toggle failed:', xhr);
            console.error('Response text:', xhr.responseText);
            showToast('Error', 'Failed to update announcements', 'error');
        })
        .always(function() {
            button.html(originalText).prop('disabled', false);
        });
    }

    // Simple toast notification function
    function showToast(title, message, type) {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var toast = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
            '<strong>' + title + ':</strong> ' + message +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>');
        
        // Add to top of container
        $('.container-fluid').prepend(toast);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            toast.alert('close');
        }, 5000);
    }
});
</script>
@endsection
