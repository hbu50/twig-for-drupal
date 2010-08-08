<?php
/* Drupal_ExtendedExpressionParser
 *
 * Extends the default Twig_ExpressionParser so you can easily add extra
 * expressions (aka token combo's) to your tags/nodes
 *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
*/

class Drupal_ExtendedExpressionParser extends Twig_ExpressionParser {

    public function __construct(Twig_Parser $parser) {
        parent::__construct($parser);
    }
    
}
?>
