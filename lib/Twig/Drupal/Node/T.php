<?php
/*
* The actual twig->node->t to drupal l() template compiler
 *
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

Class Twig_Drupal_Node_T extends Twig_Node {

    public function __construct($expressions) {
        parent::__construct(array(), $expressions, $lineno,$tag);
    }

    public function compile($compiler) {
           $compiler->addDebugInfo($this);
        if(isset($this['lang'])) {
            $compiler->write("echo t('".$this['string']."',array(),'".$this['lang']."');");
        } else {
            $compiler->write("echo t('".$this['string']."');");
        }
    }
}
?>
