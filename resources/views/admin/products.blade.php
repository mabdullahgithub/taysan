@extends('admin.layout.app')

@section('title', 'Products Management')

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
                <span class="feather-icon"><i data-feather="package"></i></span>
            </span>
            Products Management
        </h4>
        <div class="d-flex">
            <button class="btn btn-primary" data-toggle="modal" data-target="#productModal">
                <i class="fa fa-plus mr-2"></i>Add Product
            </button>
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
                            <table id="productsTable" class="table table-hover w-100 display pb-30">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-fluid" 
                                                 style="max-width: 50px;">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            <button class="btn btn-icon btn-icon-circle btn-secondary btn-icon-style-2 edit-product" 
                                                    data-id="{{ $product->id }}" data-toggle="modal" data-target="#productModal" 
                                                    data-action="{{ route('admin.products.update', $product->id) }}" 
                                                    data-method="PUT">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-icon btn-icon-circle btn-danger btn-icon-style-2" 
                                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
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
    <!-- /Row -->
</div>
<!-- /Container -->

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- If editing, _method and product_id will be set via JavaScript -->
                <input type="hidden" name="product_id" id="product_id">
                <div class="modal-body">
                    <div class="row">
                        <!-- Form Fields -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" name="stock" id="stock" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image" id="image">
                                <div id="imagePreview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveButton">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#productsTable').DataTable();

    // Edit product - populate the form with existing data
    $('.edit-product').click(function() {
        let button = $(this);
        let productId = button.data('id');

        // Fetch product data via AJAX for populating the form
        $.get("{{ url('admin/products') }}/" + productId + "/edit", function(response) {
            if(response.status === 'success') {
                let product = response.data;
                $('#modalTitle').text('Edit Product');
                $('#productForm').attr('action', "{{ url('admin/products') }}/" + productId);
                $('#productForm').append('<input type="hidden" name="_method" value="PUT">');
                $('#product_id').val(product.id);
                $('#name').val(product.name);
                $('#category_id').val(product.category_id);
                $('#description').val(product.description);
                $('#price').val(product.price);
                $('#stock').val(product.stock);
                
                if(product.image) {
                    $('#imagePreview').html(`
                        <img src="{{ asset('storage') }}/${product.image}" 
                             class="img-thumbnail" 
                             style="max-width: 200px">
                    `);
                }
                $('#productModal').modal('show');
            } else {
                alert('Failed to load product data.');
            }
        });
    });

    // Reset form when modal is closed
    $('#productModal').on('hidden.bs.modal', function () {
        $('#modalTitle').text('Add Product');
        $('#productForm').attr('action', "{{ route('admin.products.store') }}");
        $('#productForm').find('input[name="_method"]').remove();
        $('#product_id').val('');
        $('#productForm')[0].reset();
        $('#imagePreview').html('');
    });
});
</script>
@endpush