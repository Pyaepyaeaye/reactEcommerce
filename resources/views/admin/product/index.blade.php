@section('title', "Dashboard")
@extends('admin.layout.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div> 
    @endif
    <div class="container-fluid">
      <div class="row d-flex mx-2 justify-content-end">
        <a href="{{ route('product.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i>&nbsp; Create</a> &nbsp;
        <form action="{{ route('product.restore') }}" method="post">         
          @csrf
          <button class="btn btn-primary" type="submit"><i class="fas fa-trash-restore"></i>&nbsp; Restore</button>                 
       </form>
      
      </div>
      <table class="table table-bordered ">
        <thead class="bg-dark">
          <tr>    
            <th>Image</th>    
            <th>Name</th>           
            <th>Quantity</th> 
            <th>Add && Remove</th>         
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($product as $p)
            <tr> 
              <td><img src="{{ asset('/images/product/'.$p->image)}}" alt="" width="100"></td>
              <td>{{ $p->name }}</td>
              <td>{{ $p->total_qty }}</td>
              <td>
                <a href="{{ route('product.add',$p->slug) }}" class="btn btn-primary">+</a>
                <a href="{{ route('product.remove',$p->slug) }}" class="btn btn-danger">-</a>
              </td>
              <td>
                <div class="d-flex justify-content-around">
                  <a href="{{ route('product.edit',$p->slug) }}" class="btn btn-primary"><i class="fas fa-pen"></i>&nbsp; Edit</a>
               
                  <form action="{{ route('product.destroy',$p->id)}}" method="post">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i>&nbsp; Delete</button>                 
                 </form>
                </div>  
              </td>
            </tr>
          @endforeach
        </tbody>        
      </table>
      <div class="row d-fex justify-content-end">
        {{ $product->links() }}
      </div>
      
    </div>     
   

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
@endsection


