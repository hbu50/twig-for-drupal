<?php
/*
* The actual twig->node->t to drupal l() template compiler
 *
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

Class Twig_Drupal_Node_L extends Twig_Node {

    public function __construct($expressions, $lineno,$tag) {
        parent::__construct(array(), $expressions, $lineno,$tag);
    }

    public function compile($compiler) {
        $compiler->addDebugInfo($this);
        //            t,p,o

        $start = sprintf('echo l("%s","%s"',$this["string"],$this["url"]);
        $compiler->write($start);
        if (isset($this["options"])){
//            $compiler->raw(",");
//            $this["options"]->compile($compiler);
        }
        $compiler->raw(");");
    }
}
?>
