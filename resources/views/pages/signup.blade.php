@extends('main')
@section('title', 'Sign up')
@section('content')
@include('component.navbar')
@include('component.homebg')
<section class="container mx-auto h-screen p-15 flex items-center justify-center relative">
    <div class="w-1/2 bg-[rgba(255,255,255,0.15)] rounded-2xl form-shadow backdrop-blur-sm border border-solid border-[rgba(255,255,255,0.25)] p-10 opacity-0 form">
        <h1 class="text-3xl mb-5 lato font-semibold">Account Information</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('signup.store') }}" method="POST" id="accountForm">
            @csrf
            <div class="flex flex-col gap-4">
                {{-- FULLNAME --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="flex flex-col">
                        <label for="first_name" class="text-sm font-bold ml-1.5">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('first_name')
                            <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="middle_name" class="text-sm font-bold ml-1.5">Middle Name</label>
                        <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none">
                    </div>
                    <div class="flex flex-col">
                        <label for="last_name" class="text-sm font-bold ml-1.5">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
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
                            <input type="number" id="age" name="age" value="{{ old('age') }}" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            @error('age')
                                <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col">
                            <label class="text-sm font-bold ml-1.5">Sex</label>
                            <div class="flex items-center gap-2 h-8">
                                <div class="flex-1">
                                    <input type="radio" id="male" name="sex" value="Male" {{ old('sex') == 'Male' ? 'checked' : '' }} class="peer hidden" required />
                                    <label for="male" class="w-full h-8 bg-white/30 font-medium py-1 flex justify-center items-center backdrop-blur-[15px] input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Male</label>
                                </div>
                                <div class="flex-1">
                                    <input type="radio" id="female" name="sex" value="Female" {{ old('sex') == 'Female' ? 'checked' : '' }} class="peer hidden" />
                                    <label for="female" class="w-full h-8 bg-white/30 font-medium py-1 flex justify-center items-center backdrop-blur-[15px] input-shadow rounded-md transition-all duration-300 ease-in-out hover:bg-sky-600 hover:text-white peer-checked:bg-sky-600 peer-checked:text-white cursor-pointer text-sm">Female</label>
                                </div>
                            </div>
                            @error('sex')
                                <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                {{-- CITIZENSHIP, OCCUPATION, USERNAME, CONNECTED_BANK --}}
                <div class="grid grid-cols-4 gap-2">
                    <div class="flex flex-col">
                        <label for="citizenship" class="text-sm font-bold ml-1.5">Citizenship</label>
                        <input type="text" id="citizenship" name="citizenship" value="{{ old('citizenship') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('citizenship')
                            <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="occupation" class="text-sm font-bold ml-1.5">Occupation</label>
                        <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('occupation')
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
                    <div class="flex flex-col">
                        <label for="connected_bank" class="text-sm font-bold ml-1.5">Connected Bank</label>
                        <select id="connected_bank" name="connected_bank" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            <option value="" disabled {{ old('connected_bank') ? '' : 'selected' }}>Select Bank</option>
                            <option value="BDO Unibank, Inc." {{ old('connected_bank') == 'BDO Unibank, Inc.' ? 'selected' : '' }}>BDO Unibank, Inc.</option>
                            <option value="Land Bank of the Philippines" {{ old('connected_bank') == 'Land Bank of the Philippines' ? 'selected' : '' }}>Land Bank of the Philippines</option>
                            <option value="Bank of the Philippine Islands (BPI)" {{ old('connected_bank') == 'Bank of the Philippine Islands (BPI)' ? 'selected' : '' }}>Bank of the Philippine Islands (BPI)</option>
                            <option value="Metropolitan Bank & Trust Company (Metrobank)" {{ old('connected_bank') == 'Metropolitan Bank & Trust Company (Metrobank)' ? 'selected' : '' }}>Metropolitan Bank & Trust Company (Metrobank)</option>
                            <option value="China Banking Corporation (Chinabank)" {{ old('connected_bank') == 'China Banking Corporation (Chinabank)' ? 'selected' : '' }}>China Banking Corporation (Chinabank)</option>
                            <option value="Rizal Commercial Banking Corporation (RCBC)" {{ old('connected_bank') == 'Rizal Commercial Banking Corporation (RCBC)' ? 'selected' : '' }}>Rizal Commercial Banking Corporation (RCBC)</option>
                            <option value="Security Bank Corporation" {{ old('connected_bank') == 'Security Bank Corporation' ? 'selected' : '' }}>Security Bank Corporation</option>
                            <option value="Philippine National Bank (PNB)" {{ old('connected_bank') == 'Philippine National Bank (PNB)' ? 'selected' : '' }}>Philippine National Bank (PNB)</option>
                            <option value="Development Bank of the Philippines (DBP)" {{ old('connected_bank') == 'Development Bank of the Philippines (DBP)' ? 'selected' : '' }}>Development Bank of the Philippines (DBP)</option>
                            <option value="Union Bank of the Philippines (UnionBank)" {{ old('connected_bank') == 'Union Bank of the Philippines (UnionBank)' ? 'selected' : '' }}>Union Bank of the Philippines (UnionBank)</option>
                            <option value="Other" {{ old('connected_bank') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <input type="text" id="other_bank" name="other_bank" value="{{ old('other_bank') }}" placeholder="Please specify your bank" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none mt-2 hidden" />
                        @error('connected_bank')
                            <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
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
                
                {{-- ADDRESS --}}
                <div class="flex flex-col">
                    <label for="address" class="text-sm font-bold ml-1.5">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                    @error('address')
                        <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                    @enderror
                </div>
                
                {{-- ID TYPE, ID NUMBER --}}
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <label for="id_type" class="text-sm font-bold ml-1.5">ID Type</label>
                        <select id="id_type" name="id_type" class="w-full h-8 bg-white/30 backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                            <option value="" disabled {{ old('id_type') ? '' : 'selected' }}>Select ID type</option>
                            <option value="National ID" {{ old('id_type') == 'National ID' ? 'selected' : '' }}>National ID</option>
                            <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                            <option value="Driver's License" {{ old('id_type') == "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                            <option value="Philippine Postal ID" {{ old('id_type') == 'Philippine Postal ID' ? 'selected' : '' }}>Philippine Postal ID</option>
                            <option value="PRC ID" {{ old('id_type') == 'PRC ID' ? 'selected' : '' }}>PRC ID</option>
                            <option value="UMID" {{ old('id_type') == 'UMID' ? 'selected' : '' }}>UMID</option>
                            <option value="SSS ID" {{ old('id_type') == 'SSS ID' ? 'selected' : '' }}>SSS ID</option>
                            <option value="HDMF ID" {{ old('id_type') == 'HDMF ID' ? 'selected' : '' }}>HDMF ID</option>
                            <option value="Student ID" {{ old('id_type') == 'Student ID' ? 'selected' : '' }}>Student ID</option>
                            <option value="Special Resident Retiree's Visa" {{ old('id_type') == "Special Resident Retiree's Visa" ? 'selected' : '' }}>Special Resident Retiree's Visa</option>
                            <option value="Government Office/GOCC ID" {{ old('id_type') == 'Government Office/GOCC ID' ? 'selected' : '' }}>Government Office/GOCC ID</option>
                        </select>
                        @error('id_type')
                            <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="id_number" class="text-sm font-bold ml-1.5">ID Number</label>
                        <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}" class="w-full h-8 bg-white/30 font-medium backdrop-blur-[15px] rounded-md input-shadow px-2 py-1 text-sm focus:outline-none" required>
                        @error('id_number')
                            <span class="text-red-500 text-xs ml-1.5">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            {{-- SUBMIT BUTTON --}}
            <div class="flex justify-center">
                <button type="submit" class="w-1/5 flex justify-center items-center bg-sky-600 hover:bg-sky-400 px-5 py-2 rounded-full text-sm text-white hover:text-sky-800 font-semibold mt-5 transition-all duration-300 ease-in-out group">
                    <span class="icons bg-white group-hover:bg-sky-800 mr-2 transition-all duration-300 ease-in-out" style="--svg: url('https://api.iconify.design/lucide/save.svg');"></span>Save
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    // Show/hide other bank input
    document.getElementById('connected_bank').addEventListener('change', function() {
        const otherBankInput = document.getElementById('other_bank');
        if (this.value === 'Other') {
            otherBankInput.classList.remove('hidden');
            otherBankInput.required = true;
        } else {
            otherBankInput.classList.add('hidden');
            otherBankInput.required = false;
            otherBankInput.value = '';
        }
    });

    // Auto-calculate age from date of birth
    document.getElementById('date_of_birth').addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }
        
        document.getElementById('age').value = age;
    });
</script>
@endsection