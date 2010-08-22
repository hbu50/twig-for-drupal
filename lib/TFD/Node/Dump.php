<?php

/*
 * This file is part of Twig.
 *
 * (c) 2010 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

/**
 * Represents a debug node.
 *
 * @package    twig
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id$
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
