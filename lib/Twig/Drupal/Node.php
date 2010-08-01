<?php
/* base class, used for refence only */

Class Twig_Drupal_Node extends Twig_Node {
    /*
     * @param array   $nodes      An array of named nodes
     * @param array   $attributes An array of attributes (should not be nodes)
     * @param integer $lineno     The line number
     * @param string  $tag        The tag name associated with the Node
    */
    public function __construct(array $nodes = array(), array $attributes = array(), $lineno = 0, $tag = null) {
        parent::__construct($nodes, $attributes, $lineno, $tag);
    }

    
    public function compile(Twig_Compiler $compiler) {
        $compiler
                ->addDebugInfo($this)
                ->write('echo ')
                ->subcompile($this->expr)
                ->raw(";\n")
        ;
    }
}
