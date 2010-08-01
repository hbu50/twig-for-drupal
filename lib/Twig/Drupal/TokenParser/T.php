<?php
/* 
 * Maps the translate tag to the drupal t() function
*/

class Twig_Drupal_TokenParser_T extends Twig_TokenParser {


    public function parse(Twig_Token $token) {
        $stream = $this->parser->getStream();
        $value = trim($stream->expect(Twig_Token::STRING_TYPE)->getValue());
        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        return new Twig_Drupal_Node_T($value,$token->getLine());
    }

    public function getTag() {
        return 't';
    }

}
?>
