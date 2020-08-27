
@extends('layouts.dashboard_app')
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="index.html">Starlight</a>
      <a class="breadcrumb-item" href="index.html">Pages</a>
      <span class="breadcrumb-item active">Blank Page</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a dynamic dashboard</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                  <h1>You are customer</h1>
                  <div class="card mt-5">
                    <div class="card-header">Your Orders</div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">user_id</th>
                                    <th scope="col">sub_total</th>
                                    <th scope="col">discount_amount</th>
                                    <th scope="col">cupon_name</th>
                                    <th scope="col">total</th>
                                    <th scope="col">payment_option</th>
                                    <th scope="col">payment_status</th>
                                    <th scope="col">billing_id</th>
                                    <th scope="col">shipping_id</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_info as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user_id }}</td>
                                        <td>{{ $order->sub_total }}</td>
                                        <td>{{ $order->discount_amount }}</td>
                                        <td>{{ $order->cupon_name }}</td>
                                        <td>{{ $order->total }}</td>
                                        <td>
                                            @if($order->payment_option == 1)
                                                Cash On Delivery
                                            @else
                                                Card
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->payment_status == 1)
                                                unpaid
                                            @else
                                                paid
                                            @endif
                                        </td>
                                        <td>{{ $order->billing_id }}</td>
                                        <td>{{ $order->shipping_id }}</td>
                                        <td><a class = "btn btn-success" href="{{ url('customer/invoice/download') }}/{{ $order->id }}"><i class = "fa fa-download"> Invoice</i></a></td>
                                    </tr>
                                    <tr>
                                        <td colspan = "50">
                                            @foreach($order->order_detail as $detail)
                                                <p>{{ $detail->product->product_name }}</p>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                    </div>
                    </div>
              </div>
          </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    @endsection
