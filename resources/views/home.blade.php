@extends('layouts.master')
@section('title','Home')
@section('content')
    <div id="root"></div>
@endsection
@section('script')
<script src="{{ mix('/js/home.js') }}"></script>
@endsection
