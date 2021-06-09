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
            <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
          </ol>
      </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
         
         @if(auth()->user()->can('user-list'))
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $user_data ?? '0' }}</h3>
                <p>Total Users</p>
              </div>

            </div>
          </div>
          @endif

           @if(auth()->user()->can('category-list'))
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $category_count ?? '0' }}</h3>

                <p>Total Category</p>
              </div>
            </div>
          </div>
          @endif

          @if(auth()->user()->can('product-list'))
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $product_count ?? '0' }}</h3>
                <p>Total Products</p>
              </div>
            </div>
          </div>
          @endif
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <!-- <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div> -->
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
       
      </div><!-- /.container-fluid -->
    </section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')

@endsection
