<?php
require 'config/routesFunctions.php';
require 'View/HTML/Templates/header.php';

/*
    Access explanation
    if access is 0, EVERYONE can open this page.
    if access is 1, only guests can open this page.
    if access is 2, only registered users can open this page.
    if access is 3, only admin can open this page.
*/

$routes = [
    'home' => [
        'access' => '0',
        'url' => 'show_all_jobs.php'
    ],
    'login' => [
        'access' => '1',
        'url' => 'login.php'
    ],
    'registration' => [
        'access' => '1',
        'url' => 'registration.php'
    ],

    'my_jobs' => [
        'access' => '2',
        'url' => 'my_jobs.php'
    ],

    'view_job' => [
        'access' => '2',
        'url' => 'job.php'
    ],

    'create_job' => [
        'access' => '2',
        'url' => 'job_add.php'
    ],

    'deleted_jobs' => [
        'access' => '2',
        'url' => 'deleted_jobs.php'
    ],

    'profile' => [
        'access' => '2',
        'url' => 'profile.php'
    ],

    'settings' => [
        'access' => '2',
        'url' => 'settings.php'
    ],

    'update_job_status' => [
        'access' => '2',
        'url' => 'update_job_status.php'
    ],

    'logout' => [
        'access' => '2',
        'url' => 'logout.php'
    ],

    'admin_all_jobs' => [
        'access' => '3',
        'url' => 'job.php'
    ],

];

$get_page = htmlspecialchars(trim($_GET['page']));

if (!$get_page) {
    $get_page = 'home';
}

if (!array_key_exists($get_page, $routes)) {
    echo 'This page dont exist.';
    exit();
}

$userCntrl = new UserController();

$logged_user = $userCntrl->isUserLoggedIn();

$route_path = 'PHP';
$route_paths = [
    '0' => 'everyone',
    '1' => 'guests',
    '2' => 'logged',
    '3' => 'admins'
];

foreach ($routes as $page => $pageInfo) {

    if ($get_page === $page)
        if ($pageInfo['access'] === '0') {
            // PAGES FOR EVERYONE
            setRoute($pageInfo['url'], $route_path . DIRECTORY_SEPARATOR . $route_paths[$pageInfo['access']]);

        } else if ($pageInfo['access'] === '1') {
            //PAGES FOR GUESTS AND ADMIN
            if (!$logged_user || $logged_user['role'] == '3') {
                setRoute($pageInfo['url'], $route_path . DIRECTORY_SEPARATOR . $route_paths[$pageInfo['access']]);
            } else {
                echo 'You are already logged.';
            }

        } else if ($pageInfo['access'] === '2') {
            //PAGES FOR USERS AND ADMIN
            if (!empty($logged_user)) {
                setRoute($pageInfo['url'], $route_path . DIRECTORY_SEPARATOR . $route_paths[$pageInfo['access']]);
            } else {
                echo 'You are not logged.';
                //require $route_path . DIRECTORY_SEPARATOR . 'error_page.php';
            }
        } else if ($pageInfo['access'] === '3') {
            //PAGES FOR ADMIN ONLY.
            if ($logged_user && $logged_user['role'] == '3') {
                echo 'THIS IS AN ADMIN PAGE!<hr>';
                setRoute($pageInfo['url'], $route_path . DIRECTORY_SEPARATOR . $route_paths[$pageInfo['access']]);
            } else {
                echo 'You are not authorized to view this page.';
            }
        } else {
            echo 'You have an issue with your access value in index.php main route. Route: ' . $page;
        }
}
