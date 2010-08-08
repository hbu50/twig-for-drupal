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
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $expr = null;
        while(!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            $current = $stream->getCurrent()->getType();

            switch($current) {
                case Twig_Token::STRING_TYPE :
                    $expr = $this->parser->getExpressionParser()->parseExpression();
                    break;

                case Twig_Token::NAME_TYPE :
                // parameter lang="somelang" or lang=template.lang
                    if (!$stream->look()->test(Twig_Token::OPERATOR_TYPE,".")) {
                        $stream->rewind();
                        $stream->expect(Twig_Token::NAME_TYPE,'lang');
                        $stream->expect(Twig_Token::OPERATOR_TYPE,'=');
                        $params = $this->parser->getExpressionParser()->parseExpression();
                    } else {
                        $stream->rewind();
                        $expr = $this->parser->getExpressionParser()->parseExpression();
                    }
                    break;
                default :
                    $stream->next();
            }
        }
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        if($expr) {
            return new Drupal_Node_T($expr,$params,$lineno,$this->getTag());
        }
    }

    public function getTag() {
        return 't';
    }
}
?>
