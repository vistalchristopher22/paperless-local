<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Header</title>
    <style>
        body {
            font-family: Inter, sans-serif;
        }

        .header {
            text-align: center;
            overflow: auto;
            border-top-color: white;
            border-left-color: white;
            border-right-color: white;
            border-bottom: 2px solid gray;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            vertical-align: middle;
            width: 13%;
            height: auto;
            margin-right: 10px; /* Add margin-right */
        }

        .logo-2 {
            vertical-align: middle;
            width: 14.4%;
            height: auto;
            margin-left: 10px; /* Add margin-left */
        }

        .text {
            display: inline-block;
            vertical-align: middle;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-decoration-underline {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="header">
        <img class="logo" src="file:///laragon/www/TSP_LegislateSys/public/session/logo.png" alt="Logo">
        <div class="text">
            <p>Republic of the Philippines</p>
            <p class="fw-bold">PROVINCE OF SURIGAO DEL SUR</p>
            <p>Tandag City</p>
            <p class="fw-bold">TANGGAPAN NG SANGGUNIANG PANLALAWIGAN</p>
            <p>(Office of the Provincial Council)</p>
        </div>
        <img class="logo-2" src="file:///laragon/www/TSP_LegislateSys/public/session/tsp.png" alt="Logo">
    </div>
</body>

</html>
