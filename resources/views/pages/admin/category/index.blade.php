@extends('layouts.admin')

@section('title')
    Category Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
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
                                <a href="{{ route('category.create') }}" class="btn btn-primary mb-3">
                                    + Tambah Category Baru</a>
                                <div class="row mt-4">
                                    @foreach ($categories as $category)
                                        <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                                            <a href="{{ route('category.edit', $category->id) }}"
                                                class="card-dashboard-product d-block">
                                                <div class="card card-body mb-3">
                                                    <img src="{{ Storage::url($category->photo ?? '') }}" alt=""
                                                        class="w-100 mb-2 product-photo" />
                                                    <div class="product-title">{{ $category->name }}</div>
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
