<?php
/* Maps the T tag to the drupal t() function
 * 
* usage :
* {%t "foo" %}  translage foo
* or
* {%t string="foo" lang="bar" %} translate foo in language bar
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class Drupal_TokenParser_T extends Twig_TokenParser {

    public function parse(Twig_Token $token) {

        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $expressions = false;
        while(!$stream->test(Twig_Token::BLOCK_END_TYPE)) {

            switch($stream->look()) {

                case Twig_Token::STRING_TYPE :
                    $expressions = array("lineno" => $lineno,"string" => $stream->getCurrent()->getValue());
                    $stream->next();
                    break;

                case Twig_Token::NAME_TYPE :
                    if ($stream->test(Twig_Token::NAME_TYPE,array('lang','LANG','string','STRING'))) {
                        $name = strtolower($stream->getCurrent()->getValue());
                        $stream->next();
                        $stream->expect(Twig_Token::OPERATOR_TYPE);
                        $expressions[$name] = $stream->getCurrent()->getValue();
                    }
                    break;
            }
            $stream->next();
        }
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        if($expressions) {
            return new Drupal_Node_T($expressions,$lineno,$this->getTag());
        }
    }
    
    public function getTag() {
        return 't';
    }
}
?>
