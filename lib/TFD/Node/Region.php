<?php

class TFD_Node_Region extends Twig_Node {
    function __construct($region, $body, $line) {
        parent::__construct(array('region' => $region, 'body' => $body), array(), $line);
    }


    function compile($compiler) {
        $compiler
                ->write('ob_start();' . "\n")
                ->subcompile($this->body)
                ->write('drupal_set_content(')
                ->subcompile($this->region)
                ->raw(', ob_get_clean());' . "\n");
    }
}
