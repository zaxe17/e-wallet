@extends('main')
@section('title', 'Login')
@section('content')
@include('component.navbar')
@include('component.homebg')
<section class="container mx-auto h-screen p-15 flex items-center justify-center gap-20 relative">
    <div class="w-1/2 text-center">
        <h1 class="text-xl leading-15 opacity-0 title">Welcome Back to</h1>
        <h2 class="text-9xl mb-5 lato opacity-0 title">E-wallet</h2>
        <p class="opacity-0 subtitle">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
    </div>
    <div class="w-1/3 bg-[rgba(255, 255, 255, 0.18)] rounded-2xl form-shadow backdrop-blur-sm p-10 opacity-0 form">
        <h1 class="text-4xl mb-5 lato font-semibold">Sign in</h1>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" id="loginForm" class="needs-validation flex flex-col gap-5" novalidate>
            @csrf
            <div class="flex flex-col gap-4">
                {{-- EMAIL OR USERNAME INPUT --}}
                <div class="flex flex-col">
                    <label for="email_username" class="text-sm font-bold ml-1.5">Email or Username</label>
                    <input type="text" id="email_username" name="email_username" value="{{ old('email_username') }}" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    @error('email_username')
                    <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                    @else
                    <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your Email or Username.</span>
                    @enderror
                </div>

                {{-- PASSWORD INPUT --}}
                <div class="flex flex-col">
                    <label for="password" class="text-sm font-bold ml-1.5">Password</label>
                    <input type="password" id="password" name="password" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md font-medium input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    @error('password')
                    <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                    @else
                    <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your Password.</span>
                    @enderror
                </div>
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="flex justify-center items-center flex-col gap-10">
                <button type="submit" class="w-full flex justify-center items-center bg-sky-600 hover:bg-sky-400 px-5 py-2 rounded-lg text-sm text-white hover:text-sky-800 font-semibold mt-5 transition-all duration-300 ease-in-out group">
                    <span class="icons bg-white group-hover:bg-sky-800 mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/login.svg');"></span>Login
                </button>
                <p>Don't have an account? <span class="cursor-pointer text-blue-700 font-medium underline"><a href="{{ route('signup.form') }}">Sign up</a></span></p>
            </div>
        </form>
    </div>

    @if(session('success'))
    <div id="success-message" class="success fixed bottom-0 left-0 m-4 z-50">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded m-6 flex justify-center items-center gap-5">
            {{ session('success') }}
            <button id="message-close" class="group text-lg text-green-700 hover:text-green-500 flex justify-center items-center">
                <span class="icon bg-green-700 transition-all duration-300 ease-in-out group-hover:bg-[#485349]" style="--svg: url('https://api.iconify.design/lets-icons/close-round-duotone.svg'); --size: 20px; --icon-color: white;"></span>
            </button>
        </div>
    </div>
    @endif
</section>
@endsection