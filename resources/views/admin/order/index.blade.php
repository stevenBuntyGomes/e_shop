@extends('layouts.dashboard_app')

@section('dashboard_content')
    <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('order.index') }}">Orders</a>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a dynamic dashboard</p>
      </div><!-- sl-page-title -->
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <table class="table" id = "data_table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Sub Total</th>
                            <th scope="col">Discount Amount</th>
                            <th scope="col">Cupon Name</th>
                            <th scope="col">Total</th>
                            <th scope="col">Payment Option</th>
                            <th scope="col">Billing ID</th>
                            <th scope="col">Shipping ID</th>
                            <th scope="col">Payment Status</th>
                            <th scope="col">Action</th>
                            <th scope="col">Cancel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->sub_total }}</td>
                                <td>{{ $order->discount_amount }}</td>
                                <td>{{ $order->cupon_name }}</td>
                                <td>{{ $order->total }}</td>
                                <td>
                                    @if($order->payment_option == 2)
                                        <p class = "btn btn-success">Cash On Delivery</p>
                                    @else
                                        <p class = "btn btn-info">Credit Card</p>
                                    @endif
                                </td>
                                <td>{{ $order->billing_id }}</td>
                                <td>{{ $order->shipping_id }}</td>
                                <td>
                                    @if($order->payment_status == 1)
                                        <p class = "btn btn-info">Unpaid</p>
                                    @elseif($order->payment_status == 2)
                                        <p class = "btn btn-success">Paid</p>
                                    @else
                                        <p class = "btn btn-danger">canceled</p>
                                    @endif
                                </td>
                                <td>
                                    @if($order->payment_status == 1)
                                    <form action="{{ route('order.update', $order->id) }}" method = "POST">
                                        @csrf
                                        @method('PATCH')
                                        <Button type = "submit" class="btn btn-success">Paid</Button>
                                    </form>
                                    @else
                                        <form action="{{ route('order.update', $order->id) }}" method = "POST">
                                            @csrf
                                            @method('PATCH')
                                            <Button type = "submit" class="btn btn-warning">Not Paid</Button>
                                        </form>
                                    @endif
                                </td>
                                <td><a href = "{{ route('orderCancel', $order->id) }}" class="btn btn-danger">Cancel</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
          </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection

@section('footer_script')
  <script type="text/javascript">
  $(document).ready(function() {
  $('#data_table').DataTable({
    "lengthMenu": [4, 5]
  });
  } );
  </script>
@endsection
