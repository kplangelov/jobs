<?php
require 'config/routesFunctions.php';
require 'View/HTML/Templates/header.php';

/*
    Access explanation
    if access is 0, EVERYONE can open this page.
    if access is 1, only guests can open this page.
    if access is 2, is for accounts. (users and companies, admins)
    if access is 3, only users and admins
    if access is 4, only companies and admins
    if access is 5, only admins.
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

    'profile' => [
        'access' => '2', //accounts
        'url' => 'profile.php'
    ],

    'settings' => [
        'access' => '2', //accounts
        'url' => 'settings.php'
    ],

    'view_job' => [
        'access' => '2', //accounts
        'url' => 'job.php'
    ],

    'logout' => [
        'access' => '2', //accounts
        'url' => 'logout.php'
    ],

    'my_jobs' => [
        'access' => '4', //companies
        'url' => 'my_jobs.php'
    ],

    'create_job' => [
        'access' => '4', //companies
        'url' => 'job_add.php'
    ],

    'deleted_jobs' => [ // companies
        'access' => '4',
        'url' => 'deleted_jobs.php'
    ],

    'update_job_status' => [
        'access' => '4', // companies
        'url' => 'update_job_status.php'
    ],

    'upload_company_logo' => [ //companies
        'access' => '3',
        'url' => 'upload_company_logo.php'
    ],


    'admin_all_jobs' => [ //admins
        'access' => '5',
        'url' => 'job.php'
    ],

];

$global_route_path = 'PHP';

$route_paths = [
    '0' => 'everyone',
    '1' => 'guests',
    '2' => 'accounts',
    '3' => 'users',
    '4' => 'companies',
    '5' => 'admins'
];

$get_page = htmlspecialchars(trim($_GET['page']));

if (!$get_page) {
    $get_page = 'home';
}

if (!array_key_exists($get_page, $routes)) {
    echo '<div class="container alert alert-danger mt-3" role="alert">This page doesn\'t exist!</div>';
    exit();
}

$accCntrl = new AccountController();

$logged_acc = $accCntrl->isAccLoggedIn();

foreach ($routes as $page => $pageData) {

    if ($get_page === $page) {

        $pageAccess = $pageData['access'];
        $pageURL = $pageData['url'];
        $includePath = $global_route_path . DIRECTORY_SEPARATOR . $route_paths[$pageAccess] . DIRECTORY_SEPARATOR . $pageURL;
        $setInclude = false;

        if ($pageAccess == '0') {//EVERYONE
            $setInclude = true;
        } else if ($pageAccess == '1' && !$logged_acc) { //GUESTS ONLY
            $setInclude = true;
        } else if ($pageAccess == '2' && $logged_acc) { // Accounts [ USERS , COMPANIES, ADMINS ]
            $setInclude = true;
        } else if ($pageAccess == '3' && $logged_acc && ($logged_acc['role'] == '3' || $logged_acc['role'] == '5') ) { 
            $setInclude = true;                                              //USERS AND ADMINS ONLY
        } else if ($pageAccess == '4' && $logged_acc && ($logged_acc['role'] == '4' || $logged_acc['role'] == '5') ) {  
            $setInclude = true;                                              //COMPANIES AND ADMINS ONLY
        } else if ($pageAccess == '5' && $logged_acc && $logged_acc['role'] == '5') { //ADMINS ONLY
            $setInclude = true;
        }

        if ($setInclude) {
            setRoute($includePath);
        } else {
            echo '<div class="container alert alert-danger mt-3" role="alert">You are not authorized to open this page.</div>';
        }
    }
}
