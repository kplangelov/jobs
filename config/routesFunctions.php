<?php


function setRoute($file)
{

    $fullpath = $file;
    if (file_exists($fullpath)) {
        //echo $path.DIRECTORY_SEPARATOR.$phpFileName;
        require $fullpath;
    } else {
        echo 'File is not exist.';
    }
}
function getRoute($pageName)
{

    return "index.php?page=" . htmlspecialchars($pageName);

}

function includeForm($formName)
{
    $dir = 'View/HTML/Forms/' . $formName;

    if (file_exists($dir)) {
        require $dir;
    } else {
        echo 'This form not exist -> ' . $dir;
    }
}
