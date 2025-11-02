@extends('main')
@section('title', 'Sign in')
@section('content')
<section class="container mx-auto h-screen px-8 flex items-center justify-center relative">
    <div class="w-1/2 bg-[rgba(255, 255, 255, 0.18)] rounded-2xl form-shadow backdrop-blur-[5.8px] p-10">
        <h1 class="text-3xl mb-5">Account Information</h1>
        <form action="" method="post">
            @csrf
            <div class="flex flex-col gap-2">
                {{-- FULLNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">First Name</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Middle Name</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Last Name</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                </div>
                {{-- BIRTHDATE, AGE, SEX --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Date of Birth</label>
                        <input name="" type="date" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col">
                            <label for="" class="text-sm font-medium">Age</label>
                            <input name="" type="number" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label for="" class="text-sm font-medium">Sex</label>
                            <div class="flex items-center gap-3">
                                <label class="flex items-center gap-1 cursor-pointer">
                                    <input type="radio" name="sex" value="Male" class="accent-fuchsia-200"
                                        required />
                                    <span class="text-sm">Male</span>
                                </label>

                                <label class="flex items-center gap-1 cursor-pointer">
                                    <input type="radio" name="sex" value="Female" class="accent-fuchsia-200" />
                                    <span class="text-sm">Female</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- CITIZENSHIP, OCUPATION, USERNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Citizenship</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Ocupation</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Username</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                </div>
                {{-- ID TYPE, ID NUMBER --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">ID Type</label>
                        <select name="" id="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            <option value="" disabled selected>Select ID type</option>
                            <option value="National ID">National ID</option>
                            <option value="Passport">Passport</option>
                            <option value="Driver's License">Driver's License</option>
                            <option value="Philippine Postal ID">Philippine Postal ID</option>
                            <option value="PRC ID">PRC ID</option>
                            <option value="UMID">UMID</option>
                            <option value="SSS ID">SSS ID</option>
                            <option value="HDMF ID">HDMF ID</option>
                            <option value="Student ID">Student ID</option>
                            <option value="Special Resident Retiree's Visa">Special Resident Retiree's Visa</option>
                            <option value="Government Office/GOCC ID">Government Office/GOCC ID</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">ID Number</label>
                        <input name="" type="number" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                </div>
                {{-- ADDRESS --}}
                <div class="flex flex-col">
                    <label for="" class="text-sm font-medium">Address</label>
                    <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                </div>
                {{-- CONTANCTS --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Phone Number</label>
                        <input name="" type="number" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Email Address</label>
                        <input name="" type="email" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    </div>
                </div>
            </div>
            {{--SUBMIT BUTTON --}}
            <button type="submit" class="flex items-center bg-sky-600 hover:bg-sky-400 px-5 py-2 rounded-full text-sm text-white hover:text-sky-800 font-semibold mt-5 transition-all duration-300 ease-in-out group"><span class="icons bg-white group-hover:bg-sky-800 mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/save.svg');"></span>Save</button>
        </form>
    </div>
</section>
@endsection