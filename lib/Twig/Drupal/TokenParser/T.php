<?php
/* Maps the T tag to the drupal t() function
 * 
 * usage :
 * {%t "foo" %}  translage foo
 * or
 * {%t string="foo" lang="bar" %} translate foo in language bar
 *
*/

class Twig_Drupal_TokenParser_T extends Twig_TokenParser {

    public function parse(Twig_Token $token) {

        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $expressions = array();

        if (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            if($stream->test(Twig_Token::STRING_TYPE)) {
                $expressions[] = array("lineno" => $lineno,"string" => $stream->getCurrent()->getValue());
                $stream->next();
            }elseif($stream->test(Twig_Token::NAME_TYPE)) {
                $expressions[] = $this->parseComplex($stream);
            }
        }
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        return new Twig_Drupal_Node_T($expressions[0]);
    }

    private function parseComplex(&$stream) {
        $parameters = array();
        while (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            // parameters should always be name->operator->string
            if ($stream->getCurrent()->getType() == Twig_Token::NAME_TYPE) {
                $parameters["lineno"] = $this->parser->getCurrentToken()->getLine();
                $name = strtolower($stream->getCurrent()->getValue());
                $stream->next();
                $stream->expect(Twig_Token::OPERATOR_TYPE);
                $parameters[$name] = $stream->getCurrent()->getValue();
            }
            $stream->next();
        }
        return $parameters;
    }

    public function getTag() {
        return 't';
    }

}
?>
