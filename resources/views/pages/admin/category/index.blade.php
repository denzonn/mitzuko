@extends('layouts.admin')

@section('title')
    Category Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home mb-5" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Category</h2>
                <p class="dashboard-subtitle">List of Category</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
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
                                <a href="{{ route('category.create') }}" class="btn mb-3"
                                    style="background: #f74d2e; color: white; outline: #f74d2e">
                                    + Tambah Category Baru</a>
                                <div class="row mt-4">
                                    @foreach ($categories as $category)
                                        <div class="col-4 col-md-3 col-lg-2">
                                            <a href="{{ route('category.edit', $category->id) }}"
                                                class="card-dashboard-product d-block" style="text-decoration: none">
                                                <div class="card card-body mb-3">
                                                    <img src="{{ Storage::url($category->photo ?? '') }}" alt=""
                                                        class="w-100 mb-2 product-photo" />
                                                    <div class="product-title text-center">{{ $category->name }}</div>
                                                </div>
                                                <a href="{{ route('admin-dashboard-category-delete', $category->id) }}"
                                                    class="delete-gallery">
                                                    <img src="/images/remove.svg" alt=""
                                                        style="float:right; position:absolute; right: 0%; top: 0px;" />
                                                </a>
                                            </a>
                                        </div>
                                    @endforeach
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
    <script>
        $(document).on('click', '.delete-gallery', function(e) {

            // Hentikan dahulu routenya menunggu konfirmasi dari sweetalert
            e.preventDefault();
            var link = $(this).attr('href');

            Swal.fire({
                title: 'Apakah kamu yakin ingin menghapus data ini?',
                html: '<span class="text-muted" style="font-size: 14px;">Data yang telah dihapus tidak dapat dikembalikan!</span>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus data!'
            }).then((result) => {
                if (result.value) {
                    // Mengambil link dari href
                    window.location.href = link;
                }
            })
        });
    </script>
@endpush
