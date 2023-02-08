@extends('layouts.dashboard')

@section('title')
    Dashboard User Review Pages - Store
@endsection


@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">User Review</h2>
                <p class="dashboard-subtitle">
                    Give Review For The Product
                </p>
            </div>
            <div class="dashboard-content">
                <div class="tab-content" id="myTabContent">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card card-list d-block">
                                <div class="col-12 col-lg-10 col-md-10">
                                    @foreach ($transactions as $transaction)
                                        <a class="d-block" style="text-decoration: none"
                                            href="{{ route('detail', $transaction->product->slug) }}">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-2 col-lg-1 col-md-1">
                                                        <img src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                                            alt="" style="width: 70px; height: auto" />
                                                    </div>
                                                    <div class="col-7 col-lg-9 col-md-9">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="col-12 subtitle-dashboard"
                                                                    style="font-size: 20px">
                                                                    {{ $transaction->product->name }}
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="col-12 text-muted subtitle-dashboard"
                                                                    style="font-size: 15px">
                                                                    @foreach ($variantData as $item)
                                                                        @if ($item->id == $transaction->variant_type_id)
                                                                            <div class="text-muted" style="font-size: 15px">
                                                                                Variant : {{ $item->name }}
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                    @if (empty($transaction->variant_type_id))
                                                                    @endif
                                                                </div>
                                                                <div class="col-12  subtitle-dashboard"
                                                                    style="font-size: 15px">
                                                                    Quantity : {{ $transaction->quantity }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3 col-lg-2 col-md-2">
                                                        <div class="col-12 subtitle-dashboard" style="font-size: 20px">
                                                            Rp. {{ number_format($transaction->price, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            {{-- Product Comment --}}
                            <div id="review_form_wrapper">
                                <div id="review_form">
                                    <div id="respond" class="comment-respond">
                                        @foreach ($transactions as $item)
                                            <form action="{{ route('dashboard-transaction-add-review') }}" method="post"
                                                id="commentform" class="comment-form">
                                                @csrf
                                                <input type="hidden" name="transaction_details_id"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" name="products_id" value="{{ $item->product->id }}">
                                                <p class="comment-notes">
                                                    <span id="email-notes">Your email address will not be published.</span>
                                                    Required fields
                                                    are marked <span class="required">*</span>
                                                </p>
                                                <div class="row">
                                                    <div class="comment-form-rating col-12">
                                                        <span>Your rating*</span>
                                                        <p class="stars">

                                                            <label for="rated-1"></label>
                                                            <input type="radio" id="rated-1" name="rating"
                                                                value="1" checked="checked">
                                                            <label for="rated-2"></label>
                                                            <input type="radio" id="rated-2" name="rating"
                                                                value="2">
                                                            <label for="rated-3"></label>
                                                            <input type="radio" id="rated-3" name="rating"
                                                                value="3">
                                                            <label for="rated-4"></label>
                                                            <input type="radio" id="rated-4" name="rating"
                                                                value="4">
                                                            <label for="rated-5"></label>
                                                            <input type="radio" id="rated-5" name="rating"
                                                                value="5">
                                                        </p>
                                                    </div>
                                                    <div class="col-12">
                                                        <textarea name="comment" id="editor" cols="30" rows="10"></textarea>
                                                        <button type="submit" class="btn btn-payment mt-3">
                                                            Submit
                                                            Review
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endforeach
                                    </div><!-- .comment-respond-->
                                </div><!-- #review_form -->
                            </div><!-- #review_form_wrapper -->
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
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
