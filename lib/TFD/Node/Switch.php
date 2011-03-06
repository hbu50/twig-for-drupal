<?php
/**
 * @author Gerard van Helden <gerard@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 *
 */

class TFD_Node_Switch extends Twig_Node {
    public function __construct(Twig_NodeInterface $cases, Twig_NodeInterface $expression, $line) {
        parent::__construct(
                array(
                'expression' => $expression,
                'cases' => $cases
                ),
                array(),
                $line
        );
    }

    public function compile($compiler) {
        $compiler->addDebugInfo($this);
        $compiler
                ->write('switch(')
                ->subcompile($this->expression)
                ->raw(") {\n")
                ->indent();


        $total = count($this->cases);
        $counter = 0;
        foreach($this->cases->nodes as $node) {
            if(is_null($node['expression'])) {
                $compiler
                        ->write('default')
                        ->raw(":\n");

            } else {
                foreach($node['expression'] as $expression) {
                    $compiler
                            ->write('case ')
                            ->subcompile($expression)
                            ->raw(":\n");
                }
            }
            $compiler->indent();
            $compiler->subcompile($node->body);
            if (!$node->attributes['fallthrough'] || $counter+1 >= $total){
                    $compiler->write("break;\n");
             }
            $compiler->outdent();
            $counter++;
        }
        $compiler->outdent()->write('}');
    }
}