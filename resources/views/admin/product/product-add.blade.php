@section('title', "Dashboard")
@extends('admin.layout.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid bg-white">
        <div class="row py-3">
            <div class="col-4 d-flex justify-content-start"><a href="{{ route('product.index') }}"><i class="fas fa-arrow-left"></i></a></div>
            <div class="col-6 d-flex justify-content-start offset-1"> {{ $product->name }}</div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid bg-white">    
        <form action="{{ route('product.add', $product->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf    
            <div class="row">
                  <div class="col-8 offset-2">
                    <div class="form-group">
                        <label for="">Supplier</label>
                        <select name="supplier_slug" id="supplier" class="form-control">
                          @foreach ($supplier as $s)
                          <option value="{{ $s->id}}" 
                            @if($product->supplier_id === $s->id)
                              selected  
                            @endif
                            >{{ $s->name }}</option>                      
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">Totla Quantity</label>
                        <input type="number" name="total_qty" id="" class="form-control">
                      </div>
                      @error('total_qty')
                      <div class="mb-2">
                        <span class="text-danger font-weight-bold"> {{ $message }}</span>  
                      </div> 
                      @enderror
                      <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                      </div>
                      <input type="submit" value="Submit" class="btn btn-block btn-primary"> 
                  </div>
            </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection