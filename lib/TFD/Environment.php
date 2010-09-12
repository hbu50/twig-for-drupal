<?php
/* Extended environmnent for the drupal version
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class TFD_Environment extends Twig_Environment {

    public function __construct(Twig_LoaderInterface $loader = null, $options = array(), Twig_LexerInterface $lexer = null, Twig_ParserInterface $parser = null, Twig_CompilerInterface $compiler = null) {
        parent::__construct($loader, $options, $lexer, $parser, $compiler);
    }

    /**
     * returns the name of the class to be created
     * which is also the name of the cached instance
     *
     * @param <string> $name of template
     * @return <string>
     */
    public function getTemplateClass($name) {
        $cache = $this->loader->getCacheKey($name);

        return str_replace(array('-','.','/'),"_",$name);
    }
   
}
?>
