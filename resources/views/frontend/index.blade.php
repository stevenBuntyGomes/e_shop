@extends('layouts.frontend_app')
@section('frontend_content')

    <!-- slider-area start -->
    <div class="slider-area">
        <div class="swiper-container">
            <div class="swiper-wrapper">
              @foreach($active_sliders as $slider)
                <div class="swiper-slide overlay">
                    <div style = "background: url('{{ asset('uploads/slider_images/') }}/{{ $slider->slider_image }}');" class="single-slider slide-inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-lg-9 col-12">
                                    <div class="slider-content">
                                        <div class="slider-shape">
                                            <h2 data-swiper-parallax="-500">{{ $slider->slider_header }}</h2>
                                            <p data-swiper-parallax="-400">{{ $slider->slider_description }}</p>
                                            <a href="{{ $slider->slier_link }}" data-swiper-parallax="-300">{{ $slider->slider_button }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <!-- slider-area end -->
    <!-- featured-area start -->
    @include('frontend.indludes.featured_area')
    <!-- featured-area end -->
    <!-- start count-down-section -->
    <div class="count-down-area count-down-area-sub">
        <section class="count-down-section section-padding parallax" data-speed="7">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12 text-center">
                        <h2 class="big">Deal Of the Day <span>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin</span></h2>
                    </div>
                    <div class="col-12 col-lg-12 text-center">
                        <div class="count-down-clock text-center">
                            <div id="clock">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
    </div>
    <!-- end count-down-section -->
    <!-- product-area start -->
    <div class="product-area product-area-2">
        <div class="fluid-container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Best Seller</h2>

                        <img src="assets/images/section-title.png" alt="">
                    </div>
                </div>
            </div>
            <ul class="row">
                @foreach ($best_seller as $best)
                            {{-- {{ print_r($best->product_id) }} --}}
                        <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                            <div class="product-wrap">
                                <div class="product-img">
                                    <img src="{{ asset('uploads/product_photos/product_thumbnail_photos') }}/{{ App\Product::find($best->product_id)->product_thumbnail_photo }}" alt="">
                                    <div class="product-icon flex-style">
                                        <ul>
                                            <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                            <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{ url('product/details') }}/{{ App\Product::find($best->product_id)->slug }}">{{ App\Product::find($best->product_id)->product_name }}</a></h3>
                                    <p class="pull-left">${{ App\Product::find($best->product_id)->product_price }}

                                    </p>
                                    <ul class="pull-right d-flex">
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                        {{-- <li><i class="fa fa-star-half-o"></i></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </li>
                @endforeach

            </ul>
        </div>
    </div>
    <!-- product-area end -->
    <!-- product-area start -->
    <div class="product-area">
        <div class="fluid-container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Our Latest Product</h2>
                        <img src="{{ asset('frontend_asset') }}/assets/images/section-title.png" alt="">
                    </div>
                </div>
            </div>
            <ul class="row">
                @foreach($active_products as $product)
                  <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                        <div class="product-wrap">
                            <div class="product-img">
                                <span>Sale</span>
                                <img src="{{ asset('uploads/product_photos/product_thumbnail_photos') }}/{{ $product->product_thumbnail_photo }}" alt="{{ $product->product_thumbnail_photo }}">
                                <div class="product-icon flex-style">
                                    <ul>
                                        <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                        <li><a href="{{ route('wishStore', $product->id) }}"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{ url('product/details') }}/{{ $product->slug }}">{{ $product->product_name }}</a></h3>
                                <p class="pull-left">${{ $product->product_price }}

                                </p>
                                <ul class="pull-right d-flex">
                                    @if(average_stars($product->id) == 0)
                                        no reviews yet
                                    @endif
                                    @for($i = 1; $i <= average_stars($product->id); $i++)
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
    <!-- product-area end -->
    <!-- testmonial-area start -->
    <div class="testmonial-area testmonial-area2 bg-img-2 black-opacity">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="test-title text-center">
                        <h2>What Our client Says</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1 col-12">
                    <div class="testmonial-active owl-carousel">
                      @foreach($active_testimonial as $testimonial)
                        <div class="test-items test-items2">
                            <div class="test-content">
                                <p>{{ $testimonial->testimonial_description }}</p>
                                <h2>{{ $testimonial->testimonial_title }}</h2>
                                <p>{{ $testimonial->testimonial_designation }}</p>
                            </div>
                            <div class="test-img2">
                                <img src="{{ asset('uploads/testimonial_images') }}/{{ $testimonial->testimonial_image }}" alt="{{ $testimonial->testimonial_image }}">
                            </div>
                        </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- testmonial-area end -->
    <!-- start social-newsletter-section -->

@endsection
