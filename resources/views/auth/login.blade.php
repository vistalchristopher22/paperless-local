<!doctype html>
<html lang="en">

<!-- Head -->

<head>
    <!-- Page Meta Tags-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
        integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Page Title -->
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .main-wrapper {
            background: red;
            height: 100vh;
            width: 100vw;
        }

        #tspHallBackground {
            background: url("{{ asset('assets/tspHallCopy.png') }}") center center;
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
        }

        #tspHallBackground::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            /* background-color: rgba(0, 0, 0, 0.5); */
        }

        .officeOfThe {
            -webkit-font-smoothing: antialiased;
            box-sizing: content-box;
            transform: rotate(0.00deg);
            transform-origin: center;
            opacity: 1;
            cursor: default;
            margin-top: 0.00px;
            margin-right: 0.00px;
            margin-bottom: 0.00px;
            margin-left: 0.00px;
            padding-top: 0.00px;
            padding-right: 0.00px;
            padding-bottom: 0.00px;
            padding-left: 0.00px;
            background-color: rgba(255, 255, 255, 0);
            text-align: left;
            letter-spacing: 21.00px;
            color: rgba(45, 45, 45, 1);
            -webkit-text-stroke: 1.00px rgba(0, 0, 0, 0);
            font-size: 35.00px;
            font-weight: 700;
            font-style: normal;
            font-family: Inter, Arial;
            text-decoration: none;
            box-shadow: none;
            overflow-x: unset;
            overflow-y: unset;
        }


        .provincialCouncil {
            -webkit-font-smoothing: antialiased;
            box-sizing: content-box;
            transform: rotate(0.00deg);
            transform-origin: center;
            opacity: 1;
            cursor: default;
            margin-top: 0.00px;
            margin-right: 0.00px;
            margin-bottom: 0.00px;
            margin-left: 0.00px;
            padding-top: 0.00px;
            padding-right: 0.00px;
            padding-bottom: 0.00px;
            padding-left: 0.00px;
            background-color: rgba(255, 255, 255, 0);
            text-align: left;
            letter-spacing: 0.00px;
            color: rgba(45, 45, 45, 1);
            -webkit-text-stroke: 1.00px rgba(0, 0, 0, 0);
            font-size: 57.00px;
            font-weight: 700;
            font-style: normal;
            font-family: Inter, Arial;
            text-decoration: none;
            box-shadow: none;
            overflow-x: unset;
            overflow-y: unset;
        }

        .input-group-text {
            font-family: 'Inter', sans-serif;
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: white;
            text-align: center;
            white-space: nowrap;
            background-color: rgb(24 129 1);
            border: var(--bs-border-width) solid var(--bs-border-color);
            padding: 1rem !important;
        }
    </style>

</head>

<body>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="container-fluid vh-100">
            <div class="row">
                <div class="col-lg-6 vh-100">
                    {{-- <div class="d-flex">
                        <hr width="180px; ">
                        <span class="mx-3"> or </span>
                        <hr width="180px;">
                    </div> --}}
                    <div class="d-flex" style="padding : 85px;">
                        <div class="container-fluid">

                            <div class="d-flex flex-column justify-content-center align-items-center p-3"
                                style="margin-top : 80px;">
                                <div class="officeOfThe">
                                    OFFICE OF THE</div>
                                <div class="provincialCouncil">PROVINCIAL
                                    COUNCIL</div>
                            </div>

                            {{-- add a error message --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    Invalid Username or Password
                                </div>
                            @endif

                                <div class="mt-5">
                                    <div class="form-group">
                                        <label for="">USERNAME</label>
                                        <div class="input-group input-group-lg">

                                            <input name="username" type="text"
                                                class="form-control form-control-lg p-3 @error('username') is-invalid @enderror"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-lg" value="{{ old('username') }}">
                                        </div>
                                    </div>
                                </div>



                                <div class="mt-5">
                                    <div class="form-group">
                                        <label for="">PASSWORD</label>
                                        <div class="input-group input-group-lg">
                                            <input type="password" name="password"
                                                class="form-control form-control-lg p-3"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-lg">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-block btn-lg mt-5">SIGN
                                        IN</button>
                                </div>

                                {{-- <div class="mt-5">
                                <div class="d-grid">
                                    <button class="btn btn-success btn-lg p-3" style="background : rgb(24 129 1);">SIGN IN</button>
                                </div>
                            </div> --}}

                        </div>
                    </div>

                </div>
                <div class="col-lg-6 vh-100 d-flex align-items-center justify-content-center flex-column"
                    id="tspHallBackground">
                    <img src="{{ asset('assets/tsp.png') }}"
                        style="width : 782px; height : 723px; position:absolute; z-index:9999;" alt="">
                </div>
            </div>

        </div>
    </form>
</body>

</html>
