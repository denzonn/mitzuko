@extends('layouts.admin')

@section('title')
    Dashboard Product Details Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">{{ $product->name }}</h2>
                <p class="dashboard-subtitle">Product Details</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin-dashboard-product-update', $product->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $product->name }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Brand</label>
                                                <input type="text" class="form-control" name="brand"
                                                    value="{{ $product->brand }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" class="form-control" name="stock"
                                                    value="{{ $product->stock }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="number" class="form-control" name="price"
                                                    value="{{ $product->price }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select name="categories_id" class="form-control">
                                                    <option value="{{ $product->categories_id }}">
                                                        {{ $product->category->name }}</option>
                                                    <option value="">Tidak Ada Kategori</option>

                                                    @foreach ($categories as $categories)
                                                        <option value="{{ $categories->id }}">{{ $categories->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Variant</label>
                                                <select name="variant_product_id" class="form-control">
                                                    @if ($product->variant_product_id == 0 || $product->variant_product_id == null)
                                                        <option value="0">Tidak Ada Variant</option>
                                                    @else
                                                        <option value="{{ $product->variant_product_id }}">
                                                            {{ $product->variantProduct->name }}
                                                        </option>
                                                        <option value="0">Tidak Ada Variant</option>
                                                    @endif
                                                    @foreach ($variantProduct as $item)
                                                        @if ($item->id != $product->variant_product_id)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="variant-option">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label>Variant</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="variant-container col-12 px-0">
                                                            @foreach ($variantType as $item)
                                                                <div class="variant-group px-0 d-flex mb-3">
                                                                    <div class="col-3">
                                                                        <input type="text" name="variant_name[]"
                                                                            class="form-control" placeholder="Nama Variant"
                                                                            value="{{ $item->name }}" />
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <input type="number" name="variant_price[]"
                                                                            class="form-control" placeholder="Harga Variant"
                                                                            value="{{ $item->price }}" />
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <input type="number" name="variant_stock[]"
                                                                            class="form-control" placeholder="Stock Variant"
                                                                            value="{{ $item->stock }}" />
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-variant">
                                                                            Hapus
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-6">
                                                            <button type="button"
                                                                class="btn btn-success add-variant">Tambah
                                                                Variant
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea name="description" id="editor">{!! $product->description !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success btn-block px-5">
                                                Save Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($product->galleries as $gallery)
                                        <div class="col-4 col-md-4">
                                            <div class="gallery-container">
                                                <img src="{{ Storage::url($gallery->photos ?? '') }}" alt=""
                                                    class="w-100 product-photo" />
                                                <a href="{{ route('admin-dashboard-product-gallery-delete', $gallery->id) }}"
                                                    class="delete-gallery">
                                                    <img src="/images/remove.svg" alt="" />
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-12">
                                        <form action="{{ route('admin-dashboard-product-gallery-upload') }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="products_id" value="{{ $product->id }}">
                                            <input type="file" id="file" name="photos" style="display: none"
                                                onchange="form.submit()" />
                                            <button type="button" class="btn btn-secondary btn-block mt-3"
                                                onclick="thisFileUpload()">
                                                Add Photo
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector("#editor"))
            .then((editor) => {
                console.log(editor);
            })
            .catch((error) => {
                console.error(error);
            });
    </script>
    <script>
        function thisFileUpload() {
            document.getElementById("file").click();
        }
    </script>

    <script>
        // $(document).ready(function() {
        // Cache select element dan variant container
        var $select = $("select[name='variant_product_id']");
        var $variantOption = $(".variant-option");

        // Saat pertama kali ambil valuenya untuk menentukan apakah dihide atau tidak
        if ($select.val() === "0" || $select.val() === null) {
            // Sembunyikan variant container
            $variantOption.hide();
        } else {
            // Tampilkan variant container
            $variantOption.show();
        }

        // Tambahkan event listener saat select element diubah
        $select.change(function() {
            // Cek apakah opsi "Tidak ada variant" dipilih
            if ($select.val() === "0" || $select.val() === null) {
                // Sembunyikan variant container
                $variantOption.hide();
            } else {
                // Tampilkan variant container
                $variantOption.show();
            }
        });
        // });
    </script>

    <script>
        $('.add-variant').on('click', function() {
            var variantGroup =
                '<div class="variant-group px-0 d-flex mb-3">' +
                '<div class="col-3">' +
                '<input type="text" name="variant_name[]" class="form-control" placeholder="Nama Variant">' +
                '</div>' +
                '<div class="col-3">' +
                '<input type="number" name="variant_price[]" class="form-control" placeholder="Harga Variant">' +
                '</div>' +
                '<div class="col-3">' +
                '<input type="number" name="variant_stock[]" class="form-control" placeholder="Stock Variant">' +
                '</div>' +
                '<div class="col-3">' +
                '<button type="button" class="btn btn-danger remove-variant">Hapus</button>' +
                '</div>' +
                '</div>'
            $('.variant-container').append(variantGroup)
        })

        // Remove variant
        $('.variant-container').on('click', '.remove-variant', function() {
            $(this).closest('.variant-group').remove()
        })
    </script>

    <script>
        $('form').submit(function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: new FormData(form[0]),
                contentType: false,
                processData: false,
                success: function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Product berhasil diupdate',
                        icon: 'success',
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('product.index') }}";
                    }, 2000); // 2000 ms = 2 detik
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                    });
                }
            });
        });
    </script>
@endpush
