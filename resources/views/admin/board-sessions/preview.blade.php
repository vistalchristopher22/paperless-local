<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Today's Scheduled Committee Meeting</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/assets/css/libs.bundle.css"/>

    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/css/theme.bundle.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            box-sizing: border-box;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }
    </style>
</head>
<body>

<div class="row">
    <div class="col-lg-12 p-0 col-sm-12">
        <div class="card rounded-0 border-0 p-0">
            <div class="card-body p-0">
                <ul class="nav nav-pills nav-justified d-flex align-items-center border shadow" role="tablist">
                    <li class="nav-item waves-effect waves-light" role="presentation">
                        <button class="nav-link active h5" id="order-business-tab" data-bs-toggle="tab"
                                data-bs-target="#order-business"
                                type="button" role="tab" aria-controls="committee" aria-selected="true">Order
                            Business
                        </button>
                    </li>
                    <li class="nav-item waves-effect waves-light" role="presentation">
                        <button class="nav-link h5" id="unassigned-business-tab" data-bs-toggle="tab"
                                data-bs-target="#unassigned-business"
                                type="button" role="tab" aria-controls="session" aria-selected="false">Unassigned
                            Bussiness
                        </button>
                    </li>

                    <li class="nav-item waves-effect waves-light" role="presentation">
                        <button class="nav-link h5" id="announcement-tab" data-bs-toggle="tab"
                                data-bs-target="#announcements"
                                type="button" role="tab" aria-controls="session" aria-selected="false">Announcements
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="session-tab-panes">
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="order-business"
                         id="order-business">
                        <div class="d-flex align-items-center justify-content-center">
                            <embed src="{{ $boardSessionPathForView }}#zoom=210&toolbar=0" allowfullscreen="true"
                                   allowtransparency="true"
                                   style="height : 100vh; min-width : 100vw;"></embed>
                        </div>
                    </div>

                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="unassigned-business-tab"
                         id="unassigned-business">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            {{ $boardSession->unassigned_title }}
                        </div>
                    </div>

                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="unassigned-business-tab"
                         id="announcements">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            {{ $boardSession->announcement_title }}
                            {!! $boardSession->announcement_content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
