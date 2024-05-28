<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link href="{{ asset('/assets-2/css/style_session.css') }}" rel="stylesheet">
    <meta content="{{ $serverSocketUrl }}" name="server-socket-url">
    <style>
        * {
            font-family: Arial, sans-serif !important;
            font-style: normal;
            font-size: {{ $fontSize }}vw;
        }

        body {
            background: url({{ asset('/tsp-bg.jpg') }}) no-repeat fixed center center/cover;
            background-size: cover;
            overflow: hidden;
            overflow-y: scroll;
        }

        .chairman-title {
            font-size: {{ $chairmanNameFontSize }}vw;
        }

        .member-title {
            font-size: {{ $membersNameFontSize }}vw;
        }

        .border-primary {
            border-color: #347c00 !important;
        }

        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        .letter-spacing-2 {
            letter-spacing: 2px;
        }


        .text-primary {
            color: #347c00 !important;
        }
    </style>
    <style>
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

        #screen-display-table {
            background: #143500;
            color: white;
        }

        table tr {
            border: 10px solid #143500;
        }
    </style>
</head>

<body>


    <div class="table-responsive p-2">
        <table id="screen-display-table" class="table">
            <tbody>
                <tr class="">
                    <th class="bg-primary align-middle text-start text-uppercase">
                        <span class="mx-3">Title</span>
                    </th>
                    <th class="bg-primary align-middle text-center text-uppercase">Chairman</th>
                    <th class="bg-primary align-middle text-center text-uppercase text-truncate">Vice Chairman</th>
                </tr>
                @foreach ($data as $record)
                    <tr>
                        <td
                            class="align-middle w-50 fw-medium bg-success
                        @if (strtolower($record->status->value) == 'on_going') bg-light text-dark @endif">
                            {{ $loop->index + 1 }}.

                            {{ $record->screen_displayable?->lead_committee_information->title }}
                        </td>
                        <td
                            class="align-middle text-truncate text-start bg-success   @if (strtolower($record->status->value) == 'on_going') bg-light text-dark @endif">
                            <span class="mx-4"></span>
                            {{ $record->screen_displayable?->lead_committee_information?->chairman_information?->fullname }}
                        </td>
                        <td
                            class="align-middle text-truncate text-start bg-success   @if (strtolower($record->status->value) == 'on_going') bg-light text-dark @endif">
                            <span class="mx-4"></span>
                            {{ $record->screen_displayable?->lead_committee_information?->vice_chairman_information?->fullname }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
    </div>


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
            <span class="text-dark fw-bold text-white text-uppercase letter-spacing-1 font-inter">
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
        const id = "{{ $id }}";
        let serverSocketUrl = document
            .querySelector('meta[name="server-socket-url"]')
            ?.getAttribute("content");


        let socket = io(serverSocketUrl);
        let dataToPresent = @json(@$dataToPresent);

        function formatTwoDigits(value) {
            return value < 10 ? `0${value}` : value;
        }

        function updateElapsedTime(startTime) {
            const currentTime = new Date();
            const startDate = new Date(startTime);

            const elapsedTime = new Date(currentTime - startDate);

            const hours = formatTwoDigits(elapsedTime.getUTCHours());
            const minutes = formatTwoDigits(elapsedTime.getUTCMinutes());
            const seconds = formatTwoDigits(elapsedTime.getUTCSeconds());

            document.getElementById('elapsed-time').textContent = `${hours}:${minutes}:${seconds}`;
        }

        if (dataToPresent && dataToPresent.start_time && !dataToPresent.end_time) {
            setInterval(() => updateElapsedTime(dataToPresent.start_time), 1000);
        }


        socket.on('SCREEN_TIMER_START', function() {
            if (!dataToPresent.start_time) {
                $.ajax({
                    url: `/api/screen/start/${dataToPresent.id}`,
                    method: 'PUT',
                    success: function(response) {
                        dataToPresent.start_time = response.start_time;
                        document.querySelector('#startTime').innerText = moment(response.start_time)
                            .format("hh:mm A");
                        setInterval(() => updateElapsedTime(response.start_time), 1000);
                    },
                    error: function(response) {
                        location.reload();
                    }
                });
            }
        });


        function startCountdown(duration) {
            let timeRemaining = duration;
            let countdownInterval = setInterval(function() {
                timeRemaining--;

                if (timeRemaining <= 0) {
                    location.href = '/screen/' + id;
                    clearInterval(countdownInterval);
                }
            }, 1000);
        }
        startCountdown(60);

        socket.on('SCREEN_TIMER_END', function() {
            if (dataToPresent.start_time) {
                $.ajax({
                    url: `/api/screen/end/${dataToPresent.id}`,
                    method: 'PUT',
                    success: function(response) {
                        location.reload();
                    },
                    error: function(response) {
                        location.reload();
                    }
                });
            }
        });

        socket.on('TRIGGER_REFRESH_ON_CLIENTS', function() {
            location.reload();
        });
    </script>
    <script>
        $(".marque_texts").html();

        function checkTime(i) {
            if (10 > i) {
                i = "0" + i
            };
            return i;
        }

        function hour(hh) {
            if (0 == hh) {
                hh = "12"
            };
            return hh;
        }
    </script>
    <script>
        const INTERVAL_MOVE_UP = 800;

        $(function() {
            var tickerLength = $('.containers1 ul li').length;
            var tickerHeight = $('.containers1 ul li').outerHeight();
            $('.containers1 ul li:last-child').prependTo('.containers1 ul');
            $('.containers1 ul').css('marginTop', -tickerHeight);

            function moveTop() {
                $('.containers1 ul').animate({
                    top: -tickerHeight
                }, 300, function() {
                    $('.containers1 ul li:first-child').appendTo('.containers1 ul');
                    $('.containers1 ul').css('top', '');
                });
            }

            setInterval(function() {
                moveTop();
            }, 4500);
        });

        $(function() {
            var tickerLength = $('.containers2 ul li').length;
            var tickerHeight = $('.containers2 ul li').outerHeight();
            $('.containers2 ul li:last-child').prependTo('.containers2 ul');
            $('.containers2 ul').css('marginTop', -tickerHeight);

            function moveTop() {
                $('.containers2 ul').animate({
                    top: -tickerHeight
                }, 300, function() {
                    $('.containers2 ul li:first-child').appendTo('.containers2 ul');
                    $('.containers2 ul li:first-child').removeClass('bg-primary').removeClass('text-white');
                    $('.containers2 ul li:first-child').next().addClass('bg-primary').addClass(
                        'text-white');
                    $('.containers2 ul').css('top', '');
                });
            }

            setInterval(function() {
                moveTop();
            }, 4000);
        });
        $(function() {
            var tickerLength = $('.containers3 ul li').length;
            var tickerHeight = $('.containers3 ul li').outerHeight();
            $('.containers3 ul li:last-child').prependTo('.containers3 ul');
            $('.containers3 ul').css('marginTop', -tickerHeight);

            function moveTop() {
                $('.containers3 ul').animate({
                    top: -tickerHeight
                }, 300, function() {
                    $('.containers3 ul li:first-child').appendTo('.containers3 ul');
                    $('.containers3 ul').css('top', '');
                });
            }

            setInterval(function() {
                moveTop();
            }, 3800);
        });
        $(function() {
            var tickerLength = $('.containers4 ul li').length;
            var tickerHeight = $('.containers4 ul li').outerHeight();
            $('.containers4 ul li:last-child').prependTo('.containers4 ul');
            $('.containers4 ul').css('marginTop', -tickerHeight);

            function moveTop() {
                $('.containers4 ul').animate({
                    top: -tickerHeight
                }, 300, function() {
                    $('.containers4 ul li:first-child').appendTo('.containers4 ul');
                    $('.containers4 ul').css('top', '');
                });
            }

            setInterval(function() {
                moveTop();
            }, 3800);
        });
    </script>
</body>

</html>
