<?php
require 'config/autoloader.php';

require 'config/css_autoloader.php';

?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="http://localhost/MVC/node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - jobs.bg</title>
    <?php
    foreach (CSS_autoloader() as $css) {
        echo $css;
    }
    ?>
</head>

<body class="bg-dark text-white">

    <header class="container border border-light">
        <h2 class="text-center">jobs.com</h2>
        <h3 class="text-center">Намери перфектната работа за теб!</h3>
        <?php
        $userCntrl = new AccountController();
        $logged_user = $userCntrl->isAccLoggedIn();
        if ($logged_user) {
            ?>
            <nav>
                <div class="row container">

                    <ul class="col list-group list-group-horizontal">
                        <li class="list-group-item bg-dark text-light border-0">
                            <a class="link-light" href="<?php echo getRoute('home') ?>">Home</a>
                        </li>
                        <li class="list-group-item bg-dark text-light border-0"></li>
                        <a class="link-light" href="<?php echo getRoute('my_jobs') ?>">Моите обяви</a>
                        (<a class="link-danger" href="<?php echo getRoute('deleted_jobs') ?>">Кошче</a>)
                        </li>
                        <li class="list-group-item bg-dark text-light border-0">
                            <a class="link-light" href="<?php echo getRoute('create_job') ?>">Добави обява</a>
                        </li>
                    </ul>
                    <ul class="col list-group list-group-horizontal">
                        <li class="list-group-item bg-dark text-light border-0">
                            <?php echo $logged_user['user'] ?>
                            <?php
                            if ($logged_user['role'] != 3) {
                                ?><i class="bi bi-person-circle"></i><?php
                            } else {
                                ?><i class="bi bi-briefcase"></i><?php
                            }
                            ?>
                            <span class="ps-1"><?php echo $userCntrl->getUserRole($logged_user['role']) ?></span>
                        </li>
                        <li class="bg-dark list-group-item border-0">
                            <a class="link-light" href="<?php echo getRoute('profile') ?>">Профил</a>
                        </li>
                        <li class="bg-dark list-group-item border-0">
                            <a class="link-light" href="<?php echo getRoute('settings') ?>">Настройки</a>
                        </li>
                        <li class="bg-dark list-group-item border-0">
                            <a class="link-light" href="<?php echo getRoute('logout') ?>">Изход</a>
                        </li>
                    </ul>
                </div>
                <?php
        } else {
            ?>
                <ul>
                    <li class="bg-dark list-group-item">
                        <a class="link-light" href="<?php echo getRoute('home') ?>">Начало</a>
                    </li>
                    <li class="bg-dark list-group-item">
                        <a class="link-light" href="<?php echo getRoute('login') ?>">Вход</a>
                    </li>
                    <li class="bg-dark list-group-item">
                        <a class="link-light" href="<?php echo getRoute('registration') ?>">Регистрация</a>
                    </li>
                </ul>
                <?php
        }
        ?>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <main>