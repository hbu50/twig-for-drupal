#!/usr/bin/env drush
<?php
/**
 * @file: post-install.php
 * @author: Rene Bakx (rene@71media.net)
 * @date: 11-04-2012
 * @description: This file is supposed to run after you installed D7, TWIG  and TFD
 * it moves certain folders in the correct place and configures the autoloader.
 *
 */
global $argv, $options;


if (substr_count($argv[0], 'drush.php') == 0 || PHP_SAPI !== 'cli') {
    echo "Please use drush to execute : \ndrush scr ./<folder>/sites/all/libraries/tfd/post-install.php\n\n";
    die();
}
$siterootchunks = explode('/', $argv[2]);
$siteroot = drush_get_context('DRUSH_OLDCWD') . '/' . $siterootchunks[0] . '/';
if (is_dir($siteroot)) {
    define('SITE_ROOT', $siteroot);
    define('ENGINE_PATH', SITE_ROOT . 'themes/engines/twig/');
    define('TFD_PATH', SITE_ROOT . 'sites/all/libraries/tfd/');
    drush_print('Site located at ' . SITE_ROOT);
    copy_engine();
    enable_autoloader();
}


function copy_engine() {
    if (!is_dir(ENGINE_PATH)) {
        try {
            mkdir(ENGINE_PATH);
            drush_print("Created " . ENGINE_PATH);
        }
        catch (Exception $except) {
            drush_error('Unable to create ' . ENGINE_PATH);
        }

    }
    try {
        copy(TFD_PATH . 'twig.engine', ENGINE_PATH . 'twig.engine');
    } catch (Exception $except) {
        drush_error('Unable to copy engine to' . ENGINE_PATH);
    }
    drush_print('twig.engine copied to ' . ENGINE_PATH);
}

function enable_autoloader(){

}