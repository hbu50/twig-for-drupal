<?php
/* Maps the T tag to the drupal t() function
 * 
 * usage :
 *
 * {%t <string> %} or {%t <string> lang=<string>%}
 * where string is either a "" encapsulated string or a
 * object.value / array.value
 *
 * {%t "foo" %} {%t user.name> %} {%t "foo" lang='nl'%} {%t "foo" lang=user.lang'%}
 *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
*/

class Drupal_TokenParser_T extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        return $this->parser->parseLanguageTag($token,$this);
    }

    public function getTag() {
        return 't';
    }

    public function getNode($expr,$params=array(),$lineno=NULL){
        return new Drupal_Node_T($expr, $params, $lineno, $this->getTag());
    }
}
?>
