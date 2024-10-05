<?php
session_start();
error_reporting(0);
// Автозареждане на класовете
spl_autoload_register(
    function ($className) {

        $baseDir = __DIR__ . '/../'; 

        $folders = ['Model', 'View', 'Controller', 'inc'];

        foreach ($folders as $folder) {
            $fullPath = $baseDir . $folder . DIRECTORY_SEPARATOR . $className . '.php';

            if (file_exists($fullPath)) {
                require $fullPath;
                return;
            }
        }

    }
);
