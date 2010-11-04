<?php
/**
 * Loads template from the filesystem.
 *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
 */

class TFD_Loader_Filesystem implements Twig_LoaderInterface {

    protected $cache;

    public function __construct() {
        $this->cache = array();
    }


    public function getSource($filename) {
        return file_get_contents($this->getCacheKey($filename));
    }

    public function getCacheKey($name) {
         if(!isset($this->cache[$name])) {
             $found = false;
            if (is_readable($name)) {
                $this->cache[$name] = $name;
                $found = true;
            } else {
                $path = twig_get_current_theme_template_path();
                    $completeName = $path . '/' . $name;
                    if (is_readable($completeName)) {
                       $this->cache[$name] = $completeName;
                       $found = true;
                }
            }
            if (!$found) throw new RuntimeException(sprintf('Unable to load template "%s"',$name));
        }
        return $this->cache[$name];
    }

    //TODO Check with cache functions
    public function isFresh($filename, $time) {
        return true;
    }
       
}
