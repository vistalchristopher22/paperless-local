@php use App\Enums\ScheduleType; @endphp

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link href="{{ asset('/assets-2/css/style_session.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
            font-size: {{ $fontSize }}vw;
        }

        .chairman-title {
            font-size: {{ $chairmanNameFontSize }}vw;
        }

        .member-title {
            font-size: {{ $membersNameFontSize }}vw;
        }

        .bg-primary {
            background: #347c00 !important;
            background-color: #347c00 !important;
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
    </style>
</head>

<body>
    <div class="d-flex flex-column">

        <div class="table-responsive">
            <table id="screen-display-table" class="table table-hover border">
                <thead>
                    <tr>
                        <th class="p-3 text-center bg-light border text-uppercase">#</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Title</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Chairman</th>
                        <th class="p-3 text-center bg-light border text-uppercase text-truncate">Vice Chairman</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Status</th>
                        <th class="p-3 text-center bg-light border text-uppercase">Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $record)
                        <tr data-id="{{ $record->id }}">
                            <td
                                class="p-3 text-center fw-bold {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                {{ $record->index }}</td>
                            <td
                                class="p-3 {{ $loop->index == 0 ? 'fw-bold bg-primary border-primary text-white text-truncate' : 'text-truncate' }}">
                                @if ($record?->type === ScheduleType::MEETING->value)
                                    {{ $record->screen_displayable?->lead_committee_information->title }}
                                    / {{ $record->screen_displayable?->expanded_committee_information?->title }}
                                    {{ $record->screen_displayable?->other_expanded_committee_information?->title }}
                                @else
                                    ORDER OF BUSINESS
                                @endif
                            </td>
                            <td
                                class="p-3 {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white text-truncate' : '' }}">
                                @if ($record?->type === ScheduleType::MEETING->value)
                                    {{ $record->screen_displayable?->lead_committee_information?->chairman_information?->fullname }}
                                @else
                                    -
                                @endif
                            </td>
                            <td
                                class="p-3 {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                @if ($record?->type === ScheduleType::MEETING->value)
                                    {{ $record->screen_displayable?->lead_committee_information?->vice_chairman_information?->fullname }}
                                @else
                                    -
                                @endif
                            </td>
                            <td
                                class="p-3 text-center fw-bold text-uppercase  text-truncate {{ $loop->index == 0 ? 'fw-bold bg-primary border border-primary text-white' : '' }}">
                                {{ Str::headline($record->status) }}</td>
                            <td class="text-center">{{ $record?->start_time?->format('h:i A') }} -
                                {{ $record?->end_time?->format('h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="bg-primary mt-auto fixed-bottom">
            <div class="scroll-container">
                <div class="scroll-text text-white fw-bold">
                    <img src="{{ asset('/assets-2/images/logo-screen/logo.png') }}" class="img-fluid " width="2.5%"
                        alt="">
                    <span
                        class="text-white fw-bold text-uppercase letter-spacing-1">{{ $data?->first()?->reference_session?->number }}
                        REGULAR SESSION @ {{ $data?->first()->schedule?->venue }} |
                        {{ $data?->first()->schedule?->first()?->date_and_time->format('F d, Y') }}<img
                            src="{{ asset('/assets-2/images/logo-screen/logo2.png') }}" class="img-fluid "
                            width="3%" alt="" /> | {{ $announcement }} </span>
                    <span class="text-uppercase"> | Powered by : PADMO-ITU</span>
                </div>
            </div>
        </div>
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
