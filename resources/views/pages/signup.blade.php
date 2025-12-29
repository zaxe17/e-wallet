@extends('main')
@section('title', 'Sign up')
@section('content')
@include('component.navbar')
@include('component.homebg')
<section class="container mx-auto h-screen p-15 flex items-center justify-center relative">
    <div class="w-1/2 bg-[rgba(255,255,255,0.15)] rounded-2xl form-shadow form-animation backdrop-blur-sm border border-solid border-[rgba(255,255,255,0.25)] p-10 opacity-0 form">
        <h1 class="text-3xl text-[#4A5A4D] mb-5 lato-bold font-semibold">Account Information</h1>
        <form action="{{ route('signup.store') }}" method="POST" id="accountForm" novalidate>
            @csrf
            <div class="flex flex-col gap-4">
                {{-- FULLNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="first_name" class="text-sm font-bold ml-1.5">First Name</label>
                        <input type="text" id="first_name" oninput="capitalizeInput(this)" name="first_name" value="{{ old('first_name') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('first_name')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="middle_name" class="text-sm font-bold ml-1.5">Middle Name</label>
                        <input type="text" id="middle_name" oninput="capitalizeInput(this)" name="middle_name" value="{{ old('middle_name') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label for="last_name" class="text-sm font-bold ml-1.5">Last Name</label>
                        <input type="text" id="last_name" oninput="capitalizeInput(this)" name="last_name" value="{{ old('last_name') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('last_name')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- BIRTHDATE, AGE, SEX --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="date_of_birth" class="text-sm font-bold ml-1.5">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('date_of_birth')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col">
                            <label for="age" class="text-sm font-bold ml-1.5">Age</label>
                            <input type="number" id="age" name="age" value="{{ old('age') }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required readonly>
                            @error('age')
                            <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-bold ml-1.5">Sex</label>
                            <div class="flex items-center gap-2 h-8">
                                <div class="flex-1">
                                    <input type="radio" id="male" name="sex" value="Male" {{ old('sex') == 'Male' ? 'checked' : '' }} class="peer sr-only" required />
                                    <label for="male" class="w-full h-8 bg-white/30 font-medium py-1 flex justify-center items-center backdrop-blur-[15px] input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Male</label>
                                </div>
                                <div class="flex-1">
                                    <input type="radio" id="female" name="sex" value="Female" {{ old('sex') == 'Female' ? 'checked' : '' }} class="peer sr-only" />
                                    <label for="female" class="w-full h-8 bg-white/30 font-medium py-1 flex justify-center items-center backdrop-blur-[15px] input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Female</label>
                                </div>
                            </div>
                            @error('sex')
                            <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- CITIZENSHIP, USERNAME --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="citizenship" class="text-sm font-bold ml-1.5">Citizenship</label>
                        <input type="text" id="citizenship" oninput="capitalizeInput(this)" name="citizenship" value="{{ old('citizenship') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('citizenship')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="username" class="text-sm font-bold ml-1.5">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('username')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- ADDRESS --}}
                <div class="flex flex-col">
                    <label for="address" class="text-sm font-bold ml-1.5">Address</label>
                    <input type="text" id="address" oninput="capitalizeInput(this)" name="address" value="{{ old('address') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    @error('address')
                    <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                    @enderror
                </div>

                {{-- CONTACTS --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="phone_number" class="text-sm font-bold ml-1.5">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('phone_number')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="email_address" class="text-sm font-bold ml-1.5">Email Address</label>
                        <input type="email" id="email_address" name="email_address" value="{{ old('email_address') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('email_address')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="flex justify-center">
                    <button type="submit" class="cursor-pointer w-1/5 flex justify-center items-center bg-[#7FB89A] hover:bg-[#6AA887] px-5 py-2 rounded-full text-sm text-[#0F2F1F] hover:text-[#FFFFFF] font-semibold mt-5 transition-all duration-300 ease-in-out group">
                        <span class="icons bg-[#0F2F1F] group-hover:bg-[#FFFFFF] mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/save.svg');"></span>Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection