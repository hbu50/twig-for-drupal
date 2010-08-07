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

        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $expression = array();
        while(!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            if ($stream->test(Twig_Token::STRING_TYPE)) {
                $expressions["string"]  = $stream->getCurrent()->getValue();
            }

            if ($stream->test(Twig_Token::NAME_TYPE,array('url','URL','path','PATH'))) {
                $stream->next();
                $stream->expect(Twig_Token::OPERATOR_TYPE);
                $expressions["url"] = $stream->getCurrent()->getValue();
            }

            $stream->next();
        }
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        return new Drupal_Node_L($expressions, $lineno,$this->getTag());
    }


    public function getTag() {
        return 'l';
    }


}
?>
