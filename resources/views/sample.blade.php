@extends('layouts.app')

@section('content')

<div class="hold-transition sidebar-mini">

@include('header')
@include('sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
             <h2>Create New User</h2>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Users Management</li>
          </ol>
      </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Create New User</h3>

      <div class="card-tools">
        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
      </button>
  </div>
</div>
<div class="card-body">

 <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th style="width: 40px">Role</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1.</td>
                      <td>Update software</td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-danger">55%</span></td>
                    </tr>
                    
                  </tbody>
                </table>

  
</div>

</div>
<!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')

@endsection
