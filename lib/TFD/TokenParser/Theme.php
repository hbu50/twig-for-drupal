<?php
/*
* Maps the theme() function to a twig node 
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/
class TFD_TokenParser_Theme extends Twig_TokenParser {

    public function parse(Twig_Token $token) {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        // first param is allways the HOOK to be themed!
        $stream->test(Twig_Token::STRING_TYPE);
        $hook = $this->parser->getExpressionParser()->parseExpression();
        $stream->expect(Twig_Token::OPERATOR_TYPE,',');

        $expr = null;
        $exprCounter = 0;
        while(!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            $current = $stream->getCurrent()->getType();
            $val = $stream->getCurrent()->getValue();

            switch($current) {
                case Twig_Token::OPERATOR_TYPE:
                    if($val == ',') {
                        $exprCounter++;
                        $stream->next();
                    } elseif ($val == '[') {
                        $stream->rewind();
                        $expr[$exprCounter] = $this->parser->getExpressionParser()->parseArrayExpression();
                    } else {
                        // should never happen!
                        $stream->next();
                    }
                    break;
                case Twig_Token::NAME_TYPE:
                case Twig_Token::STRING_TYPE:
                    $expr[$exprCounter] = $this->parser->getExpressionParser()->parseExpression();
                    break;
                default:
                    echo Twig_Token::getTypeAsString($current);
                    echo "->".$val."<BR>";
                    $stream->next();
            }
        }
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        
        return new TFD_Node_Theme($hook,$expr,$lineno, $this->getTag());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @param string The tag name
     */
    public function getTag() {
        return 'theme';
    }
}
?>
