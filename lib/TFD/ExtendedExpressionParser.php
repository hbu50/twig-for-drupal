<?php
/* TFD_ExtendedExpressionParser
 *
 * Extends the default Twig_ExpressionParser so you can easily add extra
 * expressions (aka token combo's) to your tags/nodes
 *
 * Part of the Drupal twig extension distribution
 * http://renebakx.nl/twig-for-drupal
*/

class TFD_ExtendedExpressionParser extends Twig_ExpressionParser {

    public function __construct(Twig_Parser $parser) {
        parent::__construct($parser);
    }

    public function parsePrimaryExpression($assignment = false) {
        $token = $this->parser->getCurrentToken();
        switch ($token->getType()) {
            case Twig_Token::NAME_TYPE:
                $this->parser->getStream()->next();
                switch ($token->getValue()) {
                    case 'true':
                        $node = new Twig_Node_Expression_Constant(true, $token->getLine());
                        break;

                    case 'false':
                        $node = new Twig_Node_Expression_Constant(false, $token->getLine());
                        break;

                    case 'none':
                        $node = new Twig_Node_Expression_Constant(null, $token->getLine());
                        break;

                    default:
                        $cls = $assignment ? 'Twig_Node_Expression_AssignName' : 'TFD_Node_Expression_Name';
                        $node = new $cls($token->getValue(), $token->getLine());
                }
                break;

            case Twig_Token::NUMBER_TYPE:
            case Twig_Token::STRING_TYPE:
                $this->parser->getStream()->next();
                $node = new Twig_Node_Expression_Constant($token->getValue(), $token->getLine());
                break;

            default:
                if ($token->test(Twig_Token::OPERATOR_TYPE, '[')) {
                    $node = $this->parseArrayExpression();
                } elseif ($token->test(Twig_Token::OPERATOR_TYPE, '(')) {
                    $this->parser->getStream()->next();
                    $node = $this->parseExpression();
                    $this->parser->getStream()->expect(Twig_Token::OPERATOR_TYPE, ')');
                } else {
                    throw new Twig_SyntaxError(sprintf('Unexpected token "%s" of value "%s"', Twig_Token::getTypeAsString($token->getType()), $token->getValue()), $token->getLine());
                }
        }

        if (!$assignment) {
            $node = $this->parsePostfixExpression($node);
        }

        return $node;
    }
}
?>
