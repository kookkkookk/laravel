@extends('layouts.default')
@section('content')
  @foreach ($products as $product)
    <div>{{ $product->title }}</div>
    <div>{{ $product->content }}</div>
    <div>{{ $product->price }}</div>
    <hr>
  @endforeach
@endsection