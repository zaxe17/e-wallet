<header class="fixed top-0 left-0 w-full bg-fuchsia-100 nav-shadow z-50 text-sm flex justify-center">
    <div class="container flex justify-between items-center px-20 py-3">
        <div class="">
            <p>E-wallet</p>
        </div>
        <nav>
            <ul class="flex flex-row gap-5">
                <li><a href="/#">Home</a></li>
                <li><a href="/#about">About</a></li>
                <li><a href="/#teams">Teams</a></li>
            </ul>
        </nav>
        <div class="flex items-center justify-center flex-row gap-6">
            <a href="{{ route('signup.form') }}" class="bg-fuchsia-300 hover:bg-fuchsia-400 transition-all duration-300 ease-in-out px-4 py-2 rounded-full">Sign Up</a>
            <a href="{{ route('login.form') }}">Login</a>
        </div>
    </div>
</header>