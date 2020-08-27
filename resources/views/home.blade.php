@extends('layouts.dashboard_app')
@section('my_title')
  Home
@endsection
@section('home')
  active
@endsection
@section('dashboard_content')
  <!-- ########## START: MAIN PANEL ########## -->
      <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
          <a class="breadcrumb-item" href="{{ url('/home') }}">Home</a>
        </nav>

        <div class="sl-pagebody">
          <div class="sl-page-title">
            <h5>Dashboard</h5>
            <p>This is a dynamic dashboard</p>
            <p>
              @if(Auth::user()->role == 1)
                you are admin
              @else
                you are user.
              @endif
            </p>
          </div><!-- sl-page-title -->
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 mb-5">
                        <div class="card-header">Graph</div>
                        <div class="card-body">
                            <canvas id="myChart_1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mt-5 mb-5">
                        <div class="card-header">Graph</div>
                        <div class="card-body">
                            <canvas id="myChart_2"></canvas>
                        </div>
                    </div>
                </div>
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">Header</div>
                  <div class="card-body">
                    <a href="{{ url('send/newsletter') }}" class = "btn btn-success">Send Newsletter to {{ $users_count }} users</a>
                  </div>

                </div>
              </div>
              <div class="col-md-12">
                  @if(session('good_status'))
                    <div class = "alert alert-success">
                        <p>{{ session('good_status') }}</p>
                    </div>
                  @endif
                <div class="card">
                  <div class="card-header">Dashboard
                    <h2>Total Users: {{ $users_count }}</h2>
                  </div>

                  <div class="card-body">
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif

                      <p>
                        {{-- <h1>{{ $users }}</h1> --}}
                        <table class="table table-dark">
                          <thead>
                            <tr>
                              <th scope="col">Serial</th>
                              <th scope="col">Id</th>
                              <th scope="col">Name</th>
                              <th scope="col">Email</th>
                              <th scope="col">Date</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                              $flag = 1;
                            @endphp
                            @foreach($users as $use)
                              <tr>
                                {{-- <td>{{ $flag++ }}</td> --}}
                                {{-- <td>{{ $loop->iteration }}</td> --}}

                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td>{{ $use->id }}</td>
                                <td>{{ Str::title($use->name) }}</td>
                                <td>{{ $use->email }}</td>
                                <td>{{ $use->created_at->format('d/m/Y') }}
                                  <br>
                                  {{ $use->created_at->timezone('Asia/Dhaka')->format('h-i-s A') }}
                                  <br>
                                  {{ $use->created_at->diffForHumans() }}
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        {{ $users->links() }}
                        {{-- @php

                        @endphp --}}
                      </p>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div><!-- sl-pagebody -->
      </div><!-- sl-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->
@endsection
@section('dashboard_chart_1')
      <script>
          var ctx = document.getElementById('myChart_1').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'doughnut',

                // The data for our dataset
                data: {
                    labels: ['paid', 'unpaid', 'cancel'],
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: ['green', 'yellow', 'red'],
                        borderColor: ['green', 'yellow', 'red'],
                        data: [{{ $paid }}, {{ $unpaid }}, {{ $canceled }}]
                    }]
                },

                // Configuration options go here
                options: {}
            });
      </script>
      <script>
          var ctx = document.getElementById('myChart_2').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'pie',

                // The data for our dataset
                data: {
                    labels: ['Total Sale', 'Total Stock Price'],
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: ['green', 'red'],
                        borderColor: ['green', 'red'],
                        data: [{{ $total_sale }}, {{ $total_stock_price }}]
                    }]
                },

                // Configuration options go here
                options: {}
            });
      </script>
@endsection
