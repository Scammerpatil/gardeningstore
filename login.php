<!DOCTYPE html>
<html lang="en" data-theme="lemonade">
<?php include "./components/general/Header.php" ?>

<body style="font-family: Dosis, sans-serif;">
    <?php include "./components/general/Navbar.php" ?>
    <?php include './components/general/Hero.php' ?>
    <div class="hero min-h-screen relative z-10 overflow-hidden" style="">
        <form class="w-full max-w-xl bg-base-200 px-10 py-10 rounded-lg shadow-lg my-28"
            action="./server/auth/login.php" method="post">
            <div class="py-5">
                <h1 class="text-3xl font-bold text-center uppercase">Welcome Back, Login to Access Your Account</h1>
                <p class="text-center text-lg py-3">Enter your credentials to continue.</p>
            </div>
            <div class="w-full mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="grid-email">
                        Email
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="grid-email" type="email" name="email" placeholder="Enter Your Email">
                </div>
            </div>
            <input type="hidden" name="user_type" value="<?php echo $userType; ?>">
            <div class="w-full mb-6">
                <div class="w-full px-3 relative">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="grid-password">
                        Password
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="grid-password" type="password" name="password" placeholder="******************">
                    <button type="button" id="togglePassword"
                        class="pointer-events-auto absolute inset-y-0 right-4 top-8 flex items-center px-2 text-base-content">
                        <i class="fa-solid fa-eye" id="icon-password"></i>
                    </button>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <button class="btn btn-primary w-full text-base"> Login</button>
                </div>
            </div>
            <div class="text-center">
                <span class="text-base-content text-base">Already have an account ?</span> <a href="login.php"
                    class="text-base text-primary">Login</a>
            </div>
        </form>
    </div>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#grid-password');
        const iconPassword = document.querySelector('#icon-password');
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            iconPassword.classList.toggle('fa-eye-slash');
            iconPassword.classList.toggle('fa-eye');
        });
    </script>
</body>

</html>