<?php
/* Drupal_ExtendedParser class
 *
 * Just extends the default Twig_Parser and hooks in the ExtendedExpressionParser
 * so we can easily add extra expression (aka token combo's) in the
 * Drupal_ExtendedExpressionParser class
 *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
*/

class Drupal_ExtendedParser extends Twig_Parser implements Twig_ParserInterface {

    public function __construct(Twig_Environment $env = null) {
        parent::__construct($env);
    }


    public function parse(Twig_TokenStream $stream) {
        $this->expressionParser = new Drupal_ExtendedExpressionParser($this);
        return parent::parse($stream);
    }
}
?>
