@extends('main')
@section('title', 'Sign in')
@section('content')
<section class="container mx-auto h-screen p-15 flex items-center justify-center relative">
    <div class="w-1/2 bg-[rgba(255, 255, 255, 0.18)] rounded-2xl form-shadow backdrop-blur-[5.8px] p-10 opacity-0 form">
        <h1 class="text-3xl mb-5 heading font-semibold">Account Information</h1>
        <form action="" method="post" id="accountForm" class="needs-validation" novalidate>
            @csrf
            <div class="flex flex-col gap-2">
                {{-- FULLNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">First Name</label>
                        <input type="text" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your first name.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Middle Name</label>
                        <input type="text" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none">
                        <span class="text-red-500 text-xs hidden error-msg">Enter your middle name.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Last Name</label>
                        <input type="text" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your last name.</span>
                    </div>
                </div>
                {{-- BIRTHDATE, AGE, SEX --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Date of Birth</label>
                        <input type="date" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your date of birth.</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex flex-col">
                            <label for="" class="text-sm font-medium">Age</label>
                            <input type="number" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            <span class="text-red-500 text-xs hidden error-msg">Enter your age.</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-medium">Sex</label>
                            <div class="flex items-center gap-2 h-full">
                                <div class="flex-1">
                                    <input type="radio" id="male" name="sex" value="Male" class="peer hidden" required />
                                    <label for="male" class="w-full py-1 flex justify-center items-center bg-white/20 input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Male</label>
                                </div>
                                <div class="flex-1">
                                    <input type="radio" id="female" name="sex" value="Female" class="peer hidden" />
                                    <label for="female" class="w-full py-1 flex justify-center items-center bg-white/20 input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Female</label>
                                </div>
                            </div>
                            <span class="text-red-500 text-xs hidden error-msg">Select your sex.</span>
                        </div>
                    </div>
                </div>
                {{-- CITIZENSHIP, OCUPATION, USERNAME, CONNECTED_BANK --}}
                <div class="grid grid-cols-4 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Citizenship</label>
                        <input type="text" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your citizenship.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Ocupation</label>
                        <input type="text" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your ocupation.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Username</label>
                        <input type="text" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your username.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Connected Bank</label>
                        <select id="connected_bank" name="" class="w-full h-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
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
                        <input type="text" id="other_bank" name="" placeholder="Please specify your bank" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none mt-2 hidden" />
                        <span class="text-red-500 text-xs hidden error-msg">Enter your username.</span>
                    </div>
                </div>
                {{-- CONTANCTS --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Phone Number</label>
                        <input type="number" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your phone number.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">Email Address</label>
                        <input type="email" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your email address.</span>
                    </div>
                </div>
                {{-- ADDRESS --}}
                <div class="flex flex-col">
                    <label for="" class="text-sm font-medium">Address</label>
                    <input type="text" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    <span class="text-red-500 text-xs hidden error-msg">Enter your address.</span>
                </div>
                {{-- ID TYPE, ID NUMBER --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">ID Type</label>
                        <select id="" name="" class="w-full h-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
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
                        <span class="text-red-500 text-xs hidden error-msg">Select your ID type.</span>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="text-sm font-medium">ID Number</label>
                        <input type="number" id="" name="" placeholder="" class="w-full bg-white/20 rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        <span class="text-red-500 text-xs hidden error-msg">Enter your ID number.</span>
                    </div>
                </div>
            </div>
            {{--SUBMIT BUTTON --}}
            <button type="submit" class="flex items-center bg-sky-600 hover:bg-sky-400 px-5 py-2 rounded-full text-sm text-white hover:text-sky-800 font-semibold mt-5 transition-all duration-300 ease-in-out group"><span class="icons bg-white group-hover:bg-sky-800 mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/save.svg');"></span>Save</button>
        </form>
    </div>
</section>
@endsection