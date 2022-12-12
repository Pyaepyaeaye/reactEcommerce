@extends('layouts.master')
@section('title','Home')
@section('content')
<div id="root"></div>    
@endsection
@section('script')
<script>
    window.product_slug = "{{ $slug }}"
</script>
<script src="{{ mix('/js/productDetail.js') }}"></script>
@endsection
