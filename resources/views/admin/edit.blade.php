@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
    <h2>Edit Menu</h2>

    <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" class="form-wrapper">
        @csrf
        @method('PUT')
        @include('admin.partials.form')
        <div class="form-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection
