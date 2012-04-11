<?php
class TFD_Node_Render extends Twig_Node_Print {


    public function compile(Twig_Compiler $compiler) {
        $compiler
            ->addDebugInfo($this)
            ->write('echo  render(')
            ->subcompile($this->getNode('expr'))
            ->raw(");\n");
    }
}
 
