@extends('layouts.admin')

@section('title')
    Product Pages - Store
@endsection



@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Product</h2>
                <p class="dashboard-subtitle">List of Product</p>
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
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('product.create') }}" class="btn  mb-3"
                                            style="background: #f74d2e; color: white">
                                            + Tambah Product Baru
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <form action="/admin/product/search" method="get" enctype="multipart/form-data">
                                            <div class="search-bar">
                                                <input type="text" placeholder="Search" class="wide" name="search"
                                                    value="{{ request('search') }}">
                                                <input type="hidden" value="submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row mt-4 ">
                                    @forelse ($products as $product)
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3" id="showProduct">
                                            <a href="{{ route('admin-dashboard-product-details', $product->id) }}"
                                                class="card card-dashboard-product d-block">
                                                <div class="card card-body">
                                                    <img src="{{ Storage::url($product->galleries->first()->photos ?? '') }}"
                                                        alt="" class="w-100 mb-2 product-photo" />
                                                    <div class="product-title">
                                                        @if (strlen($product->name) > 40)
                                                            <span
                                                                class="product-name-short">{{ substr($product->name, 0, 40) }}...</span>
                                                            <span class="product-name-full"
                                                                style="display: none;">{{ $product->name }}</span>
                                                        @else
                                                            {{ $product->name }}
                                                        @endif
                                                    </div>
                                                    <div class="product-category">{{ $product->category->name }}</div>
                                                </div>
                                                <a href="{{ route('admin-dashboard-product-delete', $product->id) }}"
                                                    class="delete-gallery">
                                                    <img src="/images/remove.svg" alt=""
                                                        style="float:right; position:absolute; right: 0%; top: 0px;" />
                                                </a>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center py-5" data-aos="fade-up" data-aos-delay="100">
                                            <img src="/images/noProduct.png" style="height: 150px; width: auto"
                                                alt="">
                                        </div>
                                    @endforelse
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
                title: 'Apakah kamu yakin ingin menghapus product?',
                html: '<span class="text-muted" style="font-size: 14px;">Product yang telah dihapus tidak dapat dikembalikan!</span>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus product!'
            }).then((result) => {
                if (result.value) {
                    // Mengambil link dari href
                    window.location.href = link;
                }
            })
        });
    </script>

    <script>
        $('.product-name-short').click(function() {
            $(this).hide();
            $(this).siblings('.product-name-full').show();
        });
        $('.product-name-full').click(function() {
            $(this).hide();
            $(this).siblings('.product-name-short').show();
        });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
