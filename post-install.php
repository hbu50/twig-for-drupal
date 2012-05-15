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
    define('TFD_PATH', 'sites/all/libraries/twig-for-drupal/');
    drush_print('Site located at ' . SITE_ROOT);
    copy_engine();
    enable_autoloader();
    drush_print('Twig for drupal successfull enabled, happy building..');
    $answer = drush_choice(array('Y' => 'Yes', 'N' => 'No'), 'Cleanup install files?');
    if ($answer === "Y") {
        unlink(SITE_ROOT . TFD_PATH . 'post-install.php');
        unlink(SITE_ROOT . TFD_PATH . 'twig.engine');
    }
}


function copy_engine() {
    if (!is_dir(ENGINE_PATH)) {
        try {
            mkdir(ENGINE_PATH);
            drush_print("Created " . ENGINE_PATH);
        }
        catch (Exception $except) {
            drush_error('Unable to create ' . ENGINE_PATH);
            die();
        }

    }
    try {
        copy(SITE_ROOT . TFD_PATH . 'twig.engine', ENGINE_PATH . 'twig.engine');
    } catch (Exception $except) {
        drush_error('Unable to copy engine to' . ENGINE_PATH);
        die();
    }
    drush_print('twig.engine copied to ' . ENGINE_PATH);
}

function enable_autoloader() {
    try {
        $default_settings = file_get_contents(SITE_ROOT . '/sites/default/default.settings.php');
    } catch (Exception $except) {
        drush_error('Unable to read default.settings.php, please add the autoloader yourself');
        die();
    }

    $autoloader = chr(13) . "/** Added autoloader from the Twig-for-Drupal project */" . chr(13);
    $autoloader .= "require_once(DRUPAL_ROOT . '/" . TFD_PATH . "/autoloader/Autoloader.php');" . chr(13);
    $default_settings = $default_settings . $autoloader;
    try {
        file_put_contents(SITE_ROOT . '/sites/default/default.settings.php', $default_settings);
    } catch (Exception $except) {
        drush_error('Unable to write default.settings.php, please add the autoloader yourself');
        die();
    }
    drush_print("Autoloader enabled");
}