<?php
/**
 *
 * @description : TFD_NodeVisitor checks of the auto_render is set in the
 * twig environment, and if so it converts nodes of the Twig_Node_Print into
 * TFD_Node_Render types.
 *
 * In a drupal 7 template a single variable can contain an array, but Twig only
 * triggers the Twig_Template::getAttribute only for variables that are an object or
 * array.
 *
 * Normally you would call something like {{tabs|render}} but to make it easier
 * for those who work on the frontend {{tabs}} makes more sense.
 *
 * @author: Rene Bakx (rene@renebakx.nl)
 */

class TFD_NodeVisitor implements Twig_NodeVisitorInterface {
    /**
     * Called before child nodes are visited.
     *
     * @param Twig_NodeInterface $node The node to visit
     * @param Twig_Environment   $env  The Twig environment instance
     *
     * @return Twig_NodeInterface The modified node
     */
    function enterNode(Twig_NodeInterface $node, Twig_Environment $env) {
        return $node;
    }

    /**
     * Does the actual swaping of Twig_Node_Print for TFD_Node_Print
     *
     * @param Twig_NodeInterface $node The node to visit
     * @param Twig_Environment   $env  The Twig for Drupal environment instance
     *
     * @return Twig_NodeInterface The modified node
     */
    function leaveNode(Twig_NodeInterface $node, Twig_Environment $env) {
        if ($node instanceof Twig_Node_Print && $node->getNode('expr') instanceof Twig_Node_Expression_Name) {
          /** @var $env TFD_Environment */
            if ($env->isAutoRender()) {
                $node = new TFD_Node_Render($node->getNode('expr'), $node->getLine(), $node->getNodeTag());
            }
        }
        return $node;
    }

    /**
     * @return integer The priority level
     */
    function getPriority() {
        return 10;
    }
}
