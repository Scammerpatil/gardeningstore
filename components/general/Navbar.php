<header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <a class="flex items-center gap-2 lg:flex-1" href="/gardeningstore/">
            <img class="h-8 w-auto" src="img/core-img/leaf.png" alt="">
            <div class="flex flex-col items-start gap-1">
                <div class="flex items-baseline gap-[2px]">
                    <span class="text-primary font-extrabold text-4xl">Modern</span>
                    <span class="text-accent font-semibold text-4xl">Nursery</span>
                </div>
                <hr class="w-full border border-white" />
                <span class="text-sm text-white/70 italic">
                    Your one-stop solution for all your gardening needs
                </span>
            </div>
        </a>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="about.php" class="text-lg font-semibold text-white hover:text-primary">ABOUT</a>
            <a href="#" class="text-lg font-semibold text-white hover:text-primary">PORTFOLIO</a>
            <a href="#" class="text-lg font-semibold text-white hover:text-primary">CONTACT</a>
            <a href="gardener.php" class="text-lg font-semibold text-white hover:text-primary">OUR GARDENER</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-2">
            <a href="login.php" class="text-lg font-semibold btn btn-success">
                <i class="fa-solid fa-right-to-bracket"></i> Login
            </a>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn text-lg font-semibold btn-success">
                    <i class="fa-solid fa-user"></i> Sign Up
                    <svg width="12px" height="12px" class="inline-block h-2 w-2 fill-current opacity-60"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2048 2048">
                        <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
                    </svg>
                </div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li class="text-base font-semibold"><a href="signup.php?user=customer">Customer</a></li>
                    <li class="text-base font-semibold"><a href="signup.php?user=gardener">Gardener</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>
