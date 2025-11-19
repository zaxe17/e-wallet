@extends('main')
@section('title', 'Sign in')
@section('content')
@include('component.navbar')
@include('component.homebg')
<section class="container mx-auto h-screen p-15 flex items-center justify-center relative">
    <div class="w-1/2 bg-[rgba(255,255,255,0.15)] rounded-2xl form-shadow backdrop-blur-sm border border-solid border-[rgba(255,255,255,0.25)] p-10 opacity-0 form">
        <h1 class="text-3xl mb-5 lato font-semibold">Account Information</h1>
        <form action="" method="post" id="accountForm" class="needs-validation" novalidate>
            @csrf
            <div class="flex flex-col gap-4">
                {{-- FULLNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">First Name</label>
                        <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your first name.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Middle Name</label>
                        <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none">
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your middle name.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Last Name</label>
                        <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your last name.</span>
                    </div>
                </div>
                {{-- BIRTHDATE, AGE, SEX --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Date of Birth</label>
                        <input type="date" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your date of birth.</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col">
                            <label for="" class="text-sm font-bold ml-1.5">Age</label>
                            <input type="number" id="" name="" placeholder="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your age.</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-bold ml-1.5">Sex</label>
                            <div class="flex items-center gap-2 h-8">
                                <div class="flex-1">
                                    <input type="radio" id="male" name="sex" value="Male" class="peer hidden" required />
                                    <label for="male" class="w-full h-8 bg-white/30 font-medium py-1 flex justify-center items-center backdrop-blur-[15px] input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Male</label>
                                </div>
                                <div class="flex-1">
                                    <input type="radio" id="female" name="sex" value="Female" class="peer hidden" />
                                    <label for="female" class="w-full h-8 bg-white/30 font-medium py-1 flex justify-center items-center backdrop-blur-[15px] input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Female</label>
                                </div>
                            </div>
                            <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Select your sex.</span>
                        </div>
                    </div>
                </div>
                {{-- CITIZENSHIP, OCUPATION, USERNAME, CONNECTED_BANK --}}
                <div class="grid grid-cols-4 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Citizenship</label>
                        <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your citizenship.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Ocupation</label>
                        <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your ocupation.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Username</label>
                        <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your username.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Connected Bank</label>
                        <select id="connected_bank" name="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            <option value="" disabled selected>Select Bank</option>
                            <option value="BDO Unibank, Inc.">BDO Unibank, Inc.</option>
                            <option value="Land Bank of the Philippines">Land Bank of the Philippines</option>
                            <option value="Bank of the Philippine Islands (BPI)">Bank of the Philippine Islands (BPI)</option>
                            <option value="Metropolitan Bank & Trust Company (Metrobank)">Metropolitan Bank & Trust Company (Metrobank)</option>
                            <option value="China Banking Corporation (Chinabank)">China Banking Corporation (Chinabank)</option>
                            <option value="Rizal Commercial Banking Corporation (RCBC)">Rizal Commercial Banking Corporation (RCBC)</option>
                            <option value="Security Bank Corporation">Security Bank Corporation</option>
                            <option value="Philippine National Bank (PNB)">Philippine National Bank (PNB)</option>
                            <option value="Development Bank of the Philippines (DBP)">Development Bank of the Philippines (DBP)</option>
                            <option value="Union Bank of the Philippines (UnionBank)">Union Bank of the Philippines (UnionBank)</option>
                            <option value="Other">Other</option>
                        </select>
                        <input type="text" id="other_bank" name="" placeholder="Please specify your bank" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none mt-2 hidden" />
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Select your bank.</span>
                    </div>
                </div>
                {{-- CONTANCTS --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Phone Number</label>
                        <input type="number" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your phone number.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">Email Address</label>
                        <input type="email" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your email address.</span>
                    </div>
                </div>
                {{-- ADDRESS --}}
                <div class="flex flex-col">
                    <label for="" class="text-sm font-bold ml-1.5">Address</label>
                    <input type="text" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your address.</span>
                </div>
                {{-- ID TYPE, ID NUMBER --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">ID Type</label>
                        <select id="" name="" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
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
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Select your ID type.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-bold ml-1.5">ID Number</label>
                        <input type="number" id="" name="" placeholder="" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs ml-1.5 hidden error-msg">Enter your ID number.</span>
                    </div>
                </div>
            </div>
            {{-- SUBMIT BUTTON --}}
            <div class="flex justify-center">
                <button type="submit" class="w-1/5 flex justify-center items-center bg-sky-600 hover:bg-sky-400 px-5 py-2 rounded-full text-sm text-white hover:text-sky-800 font-semibold mt-5 transition-all duration-300 ease-in-out group"><span class="icons bg-white group-hover:bg-sky-800 mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/save.svg');"></span>Save</button>
            </div>

        </form>
    </div>
</section>
@endsection