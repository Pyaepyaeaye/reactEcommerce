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
      <div class="container-fluid bg-white">        
          <div class="row">
            <div class="col-6 offset-3">
            <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" id="" class="form-control">
              </div>
              @error('name')
              <div class="mb-2">
                <span class="text-danger font-weight-bold"> {{ $message }}</span>  
              </div>                           
              @enderror
              <div class="form-group">
                <label for="">Myanmar Name</label>
                <input type="text" name="mm_name" id="" class="form-control">
              </div>
              @error('mm_name')
              <div class="mb-2">
                <span class="text-danger font-weight-bold"> {{ $message }}</span>  
              </div>                           
              @enderror
              <div class="form-group">
                <label for="">Myanmar Name</label>
                <input type="file" name="image" id="" class="form-control">
              </div>
              @error('image')
              <div class="mb-2">
                <span class="text-danger font-weight-bold"> {{ $message }}</span>  
              </div>                           
              @enderror
              <input type="submit" value="Submit" class="btn btn-block btn-primary">
            </form>
          </div>
        </div>        
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection