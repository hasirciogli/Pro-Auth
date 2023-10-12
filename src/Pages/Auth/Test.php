<?php
use Hasirciogli\ProAuth\Config\DatabaseConfig;
use Hasirciogli\ProAuth\Models\LanguageModel;
use Hasirciogli\SessionWrapper\Session;
use Hasirciogli\ProAuth\Models\HashModel;

if ($_POST) {
    $ClientId = $_POST["client_id"] ?? "";
    $ClientSecret = $_POST["client_secret"] ?? "";
    $RedirectTo = $_POST["redirect_to"] ?? "";
    $Lang = $_POST["lang"] ?? "";

    $Hash = HashModel::cfun()->GenerateHashForAuthenticate($ClientId, $ClientSecret, $RedirectTo);

    $ClientId = urlencode($ClientId);
    $RedirectTo = urlencode($RedirectTo);
    $Hash = urlencode($Hash);

    $Ruri = "http://localhost:1167/proauth0/authenticate?client_id=$ClientId&redirect_to=$RedirectTo&hash=$Hash&lang=$Lang";
}

$StaticImages = "http://public-cdn.hasirciogli.com";

$Phrases = LanguageModel::cfun()->GetLanguagePhrases($_GET["lang"] ?? "tr");

$Session = new Session(DatabaseConfig::cfun());

$CsrfToken = $Session->Get("csrf-token");

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />


    <title>
        <?php echo $Phrases["auth_login_with_sitename"]; ?>
    </title>

    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <script>
        $(document).ready(() => {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
                $("#light_mode_btn")[0].classList.remove("hidden");
            } else {
                document.documentElement.classList.remove('dark')
                $("#dark_mode_btn")[0].classList.remove("hidden");
            }

            $("#dark_mode_btn").click(() => {
                document.documentElement.classList.add('dark')
                $("#dark_mode_btn")[0].classList.add("hidden");
                $("#light_mode_btn")[0].classList.remove("hidden");

                localStorage.theme = "dark";
            });

            $("#light_mode_btn").click(() => {
                document.documentElement.classList.remove('dark')
                $("#light_mode_btn")[0].classList.add("hidden");
                $("#dark_mode_btn")[0].classList.remove("hidden");

                localStorage.theme = "light";
            });
        });
    </script>

    <style>
        body * {
            @apply transition-colors duration-300;
        }
    </style>
</head>

<body class="bg-gray-200 dark:bg-zinc-800 transition-colors">
    <input type="hidden" name="csrf-token" id="csrf-token" value="<?php echo $CsrfToken; ?>">
    <div class="absolute flex w-fit h-fit top-0 right-0 z-[10] p-5 transition-colors">
        <span id="dark_mode_btn"
            class="hidden material-symbols-outlined select-none rounded-md bg-zinc-600 text-white p-[.3rem] hover:cursor-pointer hover:shadow-md shadow-sm shadow-zinc-500 hover:shadow-zinc-400 duration-200 ease-in-out">
            dark_mode
        </span>

        <span id="light_mode_btn"
            class="hidden material-symbols-outlined select-none rounded-md bg-zinc-200 text-black p-[.3rem] hover:cursor-pointer hover:shadow-md shadow-sm shadow-zinc-500 hover:shadow-zinc-400 duration-200 ease-in-out">
            light_mode
        </span>
    </div>

    <div class="flex w-full h-screen items-center justify-center z-[5] transition-colors">
        <div
            class="w-full md:w-[26rem] h-fit --min-h-[22rem] text-xs dark:text-zinc-200 bg-white text-zinc-700 dark:bg-[#272829] rounded border dark:border-zinc-600 shadow-md transition-300">
            <div class="p-[.3rem] border-b border-b-zinc-300 dark:border-b-zinc-600">
                <strong class="dark:text-zinc-300">ProAuth0</strong>
                <span class="dark:text-zinc-300">TEST SAYFASI</span>
            </div>

            <div class="w-full text-center text-2xl font-semibold font-monospace mt-10 transition-colors">
                <?php echo $Phrases["auth_welcome_back"]; ?>
            </div>

            <?php if ($_POST && $Ruri) {
                echo "<a href=\"$Ruri\">Authenticate</a>";
            } ?>

            <form method="post" action="/t" class="flex flex-col w-full h-full gap-4 mt-4 p-4 transition-colors">

                <input type="text" placeholder="client_id" name="client_id" id="client_id"
                value="63e00a9a600045babdb935d63e00a9a600045b8563e00a9a600045b935d63e00a9a0a9a1b64c"
                    class="rounded bg-transparent w-full text-sm transition-colors">
                <input type="text" placeholder="client_secret" name="client_secret" id="client_secret"
                value="63e0063e00a9a600045babdb935d63e00a9a6000063e00a9a600045babdb935d63e00a9a6000"
                    class="rounded bg-transparent w-full text-sm transition-colors">
                <input type="text" placeholder="lang" name="lang" id="lang"
                    class="rounded bg-transparent w-full text-sm transition-colors" value="tr">
                <input type="text" placeholder="redirect_to" name="redirect_to" id="redirect_to"
                    class="rounded bg-transparent w-full text-sm transition-colors" value="http://localhost:1167/t">


                <div class="flex w-full justify-end transition-colors">
                    <input id="submit-login" type="submit"
                        class="p-3 py-2 text-white dark:text-zinc-200 font-normal font-arial text-xs bg-zinc-800 dark:bg-zinc-600 hover:bg-blue-600 dark:hover:bg-blue-600 hover:cursor-pointer rounded duration-200 transition-colors"
                        value="<?php echo $Phrases["auth_submit_value_1"]; ?>">
                </div>
            </form>

        </div>
    </div>
</body>

</html>