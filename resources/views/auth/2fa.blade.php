@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Two-Factor Authentication</h3>
    <form method="POST" action="{{ route('2fa.verify.post') }}">
        @csrf
        <div class="form-group">
            <label for="code">Enter the 6-digit code sent to your email:</label>
            <input type="text" name="code" id="code" class="form-control" required autofocus>
            @error('code')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Verify</button>
    </form>
</div>
@endsection