@extends('template')

@section('content')

<div class="container">
    <div class="row">
        <h2 class="page-header text-center">Table Product</h2>
        <hr>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <?php if (!empty($succes)) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $success }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>
            <!--<div class="alert alert-warning alert-dismissible fade show" role="alert">
                A simple warning alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> -->
            <?php if (!empty($errors->all())) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach ($errors->all() as $message) : ?>
                        {{ $message }} <br>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        <div class="col">
            <a class="btn badge bg-info float-end" data-bs-toggle="modal" data-bs-target="#createModal">create</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-condensed table-striped text-center" style="vertical-align: middle;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cover</th>
                        <th>Product</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $key => $product) : ?>
                        <tr>
                            <td>{{ $products->firstItem() + $key }}</td>
                            <td>
                                <img src="{{ $product->getCover() }}" alt="img" class="img img-fluid rounded" height="100px" width="100px">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->buy }}</td>
                            <td>{{ $product->sell }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="#" class="badge bg-success btn">view</a>
                                <a href="#" class="badge bg-warning btn">edit</a>
                                <a href="#" class="badge bg-danger btn">hapus</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            {{ $products->render() }}
        </div>
    </div>
</div>

<!-- modal create -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.store') }}" method="post" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <label for="name">Name Product</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="purchase" class="form-label">Purchase Price</label>
                        <input type="number" name="purchase" id="purchase" class="form-control" min="0">
                    </div>
                    <div class="col-md-6">
                        <label for="selling" class="form-label">Selling Price</label>
                        <input type="number" name="selling" id="selling" class="form-control" min="0">
                    </div>
                    <div class="col-md-12">
                        <label for="stock">Stock</label>
                        <input type="number" name="stock" id="stock" class="form-control" min="0">
                    </div>
                    <div class="col-md-12">
                        <label for="image" class="form-label">Image Product</label>
                        <input type="file" class="form-control" name="image" id="image" onclick="previewImage()">
                        <div class="col-md-12 text-center flex my-2">
                            <img class="img-preview img-fluid " width="250px" height="250px" alt="unknow">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endSection