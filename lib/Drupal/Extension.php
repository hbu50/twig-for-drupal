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

        if (module_exists('devel')) {
            $parsers[] =    new Drupal_TokenParser_Dpr();
            $parsers[] =    new Drupal_TokenParser_Dpm();
        }
        return $parsers;
    }

    /* registers the drupal specific filters */
    public function getFilters() {
        return array();
    }

    public function getName() {
        return 'drupal';
    }
}
?>