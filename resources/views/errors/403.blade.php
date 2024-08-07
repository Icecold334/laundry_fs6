<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Akses Ditolak</title>
    <!--Style-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/hack-font@3/build/web/hack.css">
    <link rel="stylesheet" href="/errors/404/style.css">
</head>
<style>
    body {
        font-family: 'Hack', sans-serif;
    }
</style>

<body>

    <!--Circle-->
    <div class="Circle" id="Circle">
        <div class="Circle_Text">
            <!--404 inside the circle-->
            <h1>403</h1>
            <h3>Oops! Akses ditolak</h3>
            @auth
                <a href="{{ url()->previous() }}" class="btn">Kembali</a>
            @endauth
            @guest
                <a href="/" class="btn">Beranda</a>
            @endguest
        </div>
    </div>
</body>

</html>
