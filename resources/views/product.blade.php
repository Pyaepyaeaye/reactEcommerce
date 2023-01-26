@extends('layouts.master')
@section('title','Product')

@section('content')
<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
       
        <div class="col-lg-3 col-md-4">
            <form action="">
                {{-- @csrf --}}
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Category</span></h5>
            <div class="bg-light p-4 mb-30">
                
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="category" class="custom-control-input" checked id="category-all" value="">
                        <label class="custom-control-label" for="category-all">All Category</label>                        
                    </div>         
                    @foreach ($category as $cat)
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="category" class="custom-control-input" id="category-{{ $cat->id }}" value="{{ $cat->name }}">
                        <label class="custom-control-label" for="category-{{ $cat->id }}">{{ $cat->name }}</label>
                        <span class="badge border font-weight-normal">{{ $cat->product_count }}</span>
                    </div>                        
                    @endforeach          
               
            </div>
            <!-- Price End -->
            
            <!-- Color Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
            <div class="bg-light p-4 mb-30">
               
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="color" class="custom-control-input" checked id="color-all" value="">
                        <label class="custom-control-label" for="color-all">All Color</label>                       
                    </div>
                    @foreach ($color as $c )
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="color" class="custom-control-input" id="color-{{ $c->id }}" value="{{ $c->name }}">
                        <label class="custom-control-label" for="color-{{ $c->id }}">{{ $c->name }}</label>                        
                    </div>
                    @endforeach                    
               
            </div>
            <!-- Color End -->

            <!-- Size Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
            <div class="bg-light p-4 mb-30">                
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="size" class="custom-control-input" checked id="size-all" value="">
                        <label class="custom-control-label" for="size-all">All Size</label>                    
                    </div>
                    @foreach ($size as $s)
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" name="size" class="custom-control-input" id="size-{{ $s->id }}" value="{{ $s->name }}">
                        <label class="custom-control-label" for="size-{{ $s->id }}">{{ $s->name }}</label>                        
                    </div>
                    @endforeach 
                
            </div>
            <!-- Size End -->
           
            <button type="submit" class="btn btn-success">Search</button>
          </form>
        </div>
        
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                    <a class="dropdown-item" href="#">30</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($product as $p)
                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src={{ $p->image_url }} alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{ url('/product/'.$p->slug) }}">{{ $p->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $p->buy_price }}</h5><h6 class="text-muted ml-2"><del>{{ $p->sale_price }}</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="col-12">
                    {{ $product->links() }}
                    
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End --> 
@endsection
{{-- @section('script')

<script src="{{ mix('/js/product.js') }}"></script>
@endsection --}}
