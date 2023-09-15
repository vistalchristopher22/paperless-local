<!DOCTYPE html>
<html>

<head>
    <title>Committee File </title>
    <style>
        body {
            padding: 0px;
            margin: 0px;
            box-sizing: border-box;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <iframe src="{{ $filePathForView }}#zoom=190&toolbar=0" style="min-height : 100vh; min-width : 100vw;"></iframe>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.6.1/socket.io.min.js"
        integrity="sha512-AI5A3zIoeRSEEX9z3Vyir8NqSMC1pY7r5h2cE+9J6FLsoEmSSGLFaqMQw8SWvoONXogkfFrkQiJfLeHLz3+HOg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let serverSocketUrl = document
            .querySelector('meta[name="server-socket-url"]')
            .getAttribute("content");
            
        let socket = io(serverSocketUrl);

        socket.on('TRIGGER_REFRESH_ON_CLIENTS', () => window.location.reload());
    </script>
</body>

</html>
