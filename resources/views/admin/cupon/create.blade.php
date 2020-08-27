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
                <form action = "{{ route('cupon.store') }}" method = "post">
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Cupon Name</label>
                    <input type="text" class="form-control" name = "cupon_name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Discount Amount</label>
                    <input type="text" class="form-control" name = "discount_amount">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Minimum Purchase Amount</label>
                    <input type="text" class="form-control" name = "minimum_purchase_amount">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Valid Till</label>
                    <input type="date" class="form-control" name = "validity_till">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection
