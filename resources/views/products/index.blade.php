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
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
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
          <h3 class="card-title">Products</h3>

          <div class="card-tools">
            @if(auth()->user()->can('product-create'))
            <a class="btn btn-sm btn-success" href="{{ route('products.create') }}">Add New</a>
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
             <th>Product Name</th>
             <th>Category Name</th>
             <th>Price</th>
             <th>Description</th>
             <th>Image</th>
             @if(auth()->user()->can('product-edit') || auth()->user()->can('product-delete'))
             <th width="280px">Action</th>
             @endif
           </tr>
         </thead>
         <tbody>
          @foreach ($products as $product)
      <tr>
          <td>{{ ++$i }}</td>
          <td>{{ $product->name }}</td>
          <td><a href="javascript:void(0);" data-toggle="modal" data-target="#categorymodal" onclick="getMessage('{{$product->category_id}}')">{{ $product->category->name }}</a></td>
          <td>{{ $product->price  }}</td>
          <td>{{ $product->description }}</td>
          <td><a href="{{ url('/')}}/public/uploads/{{ $product->product_image }}" download=""><img src="{{ url('/')}}/public/uploads/{{ $product->product_image }}" style="width:80px;"></a></td>
          @if(auth()->user()->can('product-edit') || auth()->user()->can('product-delete'))
          <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                   
                    @can('product-edit')
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('product-delete')
                    <button type="submit" class="btn btn-danger" onclick="return confirmbox();">Delete</button>
                    @endcan
                </form>
          </td>
          @endif
      </tr>
      @endforeach

       </tbody>
     </table>


   </div>

   <div class="card-footer clearfix">
            {!! $products->links('pagination::bootstrap-4') !!}
    </div>

 </div>
 <!-- /.card -->


  <!-- Modal -->
  <div class="modal fade" id="categorymodal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Category Detail</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="category_body">
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- end modal -->

 
<script>
  function getMessage(id) {
    if(id !=''){
        $.ajax({
         type:'POST',
         url:BASE_URL+'/get_category_detail',
         data:{'row_id':id,'_token':'<?php echo csrf_token() ?>'},
         success:function(data) {
          $("#category_body").html(data);
        }
      });
    }
  }
</script>



</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('footer')

@endsection
