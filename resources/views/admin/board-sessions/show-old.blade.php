<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $boardSession->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: Inter, sans-serif;
        }

        #page__title {
            font-size: 68px;
        }

        #page__header__container {
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
            position: relative;
            z-index: 1;
            background: #0064ab;
            min-width: 100%;
        }

        #page__header__description {
            font-size: 27px;
        }

        #page__body {
            min-height: 76vh;
            background: url("{{ asset('session/bg.png') }}") center center;
            background-size: cover;
            background-repeat: no-repeat
        }

        #province__logo {
            width: 185px;
            height: 177px;
            border: 12px solid #00306a;
            border-radius: 50%;
            position: relative;
            z-index: 2;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }

        #tsp__logo {
            width: 190px;
            border: 1px solid #00306a;
            padding: 5px;
            border-radius: 50%;
            position: relative;
            z-index: 2;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        }
    </style>
</head>

<body class="d-flex flex-column">
    <div class="d-flex flex-column text-white align-items-center p-4" id="page__header__container">
        <h1 class="fw-bold" id="page__title">OFFICE OF THE PROVINCIAL COUNCIL</h1>
        <p id="page__header__description">Tanggapan ng Sangguniang Panlalawigan | Lalawigan ng Surigao del Sur</p>
    </div>

    <div class="d-flex flex-row justify-content-between align-items-center" style="background : #00306a; height : 4vh;">
        <img src="{{ asset('session/logo.png') }}" class="ms-5" alt="" id="province__logo"
            style="background : #00306a;">
        <img src="{{ asset('session/tsp.png') }}" class="me-5" alt="" id="tsp__logo"
            style="background : #00306a;">
    </div>
    <div id="page__body" style="position:relative; z-index:-9999;">
        &nbsp;
    </div>

</body>

</html>
