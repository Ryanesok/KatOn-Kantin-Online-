@extends('layouts.app')

@section('title', 'Tambah Menu Baru')

@section('content')
    <h2>Tambah Menu Baru</h2>

    <form action="{{ route('admin.menu.store') }}" method="POST">
        @csrf
        @include('admin.partials.form')
        <div class="form-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection
