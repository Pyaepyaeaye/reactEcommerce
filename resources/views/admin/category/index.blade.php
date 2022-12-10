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
            <h1 class="m-0">Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
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
        <a href="{{ route('category.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i>&nbsp; Create</a> &nbsp;
        <form action="{{ route('category.restore') }}" method="post">         
          @csrf
          <button class="btn btn-primary" type="submit"><i class="fas fa-trash-restore"></i>&nbsp; Restore</button>                 
       </form>
      
      </div>
      <table class="table table-bordered ">
        <thead class="bg-dark">
          <tr>       
            <th>Name</th> 
            <th>MM Name</th>  
            <th>Image</th>         
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($category as $c)
            <tr>           
              <td>{{ $c->name }}</td>
              <td>{{ $c->mm_name }}</td>
              <td><img src="{{ asset('images/category/'. $c->image) }}" alt="" width="100"></td>
              <td>
                <div class="d-flex justify-content-around">
                  <a href="{{ route('category.edit',$c->slug) }}" class="btn btn-primary"><i class="fas fa-pen"></i>&nbsp; Edit</a>
               
                  <form action="{{ route('category.destroy',$c->id)}}" method="post">
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
        {{ $category->links() }}
      </div>
      
    </div>     
   

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
@endsection


