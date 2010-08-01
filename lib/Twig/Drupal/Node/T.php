<?php
/* The actual twig->node to drupal T() function mapper  */

Class Twig_Drupal_Node_T extends Twig_Node {

    public function __construct($expressions) {
        parent::__construct(array(), $expressions, $lineno);
    }

    public function compile($compiler) {
        if(isset($this['lang'])) {
            $compiler->write("echo t('".$this['string']."',array(),'".$this['lang']."');");
        } else {
            $compiler->write("echo t('".$this['string']."');");
        }
    }
}
?>
