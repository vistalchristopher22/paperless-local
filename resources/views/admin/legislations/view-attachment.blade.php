<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles.mine280.css?v=0eb413625a') }}">

    <style>

        :root {
            --ghost-accent-color: #04142c;
        }

        * {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        body {
            height : 100vh;
            width : 100vw;
        }


        .sidebar-nav > ul > li > a {
            font-weight: normal;
            letter-spacing: 1.5px;
        }

        ol {
            list-style: none;
        }

        .show {
            opacity: 1;
            transition: opacity 300ms ease-in-out;
        }
    </style>
</head>
<body>
<main>
    <section class="content" style="background: #f2f3f6; margin:0px;">
        <embed src="{{ $viewURL }}#zoom=190&toolbar=0" allowfullscreen="true"
               allowtransparency="true" style="width : 100vw; height : 100vh;">
    </section>
</main>

<script type="text/javascript" src="{{ asset('scripts.mine280.js?v=0eb413625a') }}"></script>
</body>
</html>
