@extends('main')
@section('title', 'Login')
@section('content')
<section class="container mx-auto h-screen p-15 flex items-center justify-center gap-20 relative">
    <div class="w-1/3 text-center">
        <h1 class="text-2xl leading-0 opacity-0 title">Welcome Back To</h1>
        <h2 class="text-9xl mb-12 heading opacity-0 title">E-wallet</h2>
        <p class="opacity-0 subtitle">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
    </div>
    <div class="w-1/3 bg-[rgba(255, 255, 255, 0.18)] rounded-2xl form-shadow backdrop-blur-sm p-10 opacity-0 form">
        <h1 class="text-4xl mb-5 heading font-semibold">Sign in</h1>
        <form action="" method="post" id="accountForm" class="needs-validation" novalidate>
            @csrf
            <div class="flex flex-col gap-2">
                <div class="flex flex-col gap-2">
                    <div class="relative my-2 mx-0 flex flex-col">
                        <div class="border-b border-solid border-b-black">
                            <input type="text" id="" name="" placeholder="" class="peer w-full h-10 text-sm py-0 px-1 bg-transparent outline-none invalid:ring-0 valid:ring-0" required />
                            <label for="" class="absolute top-1/2 left-1 transform -translate-y-1/2 text-sm text-black font-semibold pointer-events-none transition-all duration-100 ease-in-out peer-focus:-top-1 peer-valid:-top-1">Email or Username</label>
                        </div>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your email or username.</span>
                    </div>
                    <div class="relative my-2 mx-0 flex flex-col">
                        <div class="border-b border-solid border-b-black">
                            <input type="text" id="" name="" placeholder="" class="peer w-full h-10 text-sm py-0 px-1 bg-transparent outline-none invalid:ring-0 valid:ring-0" required />
                            <label for="" class="absolute top-1/2 left-1 transform -translate-y-1/2 text-sm text-black font-semibold pointer-events-none transition-all duration-100 ease-in-out peer-focus:-top-1 peer-valid:-top-1">Password</label>
                        </div>
                        <span class="text-red-500 mt-1 text-xs hidden error-msg">Enter your password.</span>
                    </div>
                </div>
            </div>
            {{--SUBMIT BUTTON --}}
            <button type="submit" class="w-full flex justify-center items-center bg-sky-600 hover:bg-sky-400 px-5 py-2 rounded-lg text-sm text-white hover:text-sky-800 font-semibold mt-5 transition-all duration-300 ease-in-out group"><span class="icons bg-white group-hover:bg-sky-800 mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/material-symbols/login.svg');"></span>Login</button>
            <div class="mt-10">
                <p>Don't have an account? <span class="cursor-pointer text-blue-700 font-medium underline"><a href="{{ route('signupForm') }}">Sign up</a></span></p>
            </div>
        </form>
    </div>
</section>
@endsection