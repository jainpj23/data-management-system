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
           <h2>Edit Product</h2>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
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
      <h3 class="card-title">Edit Product</h3>

      <div class="card-tools">
         <a class="btn btn-sm btn-primary" href="{{ route('products.index') }}"> Back</a>
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
      </button>
  </div>
</div>
<div class="card-body">

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

{!! Form::model($product, ['method' => 'PATCH','enctype'=>'multipart/form-data','route' => ['products.update', $product->id]]) !!}

<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Product Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Product Name','class' => 'form-control')) !!}
        </div>
    </div>

     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Category:</strong>
              <select name="category_id" class="form-control custom-select">
                <option @if($product->category_id=='') selected @endif value="">Select Category</option>
                @foreach($category as $cat)
                  <option @if($product->category_id==$cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
        </div>
    </div>

     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Product price:</strong>
            {!! Form::number('price', null, array('placeholder' => 'Product price','class' => 'form-control','min'=>'0')) !!}
        </div>
    </div>

     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Product Image:</strong>
            {{ Form::file('product_image',  ["class"=>"form-control"]) }}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Description:</strong>
           {!! Form::textarea('description',null,['class'=>'form-control', 'rows' => 2]) !!}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}


  
</div>

</div>
<!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')

@endsection
