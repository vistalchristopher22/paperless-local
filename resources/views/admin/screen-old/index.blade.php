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
    {{--    <div class="container-fluid bg-primary d-flex align-items-center justify-content-between p-0">--}}
    {{--        <img src="{{ asset('/assets-2/images/logo-screen/logo.png') }}" class="img-fluid mx-2" width="5%" alt="">--}}
    {{--        <span class="text-white fw-bold text-uppercase letter-spacing-1">{{ $data['number'] }} REGULAR SESSION</span>--}}
    {{--            <img src="{{ asset('/assets-2/images/logo-screen/logo2.png') }}" class="img-fluid mx-2" width="6.5%" alt=""/>--}}
    {{--    </div>--}}
    @isset($dataToPresent)
        <div
            class="bg-primary text-white  p-0 d-flex justify-content-between text-center"
            style="border : 4px solid #f2f3f6; border-right :0px; border-left : 0px; border-top: 0px; border-collapse : collapse;">
            @if($dataToPresent?->schedule?->type == 'session')
                <div class="mx-2">
                    <span class="letter-spacing-1">&nbsp;</span>
                </div>
            @else
                <div class="mx-2">
                <span
                    class="text-uppercase fw-bold letter-spacing-1">{{ $dataToPresent?->screen_displayable?->lead_committee_information?->title }}</span>
                </div>
            @endif
            <div class="mx-2">
                <span id="startTime" class="fw-bold">{{ $dataToPresent?->start_time?->format('h:i A - ') }}</span>
                <span id="elapsed-time" class="fw-bold">00:00:00</span>
            </div>
        </div>
        {{-- PRESENT DATA --}}
        <div class="container-fluid d-flex align-items-center justify-content-between p-0">
            @if($dataToPresent?->schedule?->type != 'session')
                <table class="table table-bordered">
                    <tr>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            width="36%"
                            style="letter-spacing : 1px;">
                            Chairman
                        </th>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            style="letter-spacing : 1px;">Vice Chairman
                        </th>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            style="letter-spacing : 1px;">Invited Guest
                        </th>
                    </tr>
                    <tr>
                        <th class="p-0 text-center align-middle" style="border-right : 5px solid #f2f3f6;" rowspan="4">
                            <div class="d-flex flex-column justify-content-around align-items-center">
                                <img
                                    src="{{ asset('storage/user-images/' .  $dataToPresent?->screen_displayable?->lead_committee_information?->chairman_information?->profile_picture) }}"
                                    class="mt-1 rounded" width="50%" alt="">
                                <span
                                    class="text-uppercase text-primary fw-bold chairman-title">{{ $dataToPresent?->screen_displayable?->lead_committee_information?->chairman_information->fullname }}</span>
                            </div>
                        </th>
                        <td class="align-middle text-center">
                    <span class="text-uppercase text-primary fw-bold chairman-title">
                        @if(method_exists($dataToPresent->screen_displayable, 'lead_committee_information'))
                            {{ $dataToPresent?->screen_displayable?->lead_committee_information?->vice_chairman_information->fullname }}
                        @endif
                    </span>
                        </td>
                        <td headers="co1 c1 text-truncate" rowspan="4">
                            <div class="containers2 p-0 mt-1">
                                <ul>
                                    @if($dataToPresent?->schedule?->guests->count() == 1)
                                        @foreach($dataToPresent?->schedule?->guests as $guest)
                                            <li class="font-weight-600">
                                                {!! generateHTMLSpace(1) !!}{{ $guest->fullname }}
                                            </li>
                                            <li class="font-weight-600">
                                                {!! generateHTMLSpace(1) !!}{{ $guest->fullname }}
                                            </li>
                                        @endforeach
                                    @else
                                        @foreach($dataToPresent?->schedule?->guests as $key => $guest)
                                            <li class="text-start font-weight-600">
                                                {!! generateHTMLSpace(1) !!}{{ Str::limit($guest->fullname, 19, '.') }}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-uppercase text-center align-middle bg-primary border border-primary text-white letter-spacing-1 p-0">
                            Members
                        </th>
                    </tr>
                    <tr>
                        <td rowspan="2" class="p-0 text-truncate" style="border-right : 5px solid #f2f3f6;">
                            <br>
                            <div class="containers3">
                                <ul>
                                    @if(method_exists($dataToPresent->screen_displayable, 'lead_committee_information'))
                                        @foreach($dataToPresent?->screen_displayable?->lead_committee_information?->members as $member)
                                            @foreach($member->sanggunian_member as $m)
                                                <li>
                                                    {!! generateHTMLSpace(1) !!}
                                                    <span class="text-uppercase fw-bold">{{ $m->fullname }}</span>
                                                    <br>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>
            @else
                <table class="table table-bordered">
                    <tr>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            width="36%"
                            style="letter-spacing : 1px;">
                            &nbsp;
                        </th>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            style="letter-spacing : 1px;">
                            &nbsp;
                        </th>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            style="letter-spacing : 1px;">
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <th class="p-1 text-center align-middle" colspan="3" rowspan="4">
                            <div class="d-flex flex-column justify-content-around align-items-center letter-spacing-2 text-primary p-3">
                                <img src="{{ asset('/assets-2/images/logo-screen/logo2.png') }}" alt="">
                                <span class="fs-4 fw-bolder">ORDER OF BUSINESS</span>
                            </div>
                        </th>
                    </tr>
                </table>
            @endif
        </div>
        {{-- END OF PRESENT DATA --}}
    @endisset

    @isset($upNextData)
        <div class="bg-light p-0 d-flex justify-content-between text-center">
            @if($upNextData?->schedule?->type == 'session')
                <div class="mx-2">
                    <span class="letter-spacing-1">&nbsp;</span>
                </div>
            @else
                <div class="mx-2">
                <span
                    class="text-uppercase fw-bold letter-spacing-1">UPCOMING : {{ $upNextData?->screen_displayable?->lead_committee_information?->title }}</span>
                </div>
            @endif
        </div>

        <div class="container-fluid mb-0 pb-0 d-flex align-items-center justify-content-between p-0">
            <table class="table table-bordered">
                <tr>
                    <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white" width="36%"
                        style="letter-spacing : 1px;">
                        Chairman
                    </th>
                    <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                        style="letter-spacing : 1px;">Vice Chairman
                    </th>
                    <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                        style="letter-spacing : 1px;">Invited Guest
                    </th>
                </tr>
                <tr>
                    <th class="p-0 text-center align-middle" style="border-right : 5px solid #f2f3f6;" rowspan="4">
                        <div class="d-flex flex-column justify-content-around align-items-center">
                            <img
                                src="{{ asset('storage/user-images/' .  $upNextData?->screen_displayable?->lead_committee_information?->chairman_information->profile_picture) }}"
                                class="mt-1 rounded" width="50%" alt="">
                            @if($upNextData?->schedule?->type != 'session')
                                <span
                                    class="text-uppercase text-primary fw-bold chairman-title">{{ $upNextData?->screen_displayable?->lead_committee_information?->chairman_information->fullname }}</span>
                            @endif
                        </div>
                    </th>
                    <td class="align-middle text-center">
                    <span class="text-uppercase text-primary fw-bold chairman-title">
                        {{ $upNextData?->screen_displayable?->lead_committee_information?->vice_chairman_information->fullname }}
                    </span>
                    </td>
                    <td headers="co1 c1 text-truncate" rowspan="4">
                        <div class="containers1 p-0 mt-1">
                            <ul>
                                @if($upNextData?->schedule?->guests->count() == 1)
                                    @foreach($upNextData?->schedule?->guests as $guest)
                                        <li class="font-weight-600 text-truncate">
                                            {!! generateHTMLSpace(1) !!}{{ $guest->fullname }}
                                        </li>
                                        <li class="font-weight-600">
                                            {!! generateHTMLSpace(1) !!}{{ $guest->fullname }}
                                        </li>
                                    @endforeach
                                @else
                                    @foreach($upNextData?->schedule?->guests as $guest)
                                        <li class="text-start font-weight-600">
                                            {!! generateHTMLSpace(1) !!}{{ Str::limit($guest->fullname, 19, '.') }}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="text-uppercase text-center align-middle bg-primary border border-primary text-white letter-spacing-1 p-0">
                        Members
                    </th>
                </tr>
                <tr>
                    <td rowspan="2" class="p-0 text-truncate" style="border-right : 5px solid #f2f3f6;">
                        <br>
                        <div class="containers4">
                            <ul>
                                @foreach($upNextData?->screen_displayable?->lead_committee_information?->members as $member)
                                    @foreach($member->sanggunian_member as $m)
                                        <li>
                                            {!! generateHTMLSpace(1) !!}
                                            <span class="text-uppercase fw-bold">{{ $m->fullname}}</span>
                                            <br>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endisset

    <div class="bg-primary mt-auto fixed-bottom">
        <div class="scroll-container">
            <div class="scroll-text text-white fw-bold">
                <img src="{{ asset('/assets-2/images/logo-screen/logo.png') }}" class="img-fluid " width="2.5%"
                     alt="">
                <span class="text-white fw-bold text-uppercase letter-spacing-1">{{ $data['number'] }} REGULAR SESSION @ {{ $dataToPresent?->schedule?->venue }} | {{ $data?->schedules?->first()?->date_and_time->format('F d, Y') }}<img
                        src="{{ asset('/assets-2/images/logo-screen/logo2.png') }}" class="img-fluid "
                        width="3%"
                        alt=""/> | {{ $announcement }} </span>
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
    let socket = io(`http://localhost:3030/`);
    let dataToPresent = @json($dataToPresent);

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


    socket.on('SCREEN_TIMER_START', function () {
        if (!dataToPresent.start_time) {
            $.ajax({
                url: `/api/screen/start/${dataToPresent.id}`,
                method: 'PUT',
                success: function (response) {
                    dataToPresent.start_time = response.start_time;
                    document.querySelector('#startTime').innerText = moment(response.start_time).format("hh:mm A");
                    setInterval(() => updateElapsedTime(response.start_time), 1000);
                },
                error: function (response) {
                    location.reload();
                }
            });
        }
    });

    socket.on('SCREEN_TIMER_END', function () {
        if (dataToPresent.start_time) {
            $.ajax({
                url: `/api/screen/end/${dataToPresent.id}`,
                method: 'PUT',
                success: function (response) {
                    location.reload();
                },
                error: function (response) {
                    location.reload();
                }
            });
        }
    });

    socket.on('TRIGGER_REFRESH_ON_CLIENTS', function () {
        location.reload();
    });
