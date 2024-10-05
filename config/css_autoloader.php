

<?php

function CSS_autoloader()
{

    $CSS_DIR = 'View/CSS/';

    $styles_arr = scandir($CSS_DIR);

    unset($styles_arr[array_search(".", $styles_arr)]);
    unset($styles_arr[array_search("..", $styles_arr)]);

    $end_styles_arr = [];

    foreach ($styles_arr as $style) {
        if (pathinfo($style, PATHINFO_EXTENSION) === 'css') {

            $end_styles_arr[] = '<link rel="stylesheet" href="' . $CSS_DIR . DIRECTORY_SEPARATOR . $style . '">';
        }
    }

    return $end_styles_arr;
}


?>

