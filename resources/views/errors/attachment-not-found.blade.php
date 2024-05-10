<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Attachment not found</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <style>
        body {
            background: url('/assets/tsp-bg.jpg');
        }

        #oopss {
            background: linear-gradient(-45deg, #004409, #0d9920);
            position: fixed;
            opacity: 0.9;
            left: 0px;
            top: 0;
            width: 100%;
            height: 100%;
            line-height: 1.5em;
            z-index: 9999;
        }

        #oopss #error-text {
            font-size: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Shabnam', Tahoma, sans-serif;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            direction: rtl;
        }

        #oopss #error-text img {
            margin: 85px auto 20px;
            height: 342px;
        }

        #oopss #error-text span {
            position: relative;
            font-size: 2em;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 900;
            margin-bottom: 50px;
        }

        #oopss #error-text p.p-a {
            font-size: 19px;
            margin: 30px 0 15px 0;
        }

        #oopss #error-text p.p-b {
            font-size: 15px;
        }

        @font-face {
            font-family: Shabnam;
            src: url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam-Bold.eot");
            src: url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam-Bold.eot?#iefix") format("embedded-opentype"), url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam-Bold.woff") format("woff"), url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam-Bold.woff2") format("woff2"), url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam-Bold.ttf") format("truetype");
            font-weight: bold;
        }

        @font-face {
            font-family: Shabnam;
            src: url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam.eot");
            src: url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam.eot?#iefix") format("embedded-opentype"), url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam.woff") format("woff"), url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam.woff2") format("woff2"), url("https://cdn.rawgit.com/ahmedhosna95/upload/ba6564f8/fonts/Shabnam/Shabnam.ttf") format("truetype");
            font-weight: normal;
        }

        .d-flex {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <div id='oopss'>
        <div id='error-text'>
            <div class="d-flex">
                <img src="/itu.gif" alt="itu logo" style="width : 175px; height : 175px;">
                <img src="/assets/tsp.png" alt="tsp logo" style="width : 240px; height : 220px;">
                <img src="/logo.png" alt="province logo" style="width : 182px; height : 183px;">
            </div>
            <hr>
            <span style="letter-spacing: 1.5px;">
                Attachment not found
            </span>
            <p class="p-a">The attachment you were looking for could not be found</p>
            <p class="p-a">If you continue to experience this issue, please contact the developer for assistance</p>
        </div>
    </div>


    <script>
        document.querySelector('.back').addEventListener('click', function() {
            window.history.back();
        });
    </script>
</body>

</html>
