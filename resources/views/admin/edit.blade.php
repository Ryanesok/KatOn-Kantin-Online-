@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
    <h2>Edit Menu: {{ $menu->nama }}</h2>
    <form action="{{ route('admin.menu.update', $menu) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.partials.form')
    </form>
@endsection