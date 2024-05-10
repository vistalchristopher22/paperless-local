<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('favico.ico') }}">

    <link href="/assets-2/libs/litepicker/css/litepicker.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="/new/assets-2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/new/assets-2/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/new/assets-2/css/app.min.css" rel="stylesheet" type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

    <style>
        html,
        body {
            margin: 0px;
            padding: 0px;
        }


        /* * {
            font-family: 'Inter', sans-serif !important;
        } */

        .open-sans {
            font-family: 'Open Sans', sans-serif !important;
        }
    </style>
    @if (str(request()->path())->contains('schedule/schedule/committees/'))
        <style>
            body {
                overflow: hidden;
            }
        </style>
    @endif
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body id="body" class="dark-sidebar">
    <div>
        @inertia
    </div>

    <script src="/new/assets-2/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/new/assets-2/libs/simplebar/simplebar.min.js"></script>
    <script src="/new/assets-2/libs/feather-icons/feather.min.js"></script>
    <script src="/new/assets-2/js/app.js"></script>
</body>

</html>
