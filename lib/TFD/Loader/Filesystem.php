<?php
/**
 * Loads template from the filesystem.
 *
 * WARNING! This loader assumes there are NO default drupal modules that
 * come with twig templates (.tpl.html!)
 *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
 */

class TFD_Loader_Filesystem implements Twig_LoaderInterface {

    protected $cache;
    protected $paths;

    public function __construct() {
        foreach (list_themes() as $theme) {
            $this->paths[] = dirname($theme->filename);
        }
        $this->cache = array();
    }


    public function getSource($filename) {
            return file_get_contents($this->getCacheKey($filename));
    }

    public function getCacheKey($filename) {
        if (!$this->cache[$filename]){
                $this->findTemplate($filename);
            }
        return $this->cache[$filename];
    }

    // strangely enough filebased templates are allways fresh ;)
    public function isFresh($filename, $time) {
        return true;
    }


    private function findTemplate($name) {
        if (is_readable($name)) {
            $this->cache[$name] = $name;
        } else {
            foreach($this->paths as $path) {
                $filename = $path .'/'. $name;
                if (is_readable($filename)) {
                    $this->cache[$name] = $filename;
                    continue;
                }
            }
            if (!isset($this->cache[$name])) throw new Exception("unabled to load template $name",1);
        }
    }
}
