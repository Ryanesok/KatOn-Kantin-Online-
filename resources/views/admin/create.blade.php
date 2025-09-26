@extends('layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
    <h2>Tambah Menu Baru</h2>
    <form action="{{ route('admin.menu.store') }}" method="POST">
        @csrf
        @include('admin.partials.form')
    </form>
@endsection