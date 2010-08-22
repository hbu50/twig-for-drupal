<?php
/* Maps the L tag to the drupal l() function
 * 
* usage :
 *
* {%l "foo" %} {%l user.name> %} {%l "foo" lang='nl'%} {%l "foo" lang=user.lang'%}
*
* url can also be path to keep it more in drupal lingo :)
*
* for more information about the l() usage in drupal see http://api.drupal.org/api/function/l/6
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class TFD_TokenParser_L extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        return $this->parser->parseLanguageTag($token,$this);
    }

    public function getTag() {
        return 'l';
    }

    public function getNode($expr,$params=array(),$lineno=NULL) {
        return new TFD_Node_L($expr, $params, $lineno, $this->getTag());
    }


}
?>
