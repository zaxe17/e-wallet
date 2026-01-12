@extends('main')
@section('title', 'Landing Page')
@section('content')
@include('component.navbar')
@include('component.homebg')
<section class="container mx-auto h-screen px-8 flex items-center justify-start relative" id="home">
    <div class="w-1/2">
        <div class="text-left mx-18">
            <h1 class="text-8xl text-[#2F3E34] lato opacity-0 left" data-delay="0.3">PayNoy</h1>
            <p class="text-lg text-[#5F6F64] my-4 opacity-0 left" data-delay="0.6">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>
            <div class="opacity-0 left" data-delay="0.9">
                <button class="bg-[#6AA887] hover:bg-[#7FB89A] transition-all duration-300 ease-in-out px-5 py-2 rounded-full text-xl text-[#0F2F1F]">Learn More</button>
            </div>
        </div>
    </div>
</section>

<section class="container mx-auto h-screen px-8 flex items-center justify-end relative" id="about">
    <div class="w-1/2">
        <div class="text-left mx-18">
            <h1 class="text-8xl text-[#2F3E34] lato right" data-delay="0.3">About</h1>
            <p class="text-lg text-[#5F6F64] my-4 right" data-delay="0.6">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>
            <div class="right" data-delay="0.9">
                <button class="bg-[#6AA887] hover:bg-[#7FB89A] transition-all duration-300 ease-in-out px-5 py-2 rounded-full text-xl text-[#0F2F1F]">Read More</button>
            </div>
        </div>
    </div>
</section>

<section class="container mx-auto h-screen px-8 flex items-center justify-center relative" id="teams">
    <div class="w-full">
        <div class="mx-18 flex flex-col gap-3">
            <h1 class="text-center text-5xl text-[#2F3E34] lato up" data-delay="0.3">Teams</h1>
            <div class="grid grid-cols-5 w-full gap-3">

                <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="0.6">
                    <div class="w-full h-64 overflow-hidden">
                        <img
                            src="/assets/DSC_1504.jpg"
                            alt="profile"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="px-4 pt-3 pb-20">
                        <p class="font-bold text-[#2F3E34] leading-tight">Jan Marc Jacolbia</p>
                        <!-- <span class="text-xs leading-none block">Front-End Developer</span> -->
                        <p class="text-[#4A5A4D]">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
                <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="0.9">
                    <div class="w-full h-64 overflow-hidden">
                        <img
                            src="/assets/4c54d3bf-1ab1-46ec-8bf3-b6451e96dd53.jpg"
                            alt="profile"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="px-4 pt-3 pb-20">
                        <p class="font-bold text-[#2F3E34]">Krysten Daphne Damicog</p>
                        <p class="text-[#4A5A4D]">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
                <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="1.2">
                    <div class="w-full h-64 overflow-hidden">
                        <img
                            src="/assets/IMG_20250916_155011.jpg"
                            alt="profile"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="px-4 pt-3 pb-20">
                        <p class="font-bold text-[#2F3E34]">John Evans Gutierrez</p>
                        <p class="text-[#4A5A4D]">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
                <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="1.5">
                    <div class="w-full h-64 overflow-hidden">
                        <img
                            src="/assets/IMG_20250916_155011.jpg"
                            alt="profile"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="px-4 pt-3 pb-20">
                        <p class="font-bold text-[#2F3E34]">Micka Soriano</p>
                        <p class="text-[#4A5A4D]">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>
                <div class="bg-fuchsia-100 card-border overflow-hidden card-shadow card" data-delay="1.8">
                    <div class="w-full h-64 overflow-hidden">
                        <img
                            src="/assets/gamayo.jpg"
                            alt="profile"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="px-4 pt-3 pb-20">
                        <p class="font-bold text-[#2F3E34]">Kelia Audrey Gamayo</p>
                        <p class="text-[#4A5A4D]">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection