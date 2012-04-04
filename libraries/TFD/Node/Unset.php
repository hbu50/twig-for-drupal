<?php
/**
 * @author Gerard van Helden <gerard@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */
 
class TFD_Node_Unset extends Twig_Node {
    public function compile($compiler) {
        $compiler
                ->addDebugInfo($this)
                ->write("unset(\$context['")
                ->raw($this->attributes['expr']['name'])
                ->raw("']);\n");
    }
}