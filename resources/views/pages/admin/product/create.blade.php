@extends('layouts.admin')

@section('title')
    Create Product Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home mb-4" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Add New Product</h2>
                <p class="dashboard-subtitle">Create your own product</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" class="form-control" name="name" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Brand</label>
                                                <input type="text" class="form-control" name="brand" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" class="form-control" name="stock" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Price</label>
                                                <input type="number" class="form-control" name="price" required />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select name="categories_id" class="form-control" required>
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
                                                    <option value="">Tidak Ada Variant</option>
                                                    @foreach ($variantProduct as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                                            <div class="variant-group px-0 d-flex mb-3">
                                                                <div class="col-3">
                                                                    <input type="text" name="variant_name[]"
                                                                        class="form-control" placeholder="Nama Variant" />
                                                                </div>
                                                                <div class="col-3">
                                                                    <input type="number" name="variant_price[]"
                                                                        class="form-control" placeholder="Harga Variant" />
                                                                </div>
                                                                <div class="col-3">
                                                                    <input type="number" name="variant_stock[]"
                                                                        class="form-control" placeholder="Stock Variant" />
                                                                </div>
                                                                <div class="col-3">
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-variant">
                                                                        Hapus
                                                                    </button>
                                                                </div>
                                                            </div>
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
                                                <textarea name="description" id="editor"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Thumbnails</label>
                                                <input type="file" name="photo" class="form-control" required />
                                                <p class="text-muted">
                                                    Kamu dapat memilih lebih dari satu file
                                                </p>
                                            </div>
                                        </div>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    {{-- <script>
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
                        text: 'Product berhasil ditambahkan',
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
    </script> --}}

    <script>
        // $(document).ready(function() {
        // Cache select element dan variant container
        var $select = $("select[name='variant_product_id']");
        var $variantOption = $(".variant-option");

        // Sembunyikan variant container saat halaman pertama kali dimuat
        $variantOption.hide();

        // Tambahkan event listener saat select element diubah
        $select.change(function() {
            // Cek apakah opsi "Tidak ada variant" dipilih
            if ($select.val() === "") {
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
@endpush
