<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dist/css/adminlte.min2167.css?v=3.2.0') }}/">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
    <div class="login-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-12">
                    <div class="card-login">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title text-uppercase">Register to our Blog</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('RegisterUser') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="far fa-envelope"></i></span>
                                                    </div>
                                                    <input type="text" id="email" value="{{ old('email') }}"
                                                        name="email" class="form-control" />
                                                </div>
                                            </div>
                                            @error('email')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="far fa-user"></i></span>
                                                    </div>
                                                    <input type="text" value="{{ old('username') }}" id="username"
                                                        name="username" class="form-control" />
                                                </div>
                                            </div>
                                            @error('username')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="far fa-user"></i></span>
                                                    </div>
                                                    <input type="text" value="{{ old('first_name') }}"
                                                        id="first_name" name="first_name" class="form-control" />
                                                </div>
                                            </div>
                                            @error('first_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="far fa-user"></i></span>
                                                    </div>
                                                    <input type="text" id="last_name" value="{{ old('last_name') }}"
                                                        name="last_name" class="form-control" />
                                                </div>
                                            </div>
                                            @error('last_name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-eye"></i></span>
                                                    </div>
                                                    <input type="password" id="password" name="password"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label>Confirmed Password</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-eye"></i></span>
                                                    </div>
                                                    <input type="password" name="confirmed_password"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-right text-underline">
                                                <input type="submit" class="btn btn-primary" value="Register">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="text-left">
                                                <p><u><a href="{{ route('Login') }}">Login</a></u></p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
