@extends('layouts.admin')

@section('title', 'Admin Products')
@section('header', 'Product Details')

@section('content')
    @livewire('admin.products.product-details', ['productCode' => $id])
@endsection
