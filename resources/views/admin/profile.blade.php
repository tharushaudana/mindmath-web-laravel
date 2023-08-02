@extends('admin.admin')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle"
                 src="{{ asset('assets/admin/dist/img/avatar.png') }}"
                 alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

          <p class="text-muted text-center" style="font-size: 12px;">{{ Auth::user()->email }}</p>

          <a href="#" class="btn btn-danger btn-block"><b>Logout</b></a>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="activity">
                <span class="text-muted"><i>Not implemented yet...</i></span>
            </div>
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
@endsection