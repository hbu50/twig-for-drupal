<?php
/* register the drupal specific tags and filters within a
* proper declared twig extension
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class TFD_Extension extends Twig_Extension {

    /* registers the drupal specific tags */
    public function getTokenParsers() {
        $parsers[] = new TFD_TokenParser_FunctionCall('theme');
        $parsers[] = new TFD_TokenParser_FunctionCall('render');
        $parsers[] = new TFD_TokenParser_FunctionCall('hide');
        $parsers[] = new TFD_TokenParser_FunctionCall('t');
        $parsers[] = new TFD_TokenParser_FunctionCall('l');
        $parsers[] = new TFD_TokenParser_Unset();

        return $parsers;
    }

    /* registers the drupal specific filters */
    public function getFilters() {

        $filters['replace'] = new Twig_Filter_Function('TFD_str_replace');
        $filters['dump']    = new Twig_Filter_Function('TFD_dump');
        $filters['render']  = new Twig_Filter_Function('render');
        $filters['hide']    = new Twig_Filter_Function('hide');
        $filters['size']    = new Twig_Filter_Function('format_size');
        $filters['url']     = new Twig_Filter_Function('url');
        $filters['t']       = new Twig_Filter_Function('t');
        return $filters;
    }

    public function getName() {
        return 'drupal';
    }
}

// ------------------------------------------------------------------------------------------------
// the above declared filter implementations go here

/**
 * Twig filter for str_replace, switches needle and arguments to provide sensible
 * filter arguments order
 * 
 * {{ haystack|replace("needle", "replacement") }}
 *
 * @param  $haystack
 * @param  $needle
 * @param  $repl
 * @return mixed
 */
function TFD_str_replace($haystack, $needle, $repl) {
    return str_replace($needle, $repl, $haystack);
}

/**
 * Dumps a variable to screen, use
 * second parameter to set the method
 * (defaults to devel modules dpm method)
 *
 * @param $var
 * @param <string> $mode drp,dpm,var_dump or print_r
 */
function TFD_dump($var, $mode = 'dpr') {
    switch($mode) {
        case 'dpr':
        case 'var_dump':
        case 'print_r':
        case 'dpm':
            $mode($var);
            break;
        default:
            throw new InvalidArgumentException("Invalid mode $mode for TFD_dump()");
    }
}

?>