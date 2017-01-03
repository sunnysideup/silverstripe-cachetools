<?php

define('DIRECTORY_SEPARATOR', '/');

/**
 * Include _ss_environment.php file
 */
//define the name of the environment file
$envFile = '_ss_environment.php';
//define the dirs to start scanning from (have to add the trailing slash)
// we're going to check the realpath AND the path as the script sees it
$dirsToCheck = array(
    realpath('.'),
    dirname($_SERVER['SCRIPT_FILENAME'])
);
//if they are the same, remove one of them
if ($dirsToCheck[0] == $dirsToCheck[1]) {
    unset($dirsToCheck[1]);
}
foreach ($dirsToCheck as $dir) {
    //check this dir and every parent dir (until we hit the base of the drive)
    // or until we hit a dir we can't read
    while (true) {
        //if it's readable, go ahead
        if (@is_readable($dir)) {
            //if the file exists, then we include it, set relevant vars and break out
            if (file_exists($dir . DIRECTORY_SEPARATOR . $envFile)) {
                define('SS_ENVIRONMENT_FILE', $dir . DIRECTORY_SEPARATOR . $envFile);
                include_once(SS_ENVIRONMENT_FILE);
                //break out of BOTH loops because we found the $envFile
                break(2);
            }
        } else {
            //break out of the while loop, we can't read the dir
            break;
        }
        if (dirname($dir) == $dir) {
            // here we need to check that the path of the last dir and the next one are
            // not the same, if they are, we have hit the root of the drive
            break;
        }
        //go up a directory
        $dir = dirname($dir);
    }
}
