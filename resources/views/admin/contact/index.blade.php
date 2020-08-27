@extends('layouts.dashboard_app')

@section('contact')
  active
@endsection
@section('dashboard_content')
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('contact.index') }}">Contact</a>
      <span class="breadcrumb-item active">Contact</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a dynamic dashboard</p>
      </div><!-- sl-page-title -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">Contact Messages</div>
              <div class="card-body">
                <table class="table" id = "data_table">
                  <thead>
                    <tr>
                      <th scope="col">Serial</th>
                      <th scope="col">Id</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Subject</th>
                      <th scope="col">Message</th>
                      <th scope="col">Attachment</th>
                      <th scope="col">Edit</th>
                      <th scope="col">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $flag = 1;
                    @endphp
                    @forelse($active_contacts as $contact)

                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->contact_name }}</td>
                        <td>{{ $contact->contact_email }}</td>
                        <td>{{ $contact->contact_subject }}</td>
                        <td>{{ $contact->contact_message }}</td>
                        <td>
                          @if($contact->contact_attachment)
                            <a href="{{ route('contactDownload', $contact->id) }}"><i class = "fa fa-download"></i></a>|
                            <a target = "_blank" href="{{ asset('storage') }}/{{ $contact->contact_attachment }}"><i class = "fa fa-file"></i></a>
                          @endif
                        </td>
                        <td><a class = "btn btn-info" href="{{ route('contact.edit', $contact->id) }}">Edit</a></td>
                        <td><a class = "btn btn-danger" href="{{ route('contactDelete', $contact->id) }}">Delete</a></td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="50" class = "text-red text-center">no items</td>
                      </tr>
                    @endforelse
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
    @section('footer_script')
      <script type="text/javascript">
        $(document).ready(function() {
          $('#data_table').DataTable({
            "lengthMenu": [4, 5, 6, 7]
          });
        } );
      </script>
    @endsection
