<?php
$admin_name = $_SESSION['name'] ?? 'Gardener';
$admin_initials = strtoupper(substr($admin_name, 0, 1));
if (strpos($admin_name, ' ') !== false) {
    $name_parts = explode(" ", $admin_name);
    $admin_initials = strtoupper(substr($name_parts[0], 0, 1) . substr($name_parts[1], 0, 1));
}

$admin_avatar = "../../img/bg-img/team2.png";
?>

<header class="navbar w-full absolute inset-x-0 top-0 z-50 p-6 lg:px-8">
    <div class="mx-2 flex-1 px-2">
        <div class="flex items-center gap-2 lg:flex-1">
            <img class="h-8 w-auto" src="../../img/core-img/leaf.png" alt="GreenWorld Logo">
            <div class="flex flex-col items-start gap-1">
                <div class="flex items-baseline gap-[2px]">
                    <span class="text-primary font-extrabold text-xl">GREEN</span>
                    <span class="text-accent font-semibold text-xl">WORLD</span>
                </div>
                <hr class="w-full border border-white" />
                <span class="text-sm text-white/70 italic">Your one-stop solution for all your gardening needs</span>
            </div>
        </div>
    </div>

    <div class="hidden gap-4 lg:flex lg:flex-1 lg:justify-end items-center">
        <!-- Theme Selector -->
        <div class="dropdown dropdown-left">
            <div tabindex="0" role="button" class="btn h-14">
                <i class="fa-regular fa-sun"></i>
                <svg width="12px" height="12px" class="inline-block h-2 w-2 fill-current opacity-60"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2048 2048">
                    <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
                </svg>
            </div>
            <ul tabindex="0"
                class="dropdown-content bg-base-300 rounded-box z-[1] w-52 p-2 h-52 overflow-y-auto shadow-2xl">
                <?php
                $themes = [
                    "light",
                    "dark",
                    "cupcake",
                    "bumblebee",
                    "emerald",
                    "corporate",
                    "synthwave",
                    "retro",
                    "cyberpunk",
                    "valentine",
                    "halloween",
                    "garden",
                    "forest",
                    "aqua",
                    "lofi",
                    "pastel",
                    "fantasy",
                    "wireframe",
                    "black",
                    "luxury",
                    "dracula",
                    "cmyk",
                    "autumn",
                    "business",
                    "acid",
                    "lemonade",
                    "night",
                    "coffee",
                    "winter",
                    "dim",
                    "nord",
                    "sunset"
                ];
                foreach ($themes as $theme) {
                    echo '<li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="' . ucfirst($theme) . '" value="' . $theme . '" /></li>';
                }
                ?>
            </ul>
        </div>

        <!-- Admin Profile Dropdown -->
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost h-14 flex items-center">
                <img src="<?= $admin_avatar; ?>" alt="avatar" class="rounded-full h-14 w-14" />
            </div>
            <ul tabindex="0" class="dropdown-content items-center menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                <div
                    class="bg-primary text-primary-content rounded-full w-14 h-14 flex justify-center items-center text-lg font-bold py-2">
                    <?= $admin_initials; ?>
                </div>
                <p class="text-center font-bold mt-2"><?= htmlspecialchars($admin_name); ?></p>
                <hr class="border border-base-content w-full my-2" />
                <div class="w-full">
                    <li class="text-base uppercase text-center"><a href="/gardeningstore/views/gardener/">Dashboard</a>
                    </li>
                    <li class="text-base uppercase text-center"><a
                            href="/gardeningstore/views/gardener/profile.php">Profile</a></li>
                    <li class="text-base uppercase text-center"><a
                            href="/gardeningstore/server/auth/logout.php">Logout</a>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</header>