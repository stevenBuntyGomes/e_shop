@extends('layouts.frontend_app')
@section('frontend_content')
    <div class="product-area">
        <div class="fluid-container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Searched items ({{ $search_results->count() }})</h2>
                        <img src="{{ asset('frontend_asset') }}/assets/images/section-title.png" alt="">
                    </div>
                </div>
            </div>
            <ul class="row">
                @foreach($search_results as $search)
                  <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="product-wrap">
                            <div class="product-img">
                                <span>Sale</span>
                                <img src="{{ asset('uploads/product_photos/product_thumbnail_photos') }}/{{ $search->product_thumbnail_photo }}" alt="{{ $search->product_thumbnail_photo }}">
                                <div class="product-icon flex-style">
                                    <ul>
                                        <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="{{ route('wishStore', $search->id) }}"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{ url('product/details') }}/{{ $search->slug }}">{{ $search->product_name }}</a></h3>
                                <p class="pull-left">${{ $search->product_price }}

                                </p>
                                <ul class="pull-right d-flex">
                                    @if(average_stars($search->id) == 0)
                                        no reviews yet
                                    @endif
                                    @for($i = 1; $i <= average_stars($search->id); $i++)
                                        <li><i class="fa fa-star"></i></li>
                                    @endfor
                                    {{-- <li><i class="fa fa-star-half-o"></i></li> --}}
                                </ul>
                            </div>
                        </div>
                    </li>
                @endforeach
                <li class="col-12 text-center">
                    <a class="loadmore-btn" href="javascript:void(0);">Load More</a>
                </li>
            </ul>
        </div>
    </div>
@endsection
