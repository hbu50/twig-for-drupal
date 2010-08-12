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

    /**
     * Parses the token as an language switchable structure
     * {%? "foo" %} {%? user.name> %} {%? "foo" lang='nl'%} {%? "foo" lang=user.lang'%}
     *
     * @param Twig_TokenStream $stream
     * @param <string> $nodeName name of nodeclass to return
     * @param <string> $tagName name of the tag to parse
     * @return Twig_Node for $nodeName
     */
    public function parseLanguageTag(Twig_Token $token,Twig_TokenParser &$parser) {
        $lineno = $token->getLine();
        $stream = $this->getStream();
        $expr = null;
        while(!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            $current = $stream->getCurrent()->getType();

            switch($current) {
                case Twig_Token::NUMBER_TYPE :
                case Twig_Token::STRING_TYPE :
                    $expr = $this->getExpressionParser()->parseExpression();
                    break;

                case Twig_Token::NAME_TYPE :
                    if (!$stream->look()->test(Twig_Token::OPERATOR_TYPE,".")) {
                        $stream->rewind();
                        $stream->expect(Twig_Token::NAME_TYPE,'lang');
                        $stream->expect(Twig_Token::OPERATOR_TYPE,'=');
                        $params = $this->getExpressionParser()->parseExpression();
                    } else {
                        $stream->rewind();
                        $expr = $this->getExpressionParser()->parseExpression();
                    }
                    break;
                default :
                    $stream->next();
            }
        }
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        if($expr) {
            return $parser->getNode($expr,$params,$lineno);
        }
    }
}
?>
