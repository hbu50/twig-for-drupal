<?php
/*
* The actual twig->node->t to drupal l() template compiler
 *
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

Class Drupal_Node_T extends Twig_Node {

    public function __construct(Twig_Node_Expression $expr,Twig_Node_Expression $params = NULL,$lineno,$tag) {
        parent::__construct(array('expr' => $expr),array('lang'=>$params), $lineno,$tag);
    }

    public function compile($compiler) {
        $compiler->addDebugInfo($this);
        $compiler->indent()->raw("echo t(")
                ->subcompile($this->expr);
        if (!is_null($this->attributes["lang"])) {
            $compiler->raw(",array(),")
                    ->subcompile($this->attributes["lang"]);
        }
        $compiler->outdent()->raw(");\n");
    }
}
?>
