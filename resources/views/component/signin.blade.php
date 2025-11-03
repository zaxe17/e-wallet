@extends('main')
@section('title', 'Sign in')
@section('content')
<section class="container mx-auto h-screen p-15 flex items-center justify-center relative">
    <div class="bg-[rgba(255, 255, 255, 0.18)] rounded-2xl form-shadow backdrop-blur-[5.8px] p-10 opacity-0 form">
        <h1 class="text-3xl mb-5 heading font-semibold">Account Information</h1>
        <form action="" method="post" id="accountForm" class="needs-validation" novalidate>
            @csrf
            <div class="flex flex-col gap-2">
                {{-- FULLNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">First Name</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your first name.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Middle Name</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none">
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your middle name.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Last Name</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your last name.</span>
                    </div>
                </div>
                {{-- BIRTHDATE, AGE, SEX --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Date of Birth</label>
                        <input name="" type="date" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your date of birth.</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col">
                            <label for="" class="text-sm font-medium">Age</label>
                            <input name="" type="number" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                            <span class="text-red-500 text-xs hidden error-msg">Please enter your age.</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-medium">Sex</label>
                            <div class="flex items-center gap-2">
                                <div class="flex-1">
                                    <input name="sex" type="radio" id="male" value="Male" class="peer hidden" required />
                                    <label for="male" class="flex justify-center items-center bg-white/40 input-shadow px-4 py-1 rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Male</label>
                                </div>

                                <div class="flex-1">
                                    <input name="sex" type="radio" id="female" value="Female" class="peer hidden" />
                                    <label for="female" class="flex justify-center items-center bg-white/40 input-shadow px-4 py-1 rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Female</label>
                                </div>
                            </div>
                            <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                            <span class="text-red-500 text-xs hidden error-msg">Please select your sex.</span>
                        </div>
                    </div>
                </div>
                {{-- CITIZENSHIP, OCUPATION, USERNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Citizenship</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your citizenship.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Ocupation</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your ocupation.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Username</label>
                        <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your username.</span>
                    </div>
                </div>
                {{-- ID TYPE, ID NUMBER --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">ID Type</label>
                        <select name="" id="" class="w-full h-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
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
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please select your ID type.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">ID Number</label>
                        <input name="" type="number" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your ID number.</span>
                    </div>
                </div>
                {{-- ADDRESS --}}
                <div class="flex flex-col">
                    <label for="" class="text-sm font-medium">Address</label>
                    <input name="" type="text" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                    <span class="text-red-500 text-xs hidden error-msg">Please enter your address.</span>
                </div>
                {{-- CONTANCTS --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Phone Number</label>
                        <input name="" type="number" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your phone number.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Email Address</label>
                        <input name="" type="email" id="" placeholder="" class="w-full bg-white/40 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-emerald-500 text-xs hidden success-msg">Looks good!</span>
                        <span class="text-red-500 text-xs hidden error-msg">Please enter your email address.</span>
                    </div>
                </div>
            </div>
            {{--SUBMIT BUTTON --}}
            <button type="submit" class="flex items-center bg-sky-600 hover:bg-sky-400 px-5 py-2 rounded-full text-sm text-white hover:text-sky-800 font-semibold mt-5 transition-all duration-300 ease-in-out group"><span class="icons bg-white group-hover:bg-sky-800 mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/save.svg');"></span>Save</button>
        </form>
    </div>
</section>
@endsection