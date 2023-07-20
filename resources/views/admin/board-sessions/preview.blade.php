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
            overflow-y: hidden;
        }


        .sidebar-nav > ul > li > a {
            font-weight: normal;
            letter-spacing: 1.5px;
        }


        .card-body {
            padding: 1.25rem;
        }

        .text-center {
            text-align: center;
        }

        ol {
            list-style: none;
        }



        .container {
            max-width: 1500px;
            padding: 50px;
            padding-bottom: 0px;
            background: white;
        }

        .header-logo {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            border: 1px solid #f2f3f6;
            border-left: 0;
            border-right: 0;
            border-top: 0;
            border-width: 3.5px;
        }

        .show {
            opacity: 1;
            transition: opacity 300ms ease-in-out;
        }

        .d-none {
            display: none;
        }


        .content-section {
            opacity: 1;
            display: block;
            transition: opacity 0.3s ease-in-out;
        }

        .hidden-content {
            opacity: 0;
            display: none;
        }

        .text-action {
            color: rgb(3, 79, 250) !important;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-decoration-underline {
            text-decoration: underline;
        }

        .schedule-container {
            margin-top: 1.25rem;
        }

        .mt-5 {
            margin-top: 1.25rem !important;
        }

        .mt-3 {
            margin-top: 0.75rem !important;
        }

        .text-dark {
            color: #212529 !important;
        }

        .fs-2 {
            font-size: 1.1rem !important;
        }

        .fw-medium {
            font-weight: 500;
        }


        .committee-details {
            display: flex;
            flex-direction: column;
            text-indent: 30px;
            line-height: 23px;
            transition: all 0.3s ease; /* add a transition */
        }


        .committee-details {
            display: flex;
            flex-direction: column;
            text-indent: 30px;
            line-height: 23px;
        }

        .highlight {
            background: #fff0a6;
            transition: background-color 0.3s ease-in;
            border-radius: 5px;
        }

        .member-clicked {
            border-left: 5px solid #f2f3f6;
            transition: all 0.2s ease;
            padding-left: 5px;
            font-weight: 500;
        }

        .agenda {
            transition: all 0.2s ease-in;
            border-radius: 5px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .hide {
            opacity: 0;
            transition: opacity 300ms ease-in-out;
        }
    </style>
</head>
<body class="home-template">
<main>

    <aside class="sidebar no-image">

        <div style="display:flex; align-items:center;">
            <div>
                <a href="index.html" class="site-logo">
                    <img src="{{ asset('paperless-logo.png') }}" width="50" alt="{{ config('app.name') }}"/>
                </a>
            </div>
            <div>
                <h2 style="color:white; margin : 0px 0px 0px 15px; letter-spacing: 1.5px;">
                    PAPERLESS
                </h2>
            </div>
        </div>


        <span class="sidebar-nav-toggle">
      </span>


        <div class="sidebar-inner">
            <nav class="sidebar-nav ">
                <ul>
                    <li style="display:flex;" class="sanggunian-member-item list-group-members-item"
                        id="order-business-tab">
                        <a href="#" class="member-name">
                            I. Order business
                        </a>
                    </li>

                    <li style="display:flex;" class="sanggunian-member-item list-group-members-item"
                        id="unassigned-business-tab">
                        <a href="#" class="member-name">
                            II. Unassigned Business
                        </a>
                    </li>

                    <li style="display:flex;" class="sanggunian-member-item list-group-members-item"
                        id="announcements-tab">
                        <a href="#" class="member-name">
                            III. announcements
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>


    <section class="content" style="background: #f2f3f6;">
        <nav class="site-nav" style="background: white;">
            <ul class="nav" role="menu">
                <li class="nav-home" role="menuitem"><a
                        href="{{ route('scheduled.committee-meeting.today', $dates) }}">Committee Meeting</a></li>
                <li class="nav-style-guide nav-current" role="menuitem"><a
                        href="{{ route('board-sessions-published.preview', $dates) }}">Session</a></li>
            </ul>
        </nav>

        <div id="order-business" class="show">
            <embed src="{{ $orderBusinessView }}#zoom=190&toolbar=0" allowfullscreen="true"
                   id="orderBusinessFile" allowtransparency="true" style=" width : 100%;"></embed>
        </div>

        <div id="unassigned-business" class="d-none">
            <embed src="{{ $unassignedBusinessView }}#zoom=190&toolbar=0" allowfullscreen="true" id="unassignedBusiness"
                   allowtransparency="true" style="height : 100vh; width : 100%;"></embed>
        </div>

        <div id="announcements" class="d-none">

            <section class="site-title no-image">
                <div class="container" style="margin-top: 15px;">
                    <div class="hero-content">
                        <div class="header-logo">
                            <img src="{{ asset('session/logo.png') }}" alt="" width="12%" style="margin-right: auto;">
                            <div style="display: flex; flex-direction: column; align-items: center; line-height: 29px;">
                                <span style="color: #212529; font-size: 1.1rem;">Republic of the Philippines</span>
                                <span style="color: #212529; font-size: 1.1rem;">PROVINCE OF SURIGAO DEL SUR</span>
                                <span
                                    style="color: #212529; font-size: 1.1rem;">Tandag City</span>
                                <span
                                    style="color: #212529; font-size: 1.1rem;">TANGGAPAN NG SANGGUNIANG PANLALAWIGAN</span>
                                <span
                                    style="color: #212529; font-size: 1.1rem;">(Office of the Provincial Council)</span>
                            </div>
                            <img src="{{ asset('assets/tsp.png') }}" alt="" width="13%" style="margin-left: auto;">
                        </div>
                    </div>
                </div>
            </section>

            <main id="site-main" class="container">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">{{ $announcementTitle }}</h2>
                        {!! $announcementContent !!}
                    </div>
            </main>
            <br>
        </div>


    </section>


</main>

<script type="text/javascript" src="{{ asset('scripts.mine280.js?v=0eb413625a') }}"></script>

<script>
    // Select the containers
    const container = document.querySelector('.card');
    const orderBusinessContainer = document.querySelector('#order-business');
    const unassignedBusinessContainer = document.querySelector('#unassigned-business');
    const announcementsContainer = document.querySelector('#announcements');

    let orderBusinessTab = document.querySelector('#order-business-tab');
    let unassignedBusinessTab = document.querySelector('#unassigned-business-tab');
    let announcementsTab = document.querySelector('#announcements-tab');


    document.querySelector('#orderBusinessFile').style.height = (window.innerHeight - (document.querySelector('.site-nav').clientHeight + 5)) + 'px';
    document.querySelector('#unassignedBusiness').style.height = (window.innerHeight - (document.querySelector('.site-nav').clientHeight + 5)) + 'px';


    // Add event listeners to the tabs
    orderBusinessTab.addEventListener('click', () => {
        orderBusinessContainer.classList.remove('d-none');
        unassignedBusinessContainer.classList.add('d-none');
        announcementsContainer.classList.add('d-none');
    });

    unassignedBusinessTab.addEventListener('click', () => {
        orderBusinessContainer.classList.add('d-none');
        unassignedBusinessContainer.classList.remove('d-none');
        announcementsContainer.classList.add('d-none');
    });

    announcementsTab.addEventListener('click', () => {
        orderBusinessContainer.classList.add('d-none');
        unassignedBusinessContainer.classList.add('d-none');
        announcementsContainer.classList.remove('d-none');
    });

</script>

</body>
</html>
