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
                $paths = twig_get_discovered_templates();
                foreach($paths as $path){
                    $completeName = $path . '/' . $name;
                    if (is_readable($completeName)) {
                       $this->cache[$name] = $completeName;
                       $found = true;
                       break;
                    }
                }
              #  
            }
            if (!$found) throw new RuntimeException(sprintf('Unable to load template "%s"',$name));
        }
        return $this->cache[$name];
    }

    // strangely enough filebased templates are always fresh ;)
    public function isFresh($filename, $time) {
        return true;
    }
       
}
