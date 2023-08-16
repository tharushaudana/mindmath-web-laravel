@extends('student.student-dashboard')

@section('pagename', 'Profile')

@section('content')

<div class="card shadow-lg mt-8 card-profile-bottom">
    <div class="card-body p-3">
      <div class="row gx-4">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
            <img src="{{ asset('assets/student/images/student.png') }}" alt="profile_image" class="w-100 border-radius-lg rounded-circle shadow-sm">
          </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">
              {{ $me->name }}
            </h5>
            <p class="mb-0 font-weight-bold text-sm">
              {{ $me->grade->name }}
            </p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3" style="display: none;">
          <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-1" role="tablist">
              <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                  <i class="ni ni-app"></i>
                  <span class="ms-2">App</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                  <i class="ni ni-email-83"></i>
                  <span class="ms-2">Messages</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                  <i class="ni ni-settings-gear-65"></i>
                  <span class="ms-2">Settings</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-8 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0">Edit Profile</p>
          </div>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <p class="text-uppercase text-sm">User Information</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Fullname</label>
                      <input class="form-control" type="text" name="name" value="{{ $me->name }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Email address</label>
                      <input class="form-control" type="email" value="{{ $me->email }}" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="example-text-input" class="form-control-label">Grade</label>
                      <select class="form-control" name="grade">
                          @foreach ($grades as $g)
                              <option value="{{ $g->id }}" {{ $g->id == $me->grade->id ? 'selected' : '' }}>{{ $g->name }}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary btn-sm ms-auto mt-4">Update</button>
            </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-profile">
        <div class="card-header text-center border-0 mt-2 pt-lg-2 pb-4 pb-lg-3">
          <h4>Activities</h4>
        </div>
        <div class="card-body pt-0">
            <p class="text-muted" align="center">Comming soon...</p>
        </div>
      </div>
    </div>
  </div>

@endsection