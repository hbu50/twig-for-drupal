<?php
/* Maps the L tag to the drupal l() function
 * 
* usage :
* {%l "bar" url="http://foo" %}  returns <a href='http://foo'>bar</a>
* or
* {%l "bar" url="http://foo" options=['class'='foobarclass']  %}  returns <a href='http://foo' class="foobarclass">bar</a>
*
* for more information about the l() usage in drupal see http://api.drupal.org/api/function/l/6
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class Twig_Drupal_TokenParser_L extends Twig_TokenParser {

    public function parse(Twig_Token $token) {

        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        # echo "<pre>".$stream."</pre>";
        
        $expressions = array();
        $loop = false;
        while(!$loop) {
            echo $stream->look()->getType()."<BR>";
           
            if ($stream->look()->getType() == Twig_Token::BLOCK_END_TYPE) {
                 echo "end of tag";
                $loop = true;
                continue;
               
           } 
        }
       $stream->expect(Twig_Token::BLOCK_END_TYPE);
        var_dump($expressions);
        #   return new Twig_Drupal_Node_T($expressions[0]);
    }

    /**
     * Parses the advanced token stream
     * That stream allways consists of
     * Name:operator:string to form the param=value pair
     *
     * @param <twig_token_stream> $stream
     * @return <type>
     */
    private function parseComplex(&$stream) {
        $parameters = array();
        while (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {

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
        return 'l';
    }
}
?>
