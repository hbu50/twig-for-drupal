<?php
/**
 * Loads template from the filesystem.
 *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
 */

class TFD_Loader_Filesystem extends Twig_Loader_Filesystem {
    protected $resolverCache;

    public function __construct() {
        parent::__construct(array());
        $this->resolverCache = array();
    }


    public function getSource($filename) {
        return file_get_contents($this->getCacheKey($filename));
    }


    public function findTemplate($name) {
        if (!isset($this->resolverCache[$name])) {
            $found = false;
            if (is_readable($name)) {
                $this->resolverCache[$name] = $name;
                $found = true;
          }
            if (!$found) {
                throw new RuntimeException(sprintf('Unable to load template "%s"', $name));
            }
        }
        return $this->resolverCache[$name];
    }
}
