@extends('layouts.admin')

@section('title')
    Create Category Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Category</h2>
                <p class="dashboard-subtitle">Edit Category</p>
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
                                <form action="{{ route('category.update', $item->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Kategori</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $item->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto</label>
                                                <input type="file" name="photo" class="form-control">
                                                <div class="col-5 col-lg-2 col-md-3 px-0 py-3">
                                                    <div class="card">
                                                        <div class="row text-center">
                                                            <div class="col-12 py-3">
                                                                Foto Kategori Lama
                                                                <img src="{{ Storage::url($item->photo) }}" width="100px"
                                                                    height="100px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-inline-block">
                                            <div class="col-12 d-flex">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label>Rekomendasi Kategori 1</label>
                                                        <select name="recomendation1" class="form-control"
                                                            id="rekomendasi1">
                                                            <option value="{{ $category_one->id ?? '' }}">
                                                                {{ $category_one->name ?? 'Pilih Rekomendasi Kategori' }}
                                                            </option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ $item->recomendation_one == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label>Rekomendasi Kategori 2</label>
                                                        <select name="recomendation2" class="form-control"
                                                            id="rekomendasi2">
                                                            <option value="{{ $category_two->id ?? '' }}">
                                                                {{ $category_two->name ?? 'Pilih Rekomendasi Kategori' }}
                                                            </option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ $item->recomendation_two == $category->id ? 'selected' : '' }}
                                                                    {{ $item->recomendation_one == $category->id ? 'disabled' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col text-center text-lg-right text-sm-center">
                                            <button type="submit" class="btn btn-success px-5">Save Now</button>
                                        </div>
                                    </div>
                                </form>
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
                        text: 'Kategori berhasil diupdate',
                        icon: 'success',
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('category.index') }}";
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
    <script>
        $(document).ready(function() {
            $("#rekomendasi1").change(function() {
                var selected_id = $(this).val();
                $("#rekomendasi2 option").attr("disabled", false);
                $("#rekomendasi2 option").removeClass("text-danger");
                $("#rekomendasi2 option[value=" + selected_id + "]").attr("disabled", true);
                $("#rekomendasi2 option[value=" + selected_id + "]").addClass("text-danger");
            });
        });
    </script>
@endpush
