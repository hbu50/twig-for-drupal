<?php
/**
 * @author: Rene Bakx (rene@7renebakx.nl)
 *
 * @description: Extends the default template class to make it easier
 * to output drupal content without actually stating that you want
 * to render a renderable array ( aka {{varname|render()}}
 *
 */

class TFD_Template extends Twig_Template {
    /**
     * Returns the template name.
     *
     * @return string The template name
     */
    public function getTemplateName() {
    }

    protected function doGetParent(array $context) {
        return parent::getParent($context);
    }

    /**
     * @param array $context An array of parameters to pass to the template
     * @param array $blocks  An array of blocks to pass to the template
     */
    protected function doDisplay(array $context, array $blocks = array()) {
        return parent::Display($context, $blocks);
    }

    /**
     * This where the magic happens if the $object[$item] is an array
     * and is not a ArrayAccess object, the array is passed trough
     * to the tfd_render function before returning.
     *
     * @see parent::getAttribute
     */
    protected function getAttribute($object, $item, array $arguments = array(), $type = Twig_TemplateInterface::ANY_CALL, $isDefinedTest = false, $ignoreStrictCheck = false) {
        if (Twig_TemplateInterface::METHOD_CALL !== $type) {
            if ((is_array($object) && array_key_exists($item, $object)) || ($object instanceof ArrayAccess && isset($object[$item]))) {
                if (!$isDefinedTest) {
                    return render($object[$item]);
                } else {
                    return true;
                }
            } else {
                return parent::getAttribute($object, $item, $arguments, $type, $isDefinedTest, $ignoreStrictCheck);
            }
        }
      return false;
    }
}