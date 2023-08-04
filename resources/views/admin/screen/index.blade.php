<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <link href="{{ asset('/assets-2/css/style_session.css') }}" rel="stylesheet">
    </head>
    <body onload="timelaps1();">
        <div class="container-fluid rectangle1">
            <div class="col-12">
                <div class="row">
                    <div class="col-2 mt-2 mb-2">
                        <img src="{{ asset('/assets-2/images/logo-screen/logo.png') }}" width="25%" alt="">
                    </div>
                    <div class="col-8">
                        <center>
                            <p class="top-head">
                                <i>S E S S I O N</i>
                            </p>
                        </center>
                    </div>
                    <div class="col-2"><br>
                        <img class="float-end" src="{{ asset('/assets-2/images/logo-screen/logo2.png') }}" width="30%" alt="" style="margin-top: -20px;">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-4 rectangle2">
                    <p id="dateTime">
                        
                    </p>
                </div>
                <div class="col-8 rectangle3">
                    <center>
                        <p class="venue float-start">
                            VENUE: TANGGAPAN NG SANGGUNIANG PANLALAWIGAN
                        </p>
                    </center>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <center>
                <table class="table_committee1 mt-2">
                    <thead>
                        <tr>
                            <th class="th1"><center>&nbsp;ONGOING&nbsp;</center></th>
                            <th class="th2" colspan="3"><center>ORDER OF BUSINESS ORDER OF BUSINESS ORDER OF <br> 27TH REGULAR SESSION</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td1" colspan="2">&nbsp;&nbsp;CHAIRMAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: HON. MANUEL O. ALAMEDA<br>&nbsp;&nbsp;V-CHAIRMAN : HON. ANTONIO C. AZARCON</td>
                            <td class="td2"><center>INVITED GUEST</center></td>
                            <td class="td3"><center>TIME</center></td>
                        </tr>
                        <tr>
                            <td class="td11" colspan="2">&nbsp;&nbsp;<span style="font-size: 20px;">MEMBERS:</span><span class="br" style="margin-bottom: -1px;"></span>
                                <div class="containers1">
                                    <ul>
                                        <li>
                                            {!! $space1 !!}HON. VALERIO T. MONTESCLAROS, JR.
                                        </li>
                                        <li>
                                            {!! $space1 !!}HON. ANTHONY JOSEPH P. CAÑEDO
                                        </li>
                                        <li>
                                            {!! $space1 !!}HON. GINES RICKY J. SAYAWAN, JR.
                                        </li>
                                        <li>
                                            {!! $space1 !!}HON. GINES RICKY J. SAYAWAN, JR.
                                        </li>
                                        <li>
                                            {!! $space1 !!}HON. GINES RICKY J. SAYAWAN, JR111.
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="td12">
                                <div class="containers2">
                                    <ul>
                                        <li>
                                            {!! $space11 !!}HON. ALEXANDER T. PIMENTEL
                                        </li>
                                        <li>
                                            {!! $space11 !!}HON. JOHN PAUL C. PIMENTEL
                                        </li>
                                        <li>
                                            {!! $space11 !!}HON. VICENTE H. PIMENTEL, III
                                        </li>
                                        <li>
                                            {!! $space11 !!}HON. VICENTE H. PIMENTEL, III
                                        </li>
                                        <li>
                                            {!! $space11 !!}HON. VICENTE H. PIMENTEL, III
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="td13"><center>10:00 AM<span class="br" style="margin-bottom: -10px;"></span><span style="font-size: 40px;">00:00</span><span class="br"></span><span style="font-size: 10px;">HOURS&nbsp;&nbsp;&nbsp;&nbsp;MINUTES</span></center></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table_committee2" style="margin-top: -30px;">
                    <thead>
                        <tr style="visibility:hidden;">
                            <th class="th11"><center>ONGOING</center></th>
                            <th class="th12" colspan="3"><center>ORDE</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="td21" colspan="4"><i><center>N&nbsp;&nbsp;E&nbsp;&nbsp;X&nbsp;&nbsp;T&nbsp;&nbsp;. . .</center></i></td>
                        </tr>
                        <tr>
                            <td class="td31"><center>UPCOMING</center></td>
                            <td class="td32"><center>MEMBERS</center></td>
                            <td class="td33"><center>INVITED GUEST</center></td>
                            <td class="td34"><center>DATE & TIME</center></td>
                        </tr>
                        <tr>
                            <td class="td41" rowspan="2"><center>ORDER OF BUSINESS</center></td>
                            <td class="td42">&nbsp;&nbsp;CHAIRMAN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: HON. MANUEL O. ALAMEDA&nbsp;&nbsp;<br>&nbsp;&nbsp;V-CHAIRMAN : HON. ANTONIO C. AZARCON&nbsp;&nbsp;</td>
                            <td class="td43" rowspan="2">
                                <div class="containers3">
                                    <ul>
                                        <li>
                                            {!! $space2 !!}HON. ALEXANDER T. PIMENTEL
                                        </li>
                                        <li>
                                            {!! $space2 !!}HON. JOHN PAUL C. PIMENTEL
                                        </li>
                                        <li>
                                            {!! $space2 !!}HON. VICENTE H. PIMENTEL, IIIsss
                                        </li>
                                        <li>
                                            {!! $space2 !!}HON. ALEXANDER T. PIMENTEL
                                        </li>
                                        <li>
                                            {!! $space2 !!}HON. ALEXANDER T. PIMENTEL
                                        </li>
                                        <li>
                                            {!! $space2 !!}HON. ALEXANDER T. PIMENTEL
                                        </li>
                                        <li>
                                            {!! $space2 !!}HON. ALEXANDER T. PIMENTEL
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="td44" rowspan="2"><center>FEBRUARY 29, 2023<br/></center></td>
                        </tr>
                        <tr>
                            <td class="td51" rowspan="2">
                            &nbsp;&nbsp;<span style="font-size: 15px;">MEMBERS:</span><span class="br" style="margin-bottom: -10px;"></span>
                            <div class="containers4">
                                <ul>
                                    <li>
                                        {!! $space1 !!}HON. VALERO T. MONTESCLAROS
                                    </li>
                                    <li>
                                        {!! $space1 !!}HON. ANTHONY JOSEPH P. CAÑEDO
                                    </li>
                                    <li>
                                        {!! $space1 !!}HON. GINES RICKY J. SAYAWAN, JR.
                                    </li>
                                    <li>
                                        {!! $space1 !!}HON. GINES RICKY J. SAYAWAN, JR.
                                    </li>
                                </ul>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
        </div>
        <div class="body">
            <div class="marquee" style="background-color:#096AEB;" width="100%">
                <div class="marquee__group"><b style="font-family:Arial; font-size: 50px; color:white;">{!! $space3 !!}<span class="marque_texts"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 15px;">Powered by: PADMO-ITU</span> <span class="logo_marque">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b>
                </div>

                <div aria-hidden="true" class="marquee__group"><b style="font-family:Arial; font-size: 50px; color:white;">{!! $space3 !!}<span class="marque_texts"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 15px;">Powered by: PADMO-ITU</span> <span class="logo_marque">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></b>
                </div>
            </div>
        </div>
        <script>
            $(".marque_texts").html('ANNOUNCEMENT !!!');
            function <?php echo "timelaps1"; ?>() {
                var intsecond = setInterval(fncsecond1, 1000);
                function fncsecond1() {
                    var today = new Date();
                    var mm = today.getMonth();
                    const mmn = ["JANUARY", "FEBRUARY", "MARCH","APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                    var dd = today.getDate();
                    var yy = today.getFullYear();
                    var h = (12 > today.getHours()) ? today.getHours() : today.getHours() - 12;
                    h = hour(h);
                    var m = today.getMinutes();
                    var s = today.getSeconds();
                    var amOrPm = (today.getHours() > 11) ? "PM" : "AM";
                    m = checkTime(m);
                    s = checkTime(s);
                    document.getElementById('dateTime').innerHTML =
                    "DATE: &nbsp;" + mmn[ mm] + " " + dd + ", " + yy + "&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;TIME: " + h + ":" + m + " " + amOrPm;
                }
            }
            function checkTime(i) {
                if (10 > i) {i = "0" + i};
                    return i;
            }
            function hour(hh) {
                if (0 == hh) {hh = "12"};
                    return hh;
            }
        </script>
        <script>
            $(function(){
                var tickerLength = $('.containers1 ul li').length;
                var tickerHeight = $('.containers1 ul li').outerHeight();
                $('.containers1 ul li:last-child').prependTo('.containers1 ul');
                $('.containers1 ul').css('marginTop',-tickerHeight);
                function moveTop(){
                    $('.containers1 ul').animate({
                    top : -tickerHeight
                    }, 300, function(){
                    $('.containers1 ul li:first-child').appendTo('.containers1 ul');
                    $('.containers1 ul').css('top','');
                    });
                }
                setInterval( function(){
                    moveTop();
                }, 4000);
            });
            $(function(){
                var tickerLength = $('.containers2 ul li').length;
                var tickerHeight = $('.containers2 ul li').outerHeight();
                $('.containers2 ul li:last-child').prependTo('.containers2 ul');
                $('.containers2 ul').css('marginTop',-tickerHeight);
                function moveTop(){
                    $('.containers2 ul').animate({
                    top : -tickerHeight
                    }, 300, function(){
                    $('.containers2 ul li:first-child').appendTo('.containers2 ul');
                    $('.containers2 ul').css('top','');
                    });
                }
                setInterval( function(){
                    moveTop();
                }, 4000);
            });
            $(function(){
                var tickerLength = $('.containers3 ul li').length;
                var tickerHeight = $('.containers3 ul li').outerHeight();
                $('.containers3 ul li:last-child').prependTo('.containers3 ul');
                $('.containers3 ul').css('marginTop',-tickerHeight);
                function moveTop(){
                    $('.containers3 ul').animate({
                    top : -tickerHeight
                    }, 300, function(){
                    $('.containers3 ul li:first-child').appendTo('.containers3 ul');
                    $('.containers3 ul').css('top','');
                    });
                }
                setInterval( function(){
                    moveTop();
                }, 4000);
            });
            $(function(){
                var tickerLength = $('.containers4 ul li').length;
                var tickerHeight = $('.containers4 ul li').outerHeight();
                $('.containers4 ul li:last-child').prependTo('.containers4 ul');
                $('.containers4 ul').css('marginTop',-tickerHeight);
                function moveTop(){
                    $('.containers4 ul').animate({
                    top : -tickerHeight
                    }, 300, function(){
                    $('.containers4 ul li:first-child').appendTo('.containers4 ul');
                    $('.containers4 ul').css('top','');
                    });
                }
                setInterval( function(){
                    moveTop();
                }, 4000);
            });
        </script>
    </body>
</html>