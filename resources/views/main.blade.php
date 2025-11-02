<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-wallet - @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/scene.js', 'resources/js/animate.js'])
</head>


<body class="m-0 p-0 h-screen">
    <div class="w-full h-full fixed top-0 left-0">
        <div id="container3D" class="w-full h-full"></div>
        <div class="absolute top-0 z-[-2] h-screen w-screen bg-fuchsia-300 bg-[radial-gradient(#ffffff33_1px,#fce7f3_1px)] bg-size-[20px_20px]"></div>
    </div>

    @include('component.navbar')

    @yield('content')

</body>

</html>