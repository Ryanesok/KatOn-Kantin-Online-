@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
        <h2 style="text-align: center;">Login Kantin Online</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="login">NIM atau Email</label>
                <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('login') }}
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
            </div>
        </form>
    </div>
@endsection