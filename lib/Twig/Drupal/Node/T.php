<?php
Class Twig_Drupal_Node_T extends Twig_Node {

    public function __construct($value, $lineno) {
        parent::__construct(array(), array('data' => $value), $lineno);
    }
    

    public function compile($compiler) {
        $compiler->addDebugInfo($this)
                ->write("echo t(")
                ->string($this['data'])
                ->write(");");
    }
}
?>