</script>
<script>
    $(".marque_texts").html();

    function checkTime(i) {
        if (10 > i) {
            i = "0" + i
        }
        ;
        return i;
    }

    function hour(hh) {
        if (0 == hh) {
            hh = "12"
        }
        ;
        return hh;
    }
</script>
<script>
    const INTERVAL_MOVE_UP = 800;

    $(function () {
        var tickerLength = $('.containers1 ul li').length;
        var tickerHeight = $('.containers1 ul li').outerHeight();
        $('.containers1 ul li:last-child').prependTo('.containers1 ul');
        $('.containers1 ul').css('marginTop', -tickerHeight);

        function moveTop() {
            $('.containers1 ul').animate({
                top: -tickerHeight
            }, 300, function () {
                $('.containers1 ul li:first-child').appendTo('.containers1 ul');
                $('.containers1 ul').css('top', '');
            });
        }

        setInterval(function () {
            moveTop();
        }, 4500);
    });

    $(function () {
        var tickerLength = $('.containers2 ul li').length;
        var tickerHeight = $('.containers2 ul li').outerHeight();
        $('.containers2 ul li:last-child').prependTo('.containers2 ul');
        $('.containers2 ul').css('marginTop', -tickerHeight);

        function moveTop() {
            $('.containers2 ul').animate({
                top: -tickerHeight
            }, 300, function () {
                $('.containers2 ul li:first-child').appendTo('.containers2 ul');
                $('.containers2 ul li:first-child').removeClass('bg-primary').removeClass('text-white');
                $('.containers2 ul li:first-child').next().addClass('bg-primary').addClass('text-white');
                $('.containers2 ul').css('top', '');
            });
        }

        setInterval(function () {
            moveTop();
        }, 4000);
    });
    $(function () {
        var tickerLength = $('.containers3 ul li').length;
        var tickerHeight = $('.containers3 ul li').outerHeight();
        $('.containers3 ul li:last-child').prependTo('.containers3 ul');
        $('.containers3 ul').css('marginTop', -tickerHeight);

        function moveTop() {
            $('.containers3 ul').animate({
                top: -tickerHeight
            }, 300, function () {
                $('.containers3 ul li:first-child').appendTo('.containers3 ul');
                $('.containers3 ul').css('top', '');
            });
        }

        setInterval(function () {
            moveTop();
        }, 3800);
    });
    $(function () {
        var tickerLength = $('.containers4 ul li').length;
        var tickerHeight = $('.containers4 ul li').outerHeight();
        $('.containers4 ul li:last-child').prependTo('.containers4 ul');
        $('.containers4 ul').css('marginTop', -tickerHeight);

        function moveTop() {
            $('.containers4 ul').animate({
                top: -tickerHeight
            }, 300, function () {
                $('.containers4 ul li:first-child').appendTo('.containers4 ul');
                $('.containers4 ul').css('top', '');
            });
        }

        setInterval(function () {
            moveTop();
        }, 3800);
    });
</script>
</body>
</html>
