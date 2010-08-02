<?php
/* register the drupal specific tags and filters within a
* proper declared twig extension
*
* Part of the Drupal twig extension distribution
* http://renebakx.nl/twig-for-drupal
*/

class Twig_Drupal_Extension extends Twig_Extension {

    /* registers the drupal specific tags */
    public function getTokenParsers() {
        return array(
                new Twig_Drupal_TokenParser_T(),        // wraps drupal t();
                new Twig_Drupal_TokenParser_L(),       // wraps drupal l();
//                new Twig_Drupal_TokenParser_Theme(),   // wraps drupal theme();

        );
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