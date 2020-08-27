@extends('layouts.dashboard_app')
@section('cupon')
  active
@endsection
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
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">Cupon Table</div>
              <div class="card-body">
                <a class = "btn btn-success" href="{{ route('cupon.create') }}">Add New Cupon</a>
                
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Cupon Name</th>
                      <th scope="col">Added By</th>
                      <th scope="col">Discount Amount</th>
                      <th scope="col">Min Purchase Amount</th>
                      <th scope="col">Valid Till</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($cupon_info as $cupon)
                    <tr>
                        <td>{{ $cupon->id }}</td>
                        <td>{{ $cupon->cupon_name }}</td>
                        <td>{{ $cupon->added_by }}</td>
                        <td>{{ $cupon->discount_amount }}</td>
                        <td>{{ $cupon->minimum_purchase_amount }}</td>
                        <td>{{ $cupon->validity_till }}</td>
                        <td><a href="{{ $cupon->validity_till }}" class = "btn btn-info">Edit</a></td>
                        <td><a href="{{ $cupon->validity_till }}" class = "btn btn-danger">Delete</a></td>
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
