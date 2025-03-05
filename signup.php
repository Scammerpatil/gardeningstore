<!DOCTYPE html>
<html lang="en" data-theme="lemonade">
<?php include "./components/general/Header.php" ?>

<body style="font-family: Dosis, sans-serif;">
    <?php include "./components/general/Navbar.php" ?>
    <div class="hero min-h-screen relative z-10 overflow-hidden" style="">
        <form class="w-full max-w-xl bg-base-200 px-10 py-10 rounded-lg shadow-lg my-28"
            action="./server/auth/register.php" method="post">
            <div class="py-5">
                <h1 class="text-3xl font-bold text-center uppercase">Hey There, Signup and enjoy all features</h1>
                <p class="text-center text-lg py-3">Create your account to get started</p>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
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
            <div class="flex flex-wrap -mx-3 mb-6">
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
            <div class="flex flex-wrap -mx-3 mb-6">
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
            <div class="flex flex-wrap -mx-3 mb-6">
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
            <div class="w-full px-3 -mx-3 mb-6">
                <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                    for="grid-state">
                    User Type
                </label>
                <div class="relative">
                    <select
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        name="user_type" id="grid-state">
                        <option>Choose User Type</option>
                        <option value="customer">Customer</option>
                        <option value="gardener">Gardener</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-base-content">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-base-content text-base font-bold mb-2"
                        for="grid-password">
                        Password
                    </label>
                    <input
                        class="appearance-none block w-full bg-base-100 text-base-content rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-base-200 border border-base-content"
                        id="grid-password" type="password" name="password" placeholder="******************">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <button class="btn btn-primary w-full text-base"> Sign In </button>
                </div>
            </div>
            <div class="text-center">
                <span class="text-base-content text-base">Already have an account ?</span> <a href="login.php"
                    class="text-base text-primary">Login</a>
            </div>
        </form>
    </div>
</body>

</html>