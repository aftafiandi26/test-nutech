@extends('template')

@section('content')
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.css') }}">
<script src="{{ asset('assets/sweetalert2/sweetalert2.js') }}"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<div class="container">
    <div class="row">
        <h2 class="page-header text-center">Table Product</h2>
        <hr>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            @include('sweetalert::alert')
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
            <form action="/product" method="get">
                <label for="keyword">Product Name</label>
                <input type="text" name="keyword" id="keyword" class="form-controll">
                <button type="submit" class="badge bg-secondary">find</button>
            </form>
        </div>
        <div class="col">
            <a class="btn badge bg-info float-end" data-bs-toggle="modal" data-bs-target="#createModal">create</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-condensed table-striped text-center" style="vertical-align: middle;" id="tables">
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
                            <td>{{ "Rp " . number_format($product->buy,2,',','.'); }}</td>
                            <td>{{ "Rp " . number_format($product->sell,2,',','.'); }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a data-bs-role="{{ route('product.show', $product->id) }}" class="badge bg-warning btn" data-bs-target="#editModal" data-bs-toggle="modal" id="edit">edit</a>
                                <a data-bs-role="{{ route('product.destroy', $product->id) }}" class="badge bg-danger btn" id="hapus">hapus</a>
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

<!-- modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content-edit">

        </div>
    </div>
</div>

<!-- form delete -->
<form action="" method="post" id="deleteForm">
    @csrf
    @method("DELETE")
    <input type="submit" value="Hapus" style="display: none">
</form>

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

    $('a#edit').on('click', function(s) {
        const id = $(this).attr('data-bs-role');

        $.ajax({
            url: id,
            success: function(a) {
                $("#modal-content-edit").html(a);
            }
        });
    });

    $('a#hapus').on('click', function(s) {
        const id = $(this).attr('data-bs-role');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-sm btn-success',
                cancelButton: 'btn btn-sm btn-danger'
            },
            buttonsStyling: false
        });

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Anda tidak akan dapat mengembalikannya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus ini!',
            cancelButtonText: 'Tidak, Batalkan!',
        }).then((result) => {
            if (result.value) {
                document.getElementById('deleteForm').action = id;
                document.getElementById('deleteForm').submit();

                swalWithBootstrapButtons.fire(
                    'Terhapus!',
                    'Data berhasil dihapus dari sistem.',
                    'success'
                )
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Dibatalkan',
                    'Data berhasil diamakan :)',
                    'error'
                )
            }
        });

    })
</script>
@endSection