@extends('layouts.frontend_app')
@section('frontend_content')
  <!-- .breadcumb-area start -->
  {{ print_r(session()->all()) }}
    <div class="breadcumb-area bg-img-4 ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcumb-wrap text-center">
                        <h2>Shopping Cart</h2>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><span>Shopping Cart</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .breadcumb-area end -->
    <!-- cart-area start -->
    <div class="cart-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                  @if(session('cart_item_deleted'))
                    <div class="alert alert-warning">
                      <p>{{ session('cart_item_deleted') }}</p>
                    </div>
                  @endif
                    @if(session('no_order_id'))
                        <div class = "alert alert-warning">
                            <p>{{ session('no_order_id') }}</p>
                        </div>
                    @endif
                  @if(session('update_success'))
                    <div class="alert alert-success">
                      <p>{{ session('update_success') }}</p>
                    </div>
                  @endif

                  @if($msg != "")
                    <div class="alert alert-danger">
                      <p>{{ $msg }}</p>
                    </div>
                  @endif
                    <form action="{{ route('cart.updarte') }}" method = "post">
                      @csrf
                        <table class="table-responsive cart-wrap">
                            <thead>
                                <tr>
                                    <th class="images">Image</th>
                                    <th class="product">Product</th>
                                    <th class="ptice">Price</th>
                                    <th class="quantity">Quantity</th>
                                    <th class="total">Total</th>
                                    <th class="remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                $sub_total = 0;
                                $flag = 0;
                              @endphp
                              @forelse(cart_items() as $cart_item)
                                <tr class = "{{ ($cart_item->product->product_quantity < $cart_item->product_quantity) ?'bg-danger':'' }}">
                                    <td class="images"><img src="{{ asset('uploads/product_photos/product_thumbnail_photos') }}/{{ $cart_item->product->product_thumbnail_photo }}" alt=""></td>
                                    <td class="product"><a href="{{ url('product/details') }}/{{ $cart_item->product->slug }}" target = "blank">{{ $cart_item->product->product_name }}</a>
                                      @if($cart_item->product->product_quantity < $cart_item->product_quantity)
                                        <span class = "alert alert-warning">available quantity: {{ $cart_item->product->product_quantity }}</span>
                                        @php
                                          $flag = 1;
                                        @endphp
                                      @endif
                                    </td>
                                    <td class="ptice">${{ $cart_item->product->product_price }}</td>
                                    <td class="quantity cart-plus-minus">
                                        <input type="text" name = "product_info[{{ $cart_item->id }}]" value="{{ $cart_item->product_quantity }}" />
                                    </td>
                                    <td class="total">${{ $cart_item->product_quantity * $cart_item->product->product_price }}</td>
                                    <td class="remove">
                                      <a href="{{ route('cart.remove', $cart_item->id) }}" class = "btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                                    </td>
                                    @php
                                      $sub_total += $cart_item->product_quantity * $cart_item->product->product_price;
                                    @endphp
                                </tr>
                              @empty
                                <tr>
                                  <td clospan = "50"> --- No Products to show --- </td>
                                </tr>
                              @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-60">
                            <div class="col-xl-4 col-lg-5 col-md-6 ">
                                <div class="cartcupon-wrap">
                                    <ul class="d-flex">
                                        <li>
                                            <button>Update Cart</button>
                                        </li>
                                        <li><a href="{{ route('index') }}">Continue Shopping</a></li>
                                    </ul>
                    </form>
                                    <h3>Cupon</h3>
                                    <p>Enter Your Cupon Code if You Have One</p>
                                    <div class="cupon-wrap">
                                        <input value = "{{ $cupon_name }}" type="text" placeholder="Cupon Code" id = "apply_cupon_name">
                                        <button type = "button" id = "apply_cupon">Apply Cupon</button>

                                    </div>

                                </div>
                            </div>

                            <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                                <div class="cart-total text-right">
                                    <h3>Cart Totals</h3>
                                    <ul>
                                        <li><span class="pull-left">Subtotal </span>${{ $sub_total }}</li>
                                        @php
                                            session(['sub_total' => $sub_total]);
                                        @endphp
                                        <li><span class="pull-left">Discount(%) </span>{{ $discount_amount }}%</li>
                                        <li><span class="pull-left">Discount Amount({{ ($cupon_name) ? $cupon_name : '-' }}) </span>${{ ($sub_total * $discount_amount) / 100 }}</li>
                                        @php
                                            session(['cupon_name' => ($cupon_name) ? $cupon_name : '-']);
                                            session(['discount_amount' => ($sub_total * $discount_amount) / 100]);
                                        @endphp
                                        <li><span class="pull-left"> Total </span>${{ $sub_total - ($sub_total * $discount_amount) / 100 }}</li>
                                    </ul>
                                    @if($flag == 1)
                                      <a href="#">The quantity not available</a>
                                    @else
                                      <a href="{{ url('checkout') }}">Proceed to Checkout</a>
                                    @endif
                                </div>
                                <ul>
                                        @foreach($valid_cupon as $v_cupon)
                                          <button type = "button" value = "{{ $v_cupon->cupon_name }}" class = "btn btn-success available_cupon">Get {{ $v_cupon->cupon_name }} By buying minimum of {{ $v_cupon->minimum_purchase_amount }} </button>
                                        @endforeach
                                    </ul>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->
@endsection
@section('apply_cupon')
  <script>
    $(document).ready(function(){
      $('#apply_cupon').click(function(){
        var apply_cupon_name = $('#apply_cupon_name').val();
        var link_to_go = "{{ url('cart') }}/"+apply_cupon_name;
        // alert(link_to_go);
        window.location.href = link_to_go;
      });

    });

  </script>
  <script>
    $(document).ready(function(){
      $('.available_cupon').click(function(){
        $('#apply_cupon_name').val($(this).val());
      });
    });
  </script>
@endsection
