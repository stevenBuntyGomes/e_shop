@extends('layouts.dashboard_app')

@section('dashboard_content')
    <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('order.index') }}">Orders</a>
      <span class="breadcrumb-item active">Order Show</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a dynamic dashboard</p>
      </div><!-- sl-page-title -->

      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
@endsection

