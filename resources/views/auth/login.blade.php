<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Welcome to {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('assets-2/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-2/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-2/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Google Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: Inter, sans-serif;
        }
    </style>



</head>

<body class="account-body accountbg">

    <!-- Log In page -->
    <div class="container">

        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">

                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        @if ($errors->any())
                            <div class="alert alert-danger shadow shadow-sm">
                                Check your username or password
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body p-0 auth-header-box">
                                <div class="text-center p-3">
                                    <a href="index.html" class="logo logo-admin">
                                        <img src="{{ asset('assets/tsp.png') }}" height="50" alt="logo"
                                            class="auth-logo">
                                    </a>
                                    <h4 class="mt-3 mb-1 fw-semibold text-white font-18">Let's Get Started
                                        {{ config('app.name') }}</h4>
                                    <p class="text-muted  mb-0">Sign in to continue to {{ config('app.name') }}.</p>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="LogIn_Tab" role="tabpanel">
                                        <form class="form-horizontal auth-form" action="{{ route('login') }}"
                                            method="POST">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-medium text-dark" for="username">Username</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="username" value="admin"
                                                        id="username" placeholder="Enter username" value="{{ old('username') }}">
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label fw-medium text-dark" for="userpassword">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="password" value="christopher"
                                                        id="userpassword" placeholder="Enter password">
                                                </div>
                                            </div>

                                            <div class="form-group row my-3">
                                                <div class="col-sm-6">
                                                    <div class="custom-control custom-switch switch-success">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customSwitchSuccess">
                                                        <label class="form-label text-muted"
                                                            for="customSwitchSuccess">Remember me</label>
                                                    </div>
                                                </div><!--end col-->
                                            </div>

                                            <div class="form-group mb-0 row">
                                                <div class="col-12">
                                                    <button
                                                        class="btn btn-primary w-100 waves-effect waves-light text-uppercase"
                                                        type="submit">SIGN IN</button>
                                                </div><!--end col-->
                                            </div> 
                                        </form><!--end form-->
                                    </div>
                                </div>
                            </div><!--end card-body-->
                            <div class="card-body bg-light-alt text-center">
                                <span class="text-muted d-none d-sm-inline-block">{{ config('app.name') }} ©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>
                                </span>
                            </div>
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->



    <!-- jQuery  -->
    <script src="{{ asset('assets-2/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets-2/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets-2/js/waves.js') }}"></script>
    <script src="{{ asset('assets-2/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets-2/js/simplebar.min.js') }}"></script>
</body>

</html>
