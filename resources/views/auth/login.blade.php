<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Laravel Fortify 2FA</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body {
            background-color: #f4f4f4;
        }
        .container {
            background-color: #FFFFFF;
            font-family: 'Nunito', sans-serif;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <div class="row justify-content-md-center">
            @if($errors->any())
                {!! implode('', $errors->all('<strong class="text-danger">:message</strong>')) !!}
            @endif

            <div class="col-md-6 col-offset-3">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <div class="text-center">
    <a href="{{ route('register') }}" class="text-muted">Not signed up yet?</a>
</div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>