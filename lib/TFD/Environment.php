<?php
/* Extended environmnent for the drupal version
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class TFD_Environment extends Twig_Environment {

    protected $templateClassPrefix = '__TFDTemplate_';
    protected $fileExtension = 'tpl.twig';

    public function __construct(Twig_LoaderInterface $loader = null, $options = array()) {
        $this->fileExtension = twig_extension();
        parent::__construct($loader, $options);
    }

    private function generateCacheKeyByName($name) {
        return $name = preg_replace('/\.' . $this->fileExtension . '$/', '', $this->loader->getCacheKey($name));
    }

    /**
     * returns the name of the class to be created
     * which is also the name of the cached instance
     *
     * @param <string> $name of template
     * @return <string>
     */
    public function getTemplateClass($name) {
        return str_replace(array('-', '.', '/'), "_", $this->generateCacheKeyByName($name));
    }


    public function getCacheFilename($name) {
        if ($cache = $this->getCache()) {
            $name = $this->generateCacheKeyByName($name);
            $name .= '.php';
            $dir = $cache . '/' . dirname($name);
            if (!is_dir($dir)) {
                if (!mkdir($dir, 0777, true)) {
                    throw new Exception("Cache directory $cache is not deep writable?");
                }
            }
            return $cache . '/' . $name;
        }
    }


    public function flushCompilerCache() {
        // do a child-first removal of all files and directories in the
        // compiler cache directory
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->getCache()), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                unlink($file);
            } elseif ($file->isDir()) {
                rmdir($file);
            }
        }
    }

    protected function writeCacheFile($file, $content) {
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }

        $tmpFile = tempnam(dirname($file), basename($file));
        if (false !== @file_put_contents($tmpFile, $content)) {
            // rename does not work on Win32 before 5.2.6
            if (@rename($tmpFile, $file) || (@copy($tmpFile, $file) && unlink($tmpFile))) {
                @chmod($file, 0644);
                return;
            }
        }
        throw new Twig_Error_Runtime(sprintf('Failed to write cache file "%s".', $file));
    }
}

?>
