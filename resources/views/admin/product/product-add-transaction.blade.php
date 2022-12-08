@section('title', "Product")
@extends('admin.layout.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid bg-white">
        <div class="row py-3">
            <div class="col-4 d-flex justify-content-start"><a href="{{ route('product.index') }}"><i class="fas fa-arrow-left"></i></a></div>
            {{-- <div class="col-6 d-flex justify-content-start offset-1"> {{ $product->name }}</div> --}}
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid bg-white"> 
          <div class="row">
            <table  class="table table-bordered ">
              <thead class="bg-dark">
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Buy Date</th>
              </thead>
              <tbody>
                @foreach ($transaction as $t)
                <tr>
                  <td><img src="{{ asset('/images/'.$t->product->image) }}" alt="" width="100"></td>
                  <td>{{  $t->product->name }}</td>
                  <td>{{ $t->total_qty }}</td>
                  <td>{{ $t->description }}</td>
                  <td>{{ $t->created_at }}</td>
                </tr>              
                @endforeach
              </tbody>
            </table>
          </div>   
         
         <div class="row d-fex justify-content-end">
          {{ $transaction->links() }}
        </div>

      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection