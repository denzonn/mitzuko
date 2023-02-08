@extends('layouts.dashboard')

@section('title')
    Dashboard Setting Account Pages - Store
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">My Account</h2>
                <p class="dashboard-subtitle">Update your current profile</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-12">
                        <div class="toast-container">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <img src="..." class="rounded me-2" alt="...">
                                    <strong class="me-auto">Bootstrap</strong>
                                    <small class="text-muted">just now</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Update Account Success
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('dashboard-settings-account-update') }}" method="POST"
                        enctype="multipart/form-data" id="carts">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Your Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $user->name }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_one">Address 1</label>
                                            <input type="text" class="form-control" id="address_one" name="address_one"
                                                value="{{ $user->address_one }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_two">Address 2</label>
                                            <input type="text" class="form-control" id="address_two" name="address_two"
                                                value="{{ $user->address_two }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="provinces_id">Province</label>
                                            <select name="provinces_id" id="provinces_id" class="form-control"
                                                v-model="provinces_id" v-if="provinces">
                                                <option v-for="province in provinces" :value="province.id">
                                                    @{{ province.name }}
                                                </option>
                                            </select>
                                            <select v-else class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="regencies_id">City</label>
                                            <select name="regencies_id" id="regencies_id" class="form-control"
                                                v-model="regencies_id" v-if="regencies">
                                                <option v-for="regency in regencies" :value="regency.id">
                                                    @{{ regency.name }}
                                                </option>
                                            </select>
                                            <select v-else class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="zip_code">Postal</label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code"
                                                value="{{ $user->zip_code }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" id="country" name="country"
                                                value="{{ $user->country }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="number" class="form-control" id="phone_number"
                                                name="phone_number" value="{{ $user->phone_number }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="photo">Profil Picture</label>
                                            <input type="file" class="form-control" id="photo" name="photo" />
                                            <div class="text-muted">Jika tidak ingin mengganti foto kosongkan saja!</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-success px-5">
                                            Save Now
                                        </button>
                                    </div>
                                </div>
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
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        var carts = new Vue({
            el: "#carts",
            mounted() {
                AOS.init();
                this.getProvincesData();
                this.getDefaultData();
            },
            data: {
                provinces: null,
                regencies: null,
                provinces_id: null,
                regencies_id: null,
            },
            methods: {
                getDefaultData() {
                    //query ke database untuk mengambil data default 
                    var self = this;
                    axios.get('{{ url('api/default/' . Auth::id()) }}')
                        .then(function(response) {
                            console.log(response.data);
                            self.provinces_id = response.data.provinces.id;
                            self.regencies_id = response.data.regencies.id;
                            console.log(self.regencies_id);
                        })
                },
                getProvincesData() {
                    var self = this;
                    axios.get('{{ route('api-provinces') }}')
                        .then(function(response) {
                            self.provinces = response.data;
                        })
                },
                getRegenciesData() {
                    var self = this;
                    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
                        .then(function(response) {
                            self.regencies = response.data;
                        })
                },

            },
            watch: {
                provinces_id: function(val, oldVal) {
                    // this.regencies_id = null;
                    this.getRegenciesData();
                }
            }
        });
    </script>

    <script>
        document.querySelector("#photo").addEventListener("change", function(event) {
            // Ambil file yang diupload
            const file = event.target.files[0];

            // Cek jika file bukan gambar
            if (!file.type.endsWith("png") && !file.type.endsWith("jpeg") && !file.type.endsWith("jpg")) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'File yang anda upload bukan gambar!',
                })
                event.target.value = "";
                return;
            } else if (file.size > 2048 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ukuran File Lebih dari 2 Mb!',
                })
                event.target.value = "";
                return;
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'File yang anda upload adalah gambar!',
                })
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                        text: 'Profil berhasil diupdate',
                        icon: 'success',
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('dashboard-settings-account') }}";
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
