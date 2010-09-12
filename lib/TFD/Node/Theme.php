<?php
/*
 * Maps the theme() function to a twig node
 *
 * First param is allways the hook to execute, the rest of the parameters
 * are being compiled into seperate arrays like the theme function expects!
 *
 * usage for example to theme the primary links :
 * {% theme 'links', primary_links,['class':'links primary-links','rene':'rules']  %}
 *
 * 
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
*/

class TFD_Node_Theme extends Twig_Node {
    public function __construct(Twig_Node_Expression $hook, array $expr,$lineno, $tag = null) {
        parent::__construct(array('hook' => $hook),array('params'=>$expr), $lineno,$tag);
    }


    public function compile($compiler) {
        $compiler->addDebugInfo($this);
        $compiler
                ->indent()
                ->write("theme(")
                ->subcompile($this->hook);
            foreach($this->attributes["params"] as $param) {
                $compiler->raw(',');
                $compiler->subcompile($param);
            }
        $compiler->raw(");\n");
    }
}
