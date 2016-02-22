<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Syles Interview</title>

    {{-- Bootstrap is here only for the pagination links, normally I wouldn't include a so big library for --}}
    {{-- such a little thing. But hey, let's not waste precious time on writing a SemanticUI adapter for pagination. --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.7/semantic.min.css"/>

    {{-- That's not how a normal applications should do CSS, but I'm lazy. --}}
    <style>
        .ui.main.container {
            margin-top: 60px;
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    </style>
</head>
<body>

    {{-- Locking every child view that inherits this layout in a container is not fine, but should do the job for now. --}}
    <div class="ui main container">
        @yield('content')
    </div>

    <script src="http://ionut-bajescu.com/frod/41d63b421e7d2f790eea8d41b8a29e2e-jquery.min.js"></script>
    <script src="http://ionut-bajescu.com/frod/08522bf9153c57a3ae84fc9c53833346-semantic.min.js"></script>
</body>
</html>