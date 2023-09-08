<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
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

        body {
            background: url('{{ asset('tsp-bg.jpg') }}') center center;
            height: 100vh;
            background-size: cover;
            background-repeat: no-repeat;
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


        .font-weight-600 {
            font-weight: 600;
        }


        .scroll-to-top-present-committee-invited-guests {
            width: 100%;
            margin: 0 0;
            overflow: hidden;
            max-width: 100%;
            max-height: 30vh;
        }

        .scroll-to-top-up-next-committee-invited-guests {
            width: 100%;
            margin: 0 0;
            overflow: hidden;
            max-width: 100%;
            max-height: 30vh;
        }

        .scroll-to-top-sanggunian-members {
            width: 100%;
            margin: 0 0;
            overflow: hidden;
            max-width: 100%;
            max-height: 33.5vh;
        }

        .scroll-to-top-sanggunian-members-up-next {
            width: 100%;
            margin: 0 0;
            overflow: hidden;
            max-width: 100%;
            max-height: 33.5vh;
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column flex-nowrap justify-content-center align-items-center p-1">
        @isset($dataToPresent)
            <div class="bg-light text-dark p-0 d-flex justify-content-between text-center"
                style="border-collapse : collapse;">
                @if ($dataToPresent?->schedule?->type == 'session')
                    <div class="mx-2">
                        <span class="letter-spacing-1">&nbsp;</span>
                    </div>
                @else
                    <div class="mx-2">
                        <span class="text-uppercase fw-bold letter-spacing-1 text-truncate">
                            {{ Str::limit(Str::remove('COMMITTEE ON', Str::upper($dataToPresent?->screen_displayable?->lead_committee_information?->title)), 45, '...') }}
                        </span>
                        {{-- {{ Str::limit($dataToPresent?->screen_displayable?->lead_committee_information?->title, 78, '...') }} --}}
                    </div>
                @endif
                <div class="mx-2">
                    <!-- <span id="startTime" class="fw-bold">{{ $dataToPresent?->start_time?->format('h:i A - ') }}</span> -->
                    <span id="elapsed-time" class="fw-bold d-none">00:00:00</span>
                </div>
            </div>
            {{-- PRESENT DATA --}}
            <div class="container-fluid d-flex align-items-center justify-content-between p-0">
                @if ($dataToPresent?->schedule?->type != 'session')
                    <table class="table table-bordered" style="height : 38vh; !important;">
                        <tr>
                            <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                                width="36%" style="letter-spacing : 1px;">
                                Chairman
                            </th>
                            <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                                style="letter-spacing : 1px;">Vice Chairman
                            </th>
                            <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                                style="letter-spacing : 1px;">
                                @if ($dataToPresent?->screen_displayable?->committee_invited_guests->count() === 0)
                                    {!! generateHTMLSpace(1) !!}
                                @else
                                    {!! generateHTMLSpace(8) !!} Invited Guest/s
                                    {!! generateHTMLSpace(8) !!}
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <td class="p-0 text-center align-middle" rowspan="4">
                                <div class="d-flex flex-column justify-content-around align-items-center">
                                    <img src="{{ asset('storage/user-images/' . $dataToPresent?->screen_displayable?->lead_committee_information?->chairman_information?->profile_picture) }}"
                                        class="mt-1 rounded" width="50%" alt="">
                                    <span
                                        class="text-uppercase text-primary fw-bold chairman-title text-truncate">{{ $dataToPresent?->screen_displayable?->lead_committee_information?->chairman_information->fullname }}</span>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-uppercase text-primary fw-bold chairman-title">
                                    @if (method_exists($dataToPresent->screen_displayable, 'lead_committee_information'))
                                        {{ $dataToPresent?->screen_displayable?->lead_committee_information?->vice_chairman_information->fullname }}
                                    @endif

                                </span>
                            </td>
                            @if ($dataToPresent?->screen_displayable?->committee_invited_guests->count() !== 0)
                                <td rowspan="4">
                                    @if ($dataToPresent?->screen_displayable?->committee_invited_guests->count() >= 8)
                                        <div class="scroll-to-top-present-committee-invited-guests p-0">
                                            <ul>
                                                @foreach ($dataToPresent?->screen_displayable?->committee_invited_guests as $guest)
                                                    <li class="font-weight-600 text-truncate">
                                                        {{ $loop->index + 1 }}.
                                                        {!! generateHTMLSpace(0) !!}{{ $guest->fullname }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @elseif(
                                        $dataToPresent?->screen_displayable?->committee_invited_guests->count() < 8 &&
                                            $dataToPresent?->screen_displayable?->committee_invited_guests->count() !== 0)
                                        <ul>
                                            @foreach ($dataToPresent?->screen_displayable?->committee_invited_guests as $guest)
                                                <li class="font-weight-600 text-truncate">
                                                    {{ $loop->index + 1 }}. {!! generateHTMLSpace(0) !!}{{ $guest->fullname }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            @else
                                <td rowspan="4">
                                    @if (method_exists($dataToPresent->screen_displayable, 'lead_committee_information'))
                                        <div id="members-img-container" class="text-center">
                                        </div>
                                    @endif
                                </td>
                            @endif
                        </tr>
                        <tr>
                            <td
                                class="text-uppercase text-center align-middle bg-primary border border-primary text-white letter-spacing-1 p-0">
                                Members
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="p-0 text-truncate" style="">
                                <br>
                                <div class="scroll-to-top-sanggunian-members">
                                    <ul>
                                        @if (method_exists($dataToPresent->screen_displayable, 'lead_committee_information'))
                                            @foreach ($dataToPresent?->screen_displayable?->lead_committee_information?->members as $k => $member)
                                                @foreach ($member->sanggunian_member as $m)
                                                    <li class="">
                                                        {!! generateHTMLSpace(1) !!}
                                                        <span class="text-uppercase fw-bold">{{ $m->fullname }}</span>
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
                                width="36%" style="letter-spacing : 1px;">
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
                                <div
                                    class="d-flex flex-column justify-content-around align-items-center letter-spacing-2 text-primary p-3">
                                    <img src="{{ asset('/assets-2/images/logo-screen/logo2.png') }}" alt="">
                                    <span class="fs-4 fw-bolder">COMMITTEE MEETINGS</span>
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
                @if ($upNextData?->schedule?->type == 'session')
                    <div class="mx-2">
                        <span class="letter-spacing-1">&nbsp;</span>
                    </div>
                @else
                    <div class="mx-2">
                        <span class="text-uppercase letter-spacing-1">NEXT COMMITTEE HEARING :
                            <span class="fw-bold">
                                {{ Str::limit(Str::remove('COMMITTEE ON', Str::upper($upNextData?->screen_displayable?->lead_committee_information?->title)), 23, '...') }}
                            </span>
                        </span>
                    </div>
                @endif
            </div>

            <div class="container-fluid mb-0 pb-0 d-flex align-items-center justify-content-between p-0">
                <table class="table table-bordered" style="height : 40vh; !important;">
                    <tr>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            width="25%" style="letter-spacing : 1px; ">
                            Chairman
                        </th>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            style="letter-spacing : 1px;">Vice Chairman
                        </th>
                        <th class="text-uppercase text-center p-1 bg-primary border border-primary text-white"
                            style="letter-spacing : 1px; ">
                            @if ($upNextData?->screen_displayable?->committee_invited_guests->count() === 0)
                                {!! generateHTMLSpace(1) !!}
                            @else
                                {!! generateHTMLSpace(8) !!} Invited Guest/s
                                {!! generateHTMLSpace(8) !!}
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th class="p-0 text-center align-middle" style="" rowspan="4">
                            <div class="d-flex flex-column justify-content-around align-items-center">
                                <img src="{{ asset('storage/user-images/' . $upNextData?->screen_displayable?->lead_committee_information?->chairman_information->profile_picture) }}"
                                    class="mt-1 rounded" width="50%" alt="">
                                @if ($upNextData?->schedule?->type != 'session')
                                    <span
                                        class="text-uppercase text-primary fw-bold chairman-title text-truncate">{{ $upNextData?->screen_displayable?->lead_committee_information?->chairman_information->fullname }}</span>
                                @endif
                            </div>
                        </th>
                        <td class="align-middle text-center">
                            <span class="text-uppercase text-primary fw-bold chairman-title">
                                {{ $upNextData?->screen_displayable?->lead_committee_information?->vice_chairman_information->fullname }}
                            </span>
                        </td>
                        @if ($upNextData?->screen_displayable?->committee_invited_guests->count() !== 0)
                            <td rowspan="4">
                                @if ($upNextData?->screen_displayable?->committee_invited_guests->count() >= 8)
                                    <div class="scroll-to-top-up-next-committee-invited-guests p-0">
                                        <ul>
                                            @foreach ($upNextData?->screen_displayable?->committee_invited_guests as $guest)
                                                <li class="font-weight-600 text-truncate">
                                                    {{ $loop->index + 1 }}.
                                                    {!! generateHTMLSpace(0) !!}{{ $guest->fullname }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @elseif(
                                    $upNextData?->screen_displayable?->committee_invited_guests->count() < 8 &&
                                        $upNextData?->screen_displayable?->committee_invited_guests->count() !== 0)
                                    <ul>
                                        @foreach ($upNextData?->screen_displayable?->committee_invited_guests as $guest)
                                            <li class="font-weight-600 text-truncate">
                                                {{ $loop->index + 1 }}. {!! generateHTMLSpace(0) !!}{{ $guest->fullname }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        @else
                            <td rowspan="4">
                                @if (method_exists($upNextData->screen_displayable, 'lead_committee_information'))
                                    <div id="members-img-container-up-next"
                                        class="text-center d-flex justify-content-center mt-2">
                                    </div>
                                @endif
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td
                            class="text-uppercase text-center align-middle bg-primary border border-primary text-white letter-spacing-1 p-0">
                            Members
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="p-0 text-truncate" style="">
                            <div class="scroll-to-top-sanggunian-members-up-next">
                                <ul>
                                    @foreach ($upNextData?->screen_displayable?->lead_committee_information?->members as $member)
                                        @foreach ($member->sanggunian_member as $m)
                                            <li>
                                                {!! generateHTMLSpace(1) !!}
                                                <span class="text-uppercase fw-bold">{{ $m->fullname }}</span>
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
            <marquee onmouseover="this.stop();" onmouseout="this.start();" direction="left" behavior="scroll"
                scrollamount="{{ $announcementRunningSpeed }}">
                <img src="{{ asset('/assets-2/images/logo-screen/logo.png') }}" class="img-fluid " width="2.5%"
                    alt="">
                <span class="text-white fw-bold text-uppercase letter-spacing-1">{{ $data['number'] }} REGULAR SESSION
                    @ {{ $dataToPresent?->schedule?->venue }} |
                    {{ $data?->schedules?->first()?->date_and_time->format('F d, Y') }}<img
                        src="{{ asset('/assets-2/images/logo-screen/logo2.png') }}" class="img-fluid "
                        width="3%" alt="" /> | {{ $announcement }} </span>
                <span class="text-uppercase fw-bold text-white"> | Powered by : <img src="{{ asset('/itu.gif') }}"
                        class="img-fluid" width="2.5%" alt="" /> PADMO-ITU </span>
            </marquee>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.6.1/socket.io.min.js"
        integrity="sha512-AI5A3zIoeRSEEX9z3Vyir8NqSMC1pY7r5h2cE+9J6FLsoEmSSGLFaqMQw8SWvoONXogkfFrkQiJfLeHLz3+HOg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // let socket = io(`http://192.168.1.100:3030/`);
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
        let actionMoveToTop = (element) => {
            let tickerLength = $(element + ' ul li').length;
            let tickerHeight = $(element + ' ul li').outerHeight();

            $(element + ' ul').animate({
                top: -tickerHeight
            }, 300, function() {
                $(element + ' ul li:first-child').appendTo(element + ' ul');
                $(element + ' ul li:first-child');
                $(element + ' ul li:first-child').next();
                $(element + ' ul').css('top', '');
            });
        }

        socket.on('MOVE_GUEST_TO_TOP', () => actionMoveToTop('.scroll-to-top-present-committee-invited-guests'));

        let autoScrollToTop = (data, interval, element) => {
            let dataToPresent = data;
            if (dataToPresent?.screen_displayable?.committee_invited_guests?.length !== 0) {
                let tickerLength = $(element + ' ul li').length;
                let tickerHeight = $(element + ' ul li').outerHeight();
                $(element + ' ul li:last-child').prependTo(
                    element + ' ul');
                $(element + ' ul').css('marginTop', -tickerHeight);

                setInterval(() => actionMoveToTop(element), interval);
            }
        };

        let autoScrollToTopSanggunianMembers = (data, interval, element) => {
            let dataToPresent = data;
            if (dataToPresent?.screen_displayable?.committee_invited_guests?.length !== 0) {
                let tickerLength = $(element + ' ul li').length;
                let tickerHeight = $(element + ' ul li').outerHeight();
                $(element + ' ul li:last-child').prependTo(
                    element + ' ul');
                $(element + ' ul').css('marginTop', -tickerHeight);

                setInterval(() => actionMoveToTop(element), interval);
            } else {
                let images = [];
                let members = dataToPresent?.screen_displayable?.lead_committee_information?.members;
                members.forEach((member) => images.push(member.sanggunian_member[0]?.profile_picture));
                let currentImageIndex = 0;

                $('#members-img-container').html(
                    `<img src="/storage/user-images/${images[currentImageIndex]}"  style="width : 16vw !important; height : 25vh !important;" class="img-fluid mt-2 rounded">`
                );

                let tickerLength = $(element + ' ul li').length;
                let tickerHeight = $(element + ' ul li').outerHeight();
                $(element + ' ul li:last-child').prependTo(
                    element + ' ul');
                $(element + ' ul').css('marginTop', -tickerHeight);

                setInterval(() => {
                    actionMoveToTop(element);
                    currentImageIndex = (currentImageIndex + 1) % images.length;
                    $('#members-img-container').html(
                        `<img src="/storage/user-images/${images[currentImageIndex]}"  style="width : 16vw !important; height : 25vh !important;"  class="img-fluid rounded">`
                    );
                }, interval);
            }
        };

        let autoScrollToTopSanggunianMembersUpNext = (data, interval, element) => {
            let dataToPresent = data;
            if (dataToPresent?.screen_displayable?.committee_invited_guests?.length !== 0) {
                let tickerLength = $(element + ' ul li').length;
                let tickerHeight = $(element + ' ul li').outerHeight();
                $(element + ' ul li:last-child').prependTo(
                    element + ' ul');
                $(element + ' ul').css('marginTop', -tickerHeight);

                setInterval(() => actionMoveToTop(element), interval);
            } else {
                let images = [];
                let members = dataToPresent?.screen_displayable?.lead_committee_information?.members;
                members.forEach((member) => images.push(member.sanggunian_member[0]?.profile_picture));
                let currentImageIndex = 0;

                $('#members-img-container-up-next').html(
                    `<img src="/storage/user-images/${images[currentImageIndex]}" style="width : 16vw !important; height : 25vh !important;" class="img-fluid rounded">`
                );


                let tickerLength = $(element + ' ul li').length;
                let tickerHeight = $(element + ' ul li').outerHeight();
                $(element + ' ul li:last-child').prependTo(
                    element + ' ul');
                $(element + ' ul').css('marginTop', -tickerHeight);

                setInterval(() => {
                    actionMoveToTop(element);
                    currentImageIndex = (currentImageIndex + 1) % images.length;
                    $('#members-img-container-up-next').html(
                        `<img src="/storage/user-images/${images[currentImageIndex]}" style="width : 16vw !important; height : 25vh !important;" class="img-fluid rounded">`
                    );
                }, interval);
            }
        };


        autoScrollToTop(@json($dataToPresent), 1000, '.scroll-to-top-present-committee-invited-guests');
        autoScrollToTopSanggunianMembers(@json($dataToPresent), 2000, '.scroll-to-top-sanggunian-members');

        let upNextData = @json($upNextData);
        if (upNextData) {
            autoScrollToTop(upNextData, 1000, '.scroll-to-top-up-next-committee-invited-guests');
            autoScrollToTopSanggunianMembersUpNext(upNextData, 2000, '.scroll-to-top-sanggunian-members-up-next');
        }
    </script>
</body>

</html>
