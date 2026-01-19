<!-- sidebar -->
<aside class="w-60 ml-4 my-4 rounded-2xl h-[calc(100vh - 32px)]">
    <!-- sidebar-header -->
    <header class="flex items-center justify-between px-3 py-5">
        <!-- header-logo -->
        <a href="" class="flex items-center gap-2">
            <p class="text-white font-bold text-xl lato">Ban<span class="text-[#0F2F1F]">KO</span></p>
        </a>
    </header>

    <!-- sidebar-nav -->
    <nav class="">
        <!-- nav-list primary-nav -->
        <ul class="list-none flex flex-col gap-1 px-0 py-3.5">
            <li class="">
                <!-- nav-link -->
                <a href="{{ route('dashboard.index') }}" class="group no-underline px-3 py-3.5 flex items-center gap-3 rounded-l-lg transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'dashboard.index' ? 'bg-white text-[#485349]' : 'hover:bg-white hover:text-[#485349] text-white' }}">
                    <!-- nav-icon -->
                    <span class="icon transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'dashboard.index' ? 'bg-[#485349]' : 'group-hover:bg-[#485349] bg-white' }}" style="--svg: url('https://api.iconify.design/tdesign/dashboard-1.svg'); --size: 20px; --icon-color: white;"></span>
                    <!-- nav-label -->
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="">
                <!-- nav-link -->
                <a href="{{ route('earnings.index') }}" class="group no-underline px-3 py-3.5 flex items-center gap-3 rounded-l-lg transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'earnings.index' ? 'bg-white text-[#485349]' : 'hover:bg-white hover:text-[#485349] text-white' }}">
                    <!-- nav-icon -->
                    <span class="icon transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'earnings.index' ? 'bg-[#485349]' : 'group-hover:bg-[#485349] bg-white' }}" style="--svg: url('https://api.iconify.design/clarity/coin-bag-line.svg'); --size: 20px; --icon-color: white;"></span>
                    <!-- nav-label -->
                    <span>Earnings</span>
                </a>
            </li>
            <li class="">
                <!-- nav-link -->
                <a class="{{ trim($__env->yieldContent('title')) !== 'Savings' ? 'openPinModalBtn' : '' }} group no-underline px-3 py-3.5 flex items-center gap-3 rounded-l-lg transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'savings.index' ? 'bg-white text-[#485349]' : 'hover:bg-white hover:text-[#485349] text-white' }}">
                    <!-- nav-icon -->
                    <span class="icon transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'savings.index' ? 'bg-[#485349]' : 'group-hover:bg-[#485349] bg-white' }}" style="--svg: url('https://api.iconify.design/tdesign/saving-pot.svg'); --size: 20px; --icon-color: white;"></span>
                    <!-- nav-label -->
                    <span>Savings</span>
                </a>
            </li>
            <li class="">
                <!-- nav-link -->
                <a href="{{ route('expenses.index') }}" class="group no-underline px-3 py-3.5 flex items-center gap-3 rounded-l-lg transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'expenses.index' ? 'bg-white text-[#485349]' : 'hover:bg-white hover:text-[#485349] text-white' }}">
                    <!-- nav-icon -->
                    <span class="icon transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'expenses.index' ? 'bg-[#485349]' : 'group-hover:bg-[#485349] bg-white' }}" style="--svg: url('https://api.iconify.design/icon-park/expenses.svg'); --size: 20px; --icon-color: white;"></span>
                    <!-- nav-label -->
                    <span>Expenses</span>
                </a>
            </li>
            <li class="">
                <!-- nav-link -->
                <a href="{{ route('history.index') }}" class="group no-underline px-3 py-3.5 flex items-center gap-3 rounded-l-lg transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'history.index' ? 'bg-white text-[#485349]' : 'hover:bg-white hover:text-[#485349] text-white' }}">
                    <!-- nav-icon -->
                    <span class="icon transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'history.index' ? 'bg-[#485349]' : 'group-hover:bg-[#485349] bg-white' }}" style="--svg: url('https://api.iconify.design/icon-park/history.svg'); --size: 20px; --icon-color: white;"></span>
                    <!-- nav-label -->
                    <span>History</span>
                </a>
            </li>
        </ul>

        <!-- nav-list secondary-nav -->
        <ul class="list-none flex flex-col gap-1 px-0 py-3.5">
            <!-- nav-item -->
            <li class="">
                <!-- nav-link -->
                <a href="{{ route('settings.index') }}" class="group no-underline px-3 py-3.5 flex items-center gap-3 rounded-l-lg transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'settings.index' ? 'bg-white text-[#485349]' : 'hover:bg-white hover:text-[#485349] text-white' }}">
                    <!-- nav-icon -->
                    <span class="icon transition-all duration-300 ease-in-out {{ Route::currentRouteName() == 'settings.index' ? 'bg-[#485349]' : 'group-hover:bg-[#485349] bg-white' }}" style="--svg: url('https://api.iconify.design/lucide/settings.svg'); --size: 20px; --icon-color: white;"></span>
                    <!-- nav-label -->
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>