<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <meta name="cms-url" content="{{ route('home') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/favicon.png">
    @vite(['resources/css/app.css', 'resources/js/portfolio.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.0/p5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/Yusuf-117/lifegrid/lifegrid.min.js"></script>
</head>

<body class="bg-zinc-950 text-white">

    <div id="app"></div>

</body>

</html>
