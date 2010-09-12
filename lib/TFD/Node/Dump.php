<?php
/*
 * outputs either DPR or DPM for the given variable/object or array
 * and if the devel module is not loaded, throws a warning and uses print_r
  *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
*/
class TFD_Node_Dump extends Twig_Node {
    public function __construct(Twig_Node_Expression $expr = null, $lineno, $tag = null) {
        parent::__construct(array('expr' => $expr), array(), $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Twig_Compiler A Twig_Compiler instance
     */
    public function compile($compiler) {
        $compiler->addDebugInfo($this);
        $compiler
                ->write("if (\$this->env->isDebug()) {\n")
                ->indent();
        if (module_exists('devel')) {
            if($this->tag == "dpr") {
                $compiler
                        ->indent()
                        ->write("dpr(")
                        ->subcompile($this->expr)
                        ->write(",false,'".$this->expr->attributes["name"]."'")
                        ->raw(");\n")
                        ->outdent();
            } else {
                $compiler
                        ->indent()
                        ->write("dpm(")
                        ->subcompile($this->expr)
                        ->raw(");\n")
                        ->outdent();
            }
        } else {
            $compiler
                    ->write('<span>Warning Develmodule not found!</span><pre>')
                    ->indent()
                    ->write("print_r(")
                    ->subcompile($this->expr)
                    ->write(");")
                    ->outdent()
                    ->raw("</pre>\n")
            ;
        }

        $compiler
                ->outdent()
                ->write("}\n")
        ;
    }
}
