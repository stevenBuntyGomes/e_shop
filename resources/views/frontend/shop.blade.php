@extends('layouts.frontend_app')

@section('frontend_content')
  <!-- .breadcumb-area start -->
   <div class="breadcumb-area bg-img-4 ptb-100">
       <div class="container">
           <div class="row">
               <div class="col-12">

                   <div class="breadcumb-wrap text-center">
                       <h2>Shop Page</h2>
                       <ul>
                           <li><a href="index.html">Home</a></li>
                           <li><span>Shop</span></li>
                       </ul>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- .breadcumb-area end -->
   <!-- product-area start -->
   <div class="product-area pt-100">
       <div class="container">
           <div class="row">
               <div class="col-sm-12 col-lg-12">
                   <div class="product-menu">
                       <ul class="nav justify-content-center">
                           <li>
                               <a class="active" data-toggle="tab" href="#all">All product</a>
                           </li>
                           @foreach($active_categories as $category)
                             <li>
                                 <a data-toggle="tab" href="#category_id_{{ $category->id }}">{{ $category->category_name }}</a>
                             </li>
                           @endforeach

                       </ul>
                   </div>
               </div>
           </div>
           <div class="tab-content">
               <div class="tab-pane active" id="all">
                   <ul class="row">
                     @foreach($active_products as $single_product)
                       <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                           <div class="product-wrap">
                               <div class="product-img">
                                   <span>Sale</span>
                                   <img src="{{ asset('uploads') }}/product_photos/product_thumbnail_photos/{{ $single_product->product_thumbnail_photo }}" alt="{{ $single_product->product_thumbnail_photo }}">
                                   <div class="product-icon flex-style">
                                       <ul>
                                           <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                           <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                           <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                       </ul>
                                   </div>
                               </div>
                               <div class="product-content">
                                   <h3><a href="single-product.html">{{ $single_product->product_name }}</a></h3>
                                   <p class="pull-left">${{ $single_product->product_price }}

                                   </p>
                                   <ul class="pull-right d-flex">
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star-half-o"></i></li>
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
               @foreach($active_categories as $category)
                 <div class="tab-pane" id="category_id_{{ $category->id }}">
                   <ul class="row">
                     @foreach($category->categoryOneToManyProducts as $single_product)
                       <li class="col-xl-3 col-lg-4 col-sm-6 col-12">
                           <div class="product-wrap">
                               <div class="product-img">
                                   <span>Sale</span>
                                   <img src="{{ asset('uploads') }}/product_photos/product_thumbnail_photos/{{ $single_product->product_thumbnail_photo }}" alt="{{ $single_product->product_thumbnail_photo }}">
                                   <div class="product-icon flex-style">
                                       <ul>
                                           <li><a data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0);"><i class="fa fa-eye"></i></a></li>
                                           <li><a href="wishlist.html"><i class="fa fa-heart"></i></a></li>
                                           <li><a href="cart.html"><i class="fa fa-shopping-bag"></i></a></li>
                                       </ul>
                                   </div>
                               </div>
                               <div class="product-content">
                                   <h3><a href="single-product.html">{{ $single_product->product_name }}</a></h3>
                                   <p class="pull-left">${{ $single_product->product_price }}</p>
                                   <ul class="pull-right d-flex">
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star"></i></li>
                                       <li><i class="fa fa-star-half-o"></i></li>
                                   </ul>
                               </div>
                           </div>
                       </li>
                     @endforeach
                   </ul>
                 </div>
                @endforeach
           </div>
       </div>
   </div>
   <!-- product-area end -->
@endsection
