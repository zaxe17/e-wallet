@php
    use Illuminate\Support\Facades\Session;
    $fullName = Session::get('full_name', 'User');
    
    // Split the full name into parts
    $nameParts = explode(' ', $fullName);
    
    // Format the name with middle initial
    if (count($nameParts) == 4) {
        // Assuming format: FirstName SecondName MiddleName LastName
        $firstName = $nameParts[0];
        $secondName = $nameParts[1];
        $middleInitial = strtoupper(substr($nameParts[2], 0, 1)) . '.';
        $lastName = $nameParts[3];
        $displayName = $firstName . ' ' . $secondName . ' ' . $middleInitial . ' ' . $lastName;
    } elseif (count($nameParts) == 3) {
        // Assuming format: FirstName MiddleName LastName
        $firstName = $nameParts[0];
        $middleInitial = strtoupper(substr($nameParts[1], 0, 1)) . '.';
        $lastName = $nameParts[2];
        $displayName = $firstName . ' ' . $middleInitial . ' ' . $lastName;
    } else {
        // If different format, display as is
        $displayName = $fullName;
    }
@endphp

<header class="relative px-14 pt-10 pb-5 flex justify-between items-center">
    <h1 href="" class="text-[#323d33] text-lg lato">{{ $navtitle }}</h1>
    <div class="flex items-center justify-center gap-5 {{ trim($__env->yieldContent('title')) !== 'Settings' ? '' : 'hidden' }}">
        <span class="icon bg-black transition-all duration-300 ease-in-out group-hover:bg-[#151A2D]" style="--svg: url('https://api.iconify.design/lucide/bell.svg'); --size: 1.75rem; --icon-color: white;"></span>
        <div class="flex items-center justify-center gap-1">
            <img src="/assets/PAYNOY.png" alt="user_profile" class="w-8 object-contain rounded-full block">
            <p class="text-lg text-[#485349] lato">{{ $displayName }}</p>
        </div>
    </div>
</header>