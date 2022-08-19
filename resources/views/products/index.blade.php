@extends('template')

@section('content')

<div class="container">
    <div class="row">
        <h2 class="page-header text-center">Table Product</h2>
        <hr>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        <div class="col">
            <a class="btn btn-outline-info btn-sm float-end" data-bs-toggle="modal" data-bs-target="#createModal">create</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Purchase Price</th>
                    <th>Selling Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
        </table>
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
                <form action="{{ route('product.store') }}" method="post" class="row g-3">
                    @csrf()
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
                        <input type="file" class="form-control" id="image" onclick="previewImage()">
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
