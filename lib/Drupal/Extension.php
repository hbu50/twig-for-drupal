<?php
/* register the drupal specific tags and filters within a
* proper declared twig extension
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class Drupal_Extension extends Twig_Extension {

    /* registers the drupal specific tags */
    public function getTokenParsers() {
        $parsers[] = new Drupal_TokenParser_T();
        $parsers[] = new Drupal_TokenParser_L();
       

        if (module_exists('devel')) {
            $parsers[] =    new Drupal_TokenParser_Dpr();
            $parsers[] =    new Drupal_TokenParser_Dpm();
        }
        return $parsers;
    }

    /* registers the drupal specific filters */
    public function getFilters() {
        $filters['size'] = new Twig_Filter_Function('drupal_filter_size');
        return $filters;
    }

    public function getName() {
        return 'drupal';
    }
}

/* the above declared filter implementations go here */

/* returns human readable filesize from $value (1024 => 1KB) */
function drupal_filter_size($value,$lang=NULL) {
    return format_size($value,$lang);
}
?>