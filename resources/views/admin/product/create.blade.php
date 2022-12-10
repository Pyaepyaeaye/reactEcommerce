@section('title', "Dashboard")
@extends('admin.layout.master')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
  .select2-selection, .select2-selection__arrow {
    height: 40px !important;
  }
</style>
@endsection
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
      <div class="container-fluid bg-white">        
        <form action="{{ route('product.store') }}" method="POST"  enctype="multipart/form-data">
          @csrf
          <div class="row">              
              <div class="col-md-6 col-sm-12">            
               
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
                  <label for="">Image</label>
                  <input type="file" name="image" class="form-control">
                </div>
                @error('image')
                <div class="mb-2">
                  <span class="text-danger font-weight-bold"> {{ $message }}</span>  
                </div>                           
                @enderror
                <div class="form-group">
                  <label for="">Description</label>
                  <textarea name="description" class="form-control" id="description"></textarea>
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
                  <label for="">Buy Price</label>
                  <input type="number" name="buy_price" id="" class="form-control">
                </div>
                @error('buy_price')
                <div class="mb-2">
                  <span class="text-danger font-weight-bold"> {{ $message }}</span>  
                </div> 
                @enderror
                <div class="form-group">
                  <label for="">Sale Price</label>
                  <input type="number" name="sale_price" id="" class="form-control">
                </div>
                @error('sale_price')
                <div class="mb-2">
                  <span class="text-danger font-weight-bold"> {{ $message }}</span>  
                </div> 
                @enderror
                <div class="form-group">
                  <label for="">Discount Price</label>
                  <input type="number" name="discount_price" id="" class="form-control">
                </div>
                @error('discount_price')
                <div class="mb-2">
                  <span class="text-danger font-weight-bold"> {{ $message }}</span>  
                </div>    
                @enderror 
                    
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <label for="">Supplier</label>
                  <select name="supplier_slug" id="supplier" class="form-control">
                    @foreach ($supplier as $s)
                    <option value="{{ $s->id}}">{{ $s->name }}</option>                      
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Category</label>
                  <select name="category_slug" id="category"  class="form-control" >
                    @foreach ($category as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>                      
                    @endforeach
                  </select>
                </div>               
                <div class="form-group">
                  <label for="">Brand</label>
                  <select name="brand_slug" id="brand"  class="form-control">
                    @foreach ($brand as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>                      
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Choose Size</label>
                  <select name="size_slug[]" id="size"  class="form-control" multiple>
                    @foreach ($size as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>                      
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="">Choose Color</label>
                  <select name="color_slug[]" id="color"  class="form-control" multiple>
                    @foreach ($color as $col)
                    <option value="{{ $col->id }}">{{ $col->name }}</option>                      
                    @endforeach
                  </select>
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
@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
  $(document).ready(function() {
    $('#supplier').select2();
    $('#color').select2();
    $('#category').select2();
    $('#brand').select2();
    $('#size').select2();
    $('#description').summernote(
      {
        placeholder: 'Description',
        tabsize: 2,
        height: 100,
        callbacks: {
          onImageUpload: function(files){
            var frmData= new FormData();
            frmData.append('image',files[0]);
            frmData.append('_token',"@php echo csrf_token(); @endphp")
            $.ajax({
              method: 'POST',
              url: '/admin/product-upload',
              contentType: false,
              processData: false,
              data: frmData,
              success: function(data){
                console.log(data)
                $('#description').summernote('insertImage', data);
              }
            })
          }
        }
      }
    );
  });
  
</script>
@endsection