<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-wallet</title>

    @vite(['resources/css/app.css', 'resources/js/scene.js', 'resources/js/animate.js'])
</head>

<body class="m-0 p-0 h-screen bg-fuchsia-100">
    <div class="w-full h-full fixed top-0 left-0">
        <div id="container3D" class="w-full h-full"></div>
        <div class="absolute top-0 z-[-2] h-screen w-screen bg-fuchsia-300 bg-[radial-gradient(#ffffff33_1px,#fce7f3_1px)] bg-size-[20px_20px]"></div>
    </div>

    @include('component.navbar')

    <section class="container mx-auto h-screen px-8 flex items-center justify-start relative" id="home">
        <div class="w-1/2">
            <div class="text-left mx-18">
                <h1 class="text-8xl heading title">E-wallet</h1>
                <p class="text-lg my-4 subtitle">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </p>
                <div class="animate-button">
                    <button class="bg-fuchsia-300 hover:bg-fuchsia-400 transition-all duration-300 ease-in-out px-5 py-2 rounded-full text-xl">Learn More</button>
                </div>
            </div>
        </div>
    </section>

    <section class="container mx-auto h-screen px-8 flex items-center justify-end relative" id="about">
        <div class="w-1/2">
            <div class="text-left mx-18">
                <h1 class="text-8xl heading about-title">About</h1>
                <p class="text-lg my-4 about-subtitle">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </p>
            </div>
        </div>
    </section>

    <section class="container mx-auto h-screen px-8 flex items-center justify-center relative" id="teams">
        <div class="w-full">
            <div class="mx-18 flex flex-col gap-3">
                <h1 class="text-center text-8xl heading team-title">Teams</h1>
                <div class="grid grid-cols-5 w-full gap-3">

                    <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="0.3">
                        <div class="w-full h-64 overflow-hidden">
                            <img
                                src="/assets/DSC_1504.jpg"
                                alt="profile"
                                class="w-full object-cover">
                        </div>
                        <div class="px-4 pt-3 pb-20">
                            <p class="font-bold">Jan Marc Jacolbia</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>
                    <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="0.6">
                        <div class="w-full h-64 overflow-hidden">
                            <img
                                src="/assets/DSC_1504.jpg"
                                alt="profile"
                                class="w-full object-cover">
                        </div>
                        <div class="px-4 pt-3 pb-20">
                            <p class="font-bold">Jan Marc Jacolbia</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>
                    <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="0.9">
                        <div class="w-full h-64 overflow-hidden">
                            <img
                                src="/assets/IMG_20250916_155011.jpg"
                                alt="profile"
                                class="w-full object-cover">
                        </div>
                        <div class="px-4 pt-3 pb-20">
                            <p class="font-bold">John Evans Gutierrez</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>
                    <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="1.3">
                        <div class="w-full h-64 overflow-hidden">
                            <img
                                src="/assets/IMG_20250916_155011.jpg"
                                alt="profile"
                                class="w-full object-cover">
                        </div>
                        <div class="px-4 pt-3 pb-20">
                            <p class="font-bold">John Evans Gutierrez</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>
                    <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="1.6">
                        <div class="w-full h-64 overflow-hidden">
                            <img
                                src="/assets/IMG_20250916_155011.jpg"
                                alt="profile"
                                class="w-full object-cover">
                        </div>
                        <div class="px-4 pt-3 pb-20">
                            <p class="font-bold">John Evans Gutierrez</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>

</html>