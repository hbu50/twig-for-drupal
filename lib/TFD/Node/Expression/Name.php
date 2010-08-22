<?php
/*

 */

class TFD_Node_Expression_Name extends Twig_Node_Expression
{
    public function __construct($name, $lineno)
    {
        parent::__construct(array(), array('name' => $name), $lineno);
    }

    public function compile($compiler)
    {

        if ('_self' === $this['name']) {
            $compiler->raw('$this');
        } elseif ('_context' === $this['name']) {
            $compiler->raw('$context');
        } elseif ($compiler->getEnvironment()->isStrictVariables()) {
            $compiler->raw(sprintf('$this->getContext($context, \'%s\')', $this['name'], $this['name']));
        } else {
            $compiler->raw(sprintf('$context[\'%s\']', $this['name']));
        }
    }
}
