<?php
/* Maps the L tag to the drupal l() function
 * 
* usage :
* {%l "bar" url="http://foo" %}  returns l('bar',"'http://foo")
* or
* {%l "bar" url="http://foo" options=['class'='foobarclass']  %}  returns l('bar',"'http://foo",array('class='='foobarclass')
*
* url can also be path to keep it more in drupal lingo :)
*
* for more information about the l() usage in drupal see http://api.drupal.org/api/function/l/6
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class Drupal_TokenParser_L extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        return $this->parser->parseLanguageTag($token,$this);
    }

    public function getTag() {
        return 'l';
    }

    public function getNode($expr,$params=array(),$lineno=NULL) {
        return new Drupal_Node_L($expr, $params, $lineno, $this->getTag());
    }


}
?>
