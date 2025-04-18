<?php
$userType = isset($_GET['user']) ? htmlspecialchars($_GET['user']) : 'customer';
?>
<!DOCTYPE html>
<html lang="en" data-theme="lemonade">
<?php include "./components/general/Header.php" ?>

<body style="font-family: Dosis, sans-serif;background-image:url('img/bg-img/nature.jpg'); background-size: 100%; background-position: center -50px; background-attachment: fixed;">
    <?php include "./components/general/Navbar.php" ?>
    <?php include './components/general/Hero.php' ?>
    <div class="hero min-h-screen relative z-10 overflow-hidden" style="">
        <form class="w-full max-w-xl bg-base-200 px-10 py-10 rounded-lg shadow-lg my-28"
            action="./server/auth/register.php" method="post">
            <div class="py-5">
                <h1 class="text-3xl font-bold text-center uppercase">Hey There, Signup and enjoy all features</h1>
                <p class="text-center text-lg py-3">Create your account to get started</p>
            </div>

            <div class="flex flex-wrap mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="grid-first-name">
                        Name
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="grid-first-name" type="text" name="name" placeholder="Enter Your Name">
                </div>
            </div>
            <div class="flex flex-wrap mb-6">
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
            <div class="flex flex-wrap mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="grid-phone-number">
                        Phone Number
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="grid-phone-number" type="text" name="phone" placeholder="Enter Your Phone Number">
                </div>
            </div>
            <div class="flex flex-wrap mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="grid-address">
                        Address
                    </label>
                    <textarea
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="grid-address" type="text" name="address" placeholder="Enter Your Address"></textarea>
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
                    <button class="btn btn-primary w-full text-base"> Sign Up </button>
                </div>
            </div>
            <div class="text-center">
                <span class="text-base-content text-base">Already have an account ?</span> <a
                    href="login.php?user=<?php echo $userType; ?>" class="text-base text-primary">Login</a>
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