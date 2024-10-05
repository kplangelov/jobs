<?php 


function setRoute($phpFileName, $path = 'PHP')
{
    //we check if dir exist, and then if file exist - include.
    
    if(!is_dir($path))
    {
        echo 'Unexisting directory.';
        return;
    }

    if(file_exists($path.DIRECTORY_SEPARATOR.$phpFileName))
    {
        //echo $path.DIRECTORY_SEPARATOR.$phpFileName;
        require $path.DIRECTORY_SEPARATOR.$phpFileName;
    }
    else {
        echo 'The directory is valid, but the file is not exist.';
    }
}
function getRoute($pageName)
{
    
    return "index.php?page=".htmlspecialchars($pageName);

}

function includeForm($formName)
{
    $dir = 'View/HTML/Forms/'.$formName;

    if(file_exists($dir)) {
        require $dir;
    }
    else {
        echo 'This form not exist -> '.$dir;
    }
}
