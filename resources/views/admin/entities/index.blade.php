@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Dashboard')

@section('content')

    @livewire('admin.entity.entity-list') <!-- This should work now -->

@endsection
