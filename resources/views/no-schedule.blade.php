<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Google Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">
    <title>401 Unauthorized</title>
    <style>
        * {
            font-family: Inter, sans-serif;
        }

        .text-center {
            text-align: center;
        }

        body {
            background: #06172a;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 90vh;
            width: 99vw;
        }

        .code_error {
            font-size: 12em;
            color: white;
            text-shadow: 0px 5px 0px gray;
            margin: 0px;
            padding: 0px;
        }

        .code_text {
            color: white;
            font-size: 2em;
            font-weight: bold;
            text-align: center;
            margin-left: 20px;
        }

        .button_wrapper {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .custom-btn {
            width: auto;
            height: auto;
            color: #fff;
            border-radius: 5px;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
            box-shadow: inset 2px 2px 2px 0px rgba(255, 255, 255, .5),
            7px 7px 20px 0px rgba(0, 0, 0, .1),
            4px 4px 5px 0px rgba(0, 0, 0, .1);
            outline: none;
            padding: 15px;
        }

        /* 1 */
        .btn-1 {
            background: rgb(6, 14, 131);
            background: linear-gradient(0deg, rgba(6, 14, 131, 1) 0%, rgba(12, 25, 180, 1) 100%);
            border: none;
        }
    </style>
</head>

<body>
<div>
    <h1 class="code_error text-center">401</h1>
    <p class="code_text">Sorry but there's no available session or committee meeting for today</p>
    <div class="button_wrapper">
        <button class="custom-btn btn-1">Go Back</button>
    </div>
</div>
</body>

</html>
