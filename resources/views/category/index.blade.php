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
            <h1>Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
    @endif


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Category</h3>

          <div class="card-tools">
            @if(auth()->user()->can('category-create'))
            <a class="btn btn-sm btn-success" href="{{ route('category.create') }}">Add New</a>
            @endif
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
             <th>No</th>
             <th>Category Name</th>
             <th>Description</th>
             @if(auth()->user()->can('category-edit') || auth()->user()->can('category-delete'))
             <th width="280px">Action</th>
             @endif
           </tr>
         </thead>
         <tbody>
          @foreach ($data as $key => $user)
          <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->description }}</td>

            @if(auth()->user()->can('category-edit') || auth()->user()->can('category-delete'))
            <td>
             @if(auth()->user()->can('category-edit'))
             <a class="btn btn-primary" href="{{ route('category.edit',$user->id) }}">Edit</a>
             @endif

             @if(auth()->user()->can('category-delete'))

             {!! Form::open(['method' => 'DELETE','route' => ['category.destroy', $user->id],'style'=>'display:inline']) !!}
             <button type="submit" name="submit" class="btn btn-danger" onclick="return confirmbox();">Delete</button>
             {!! Form::close() !!}

             @endif

           </td>
           @endif
         </tr>
         @endforeach

       </tbody>
     </table>

   </div>

   <div class="card-footer clearfix">
             {!! $data->links('pagination::bootstrap-4') !!} 
    </div>

 </div>
 <!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')

@endsection
