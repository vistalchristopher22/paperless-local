<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link href="{{ asset('/assets-2/css/style_session.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.rawgit.com/Nicholaiii/Aileron/71e6623b2b67e380977d234a0d64c1fdcf223781/">
    <meta content="{{ $serverSocketUrl }}" name="server-socket-url">
    <style>
        * {
            font-family: "Aileron", sans-serif !important;
            font-style: normal;
            font-weight: bold;
            font-size: {{ $fontSize }}vw;
        }

        body {
            background: url({{ asset('/tsp-bg.jpg') }}) no-repeat fixed center center/cover;
            background-size: cover;
            /*background-size: 30% 100%;*/
            /*background-color: #fbfcfe;*/
            overflow: hidden;
        }

        .font-inter {
            font-family: Inter, sans-serif;
        }

        .bg-primary {
            background: #143500 !important;
            background-color: #143500 !important;
        }

        .bg-primary-2 {
            background: #347c00 !important;
            background-color: #347c00 !important;
        }


        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        .text-primary {
            color: #347c00 !important;
        }

        .text-primary-dark {
            color: #143500 !important;
        }

        .scroll-container {
            width: 100%;
            overflow: hidden;
        }

        .scroll-text {
            white-space: nowrap;
            animation: scroll {{ $announcementRunningSpeed }}s linear infinite;
        }

        @keyframes scroll {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .font-weight-600 {
            font-weight: 600;
        }

        div.title-text {
            font-family: Arial, Tahoma !important;
        }


        div.title-text> :last-child {
            transform: rotatex(180deg) translatey(15px);
            -webkit-mask-image: linear-gradient(transparent 40%, white 90%);
            mask-image: linear-gradient(transparent 50%, white 90%);
            opacity: 0.7;

        }

        .logo-flip {
            display: inline-block;
            animation: flip 10s 0s linear infinite;
        }

        @keyframes flip {
            0% {
                transform: rotateY(0deg);
            }

            50% {
                transform: rotateY(180deg);
            }

            100% {
                transform: rotateY(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="w-100 vh-100 d-flex flex-column align-items-center justify-content-center container">
        <div class="d-flex flex-row align-items-center justify-content-around mb-3">
            <div>
                <img src="{{ asset('/assets/tsp.png') }}" style="width : 6.5%;" alt="">
                <span class="text-uppercase text-white">
                    {{ $data['reference_session'] }}
                    {{ $data['type'] }}
                </span>
            </div>
        </div>
        <div class="align-items-center justify-content-center text-center">
            <div>
                <span class="fs-2 text-white text-uppercase text-center">
                    Question / Visitors’ Hour</span>
            </div>
            <div class="{{ empty($guestFullName) ? 'd-none' : '' }}">
                <hr style="color: white; border: none; height: 10px; background-color:white;">
            </div>

            <div class="text-center {{ empty($guestFullName) ? 'd-none' : '' }}">
                <p class="fw-bolder fw-medium text-uppercase text-white fs-2" style="letter-spacing : 2px;">
                    {!! nl2br(str_replace('|', "\n", $guestFullName)) !!}
                </p>
            </div>
        </div>
    </div>
    {{-- <div class="">
        <div class="col-lg-12 bg-primary d-flex justify-content-between align-items-center">
            <img src="{{ asset('/assets/tsp.png') }}" class="img-fluid" width="5%" alt="">
            <span class="text-uppercase text-white h2 mt-1" style="letter-spacing : 2px;">
                Question/Visitors’ Hour
            </span>
            <img src="{{ asset('/logo.png') }}" class="img-fluid me-1" width="4.3%" alt="">
        </div>
        <div class="row mt-5">
            <div
                class="col-lg-12 d-flex flex-row align-items-center justify-content-center border border-top-0 border-right-0 border-bottom-0">
                <img src="{{ asset('/assets/tsp.png') }}"
                    class="img-fluid {{ empty($guestFullName) ? 'border-0' : '' }}"
                    style="width:40vw;border:6px solid black; border-left:0; border-top:0; border-bottom:0;"
                    alt="">
                <div
                    class="d-flex flex-column align-items-center justify-content-center ms-3 {{ empty($guestFullName) ? 'd-none' : '' }}">
                    <p class="fw-bold text-uppercase  h1" style="letter-spacing : 2px;">
                        {{ $guestFullName }}
                    </p>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="bg-primary mt-auto fixed-bottom d-flex">
        <div class="bg-primary-2"
            style="position:relative; z-index:9999; width:30%; height :fit-content; bottom:0%; right :0%; top:0%; left :0;">
            <div class="d-flex align-items-center mx-1">
                <span class="font-inter fw-bold text-white">
                    POWERED BY : PADMO-ITU
                </span>
                <img src="{{ asset('/itu.gif') }}" class="img-fluid mx-1" width="8.5%" style="padding : 3px;"
                    alt="" />
            </div>
        </div>
        <marquee onmouseover="this.stop();" onmouseout="this.start();" direction="left" behavior="scroll"
            scrollamount="{{ $announcementRunningSpeed }}"
            style="position:absolute; bottom : 0%; right : 0%; left :30.1%;">
            <span
                class="text-dark fw-bold text-white text-uppercase letter-spacing-1 font-inter">{{ $data['reference_session'] }}
                {{ $data['type'] }}
                @if (!empty($announcement))
                    |
                    {{ $announcement }}
                @endif
            </span>
        </marquee>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.6.1/socket.io.min.js"
        integrity="sha512-AI5A3zIoeRSEEX9z3Vyir8NqSMC1pY7r5h2cE+9J6FLsoEmSSGLFaqMQw8SWvoONXogkfFrkQiJfLeHLz3+HOg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        let serverSocketUrl = document
            .querySelector('meta[name="server-socket-url"]')
            ?.getAttribute("content");


        let socket = io(serverSocketUrl);

        socket.on('UPDATE_SCREEN_DISPLAY', (data) => {
            window.location.href = data.url;
        });


        socket.on('TRIGGER_REFRESH_ON_CLIENTS', function() {
            location.reload();
        });
    </script>

</body>

</html>
