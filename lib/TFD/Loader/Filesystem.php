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
        return $this->getTemplate($filename);
    }

    public function getCacheKey($filename) {
        return $filename;
    }

    // strangely enough filebased templates are allways fresh ;)
    public function isFresh($filename, $time) {
        return true;
    }


    private function getTemplate($name) {
        if(!isset($this->cache[$name])) {
            if (is_readable($name)) {
                $this->cache[$name] = file_get_contents($name);
            } else {
                throw new RuntimeException(sprintf('Unable to find template "%s"',$name));
            }
        }
        return $this->cache[$name];
    }
}
