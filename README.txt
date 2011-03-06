The drupal 6 implementation of the Twig template language.

To use the twig engine in your project, simply checkout this project and put it in a folder named 'twig' in your engines folder
<siteroot>/engines/twig

Since drupal.org prohibites including other non-gpl projects, get the 1.0 branch from Fabien Potencier 
(git clone https://github.com/fabpot/Twig.git ./lib/Twig)

Create a new theme, and instead of setting the engine to php-template, set the engine to twig

engine = twig

And presto... your done, you are now using twig instead of php-template for your drupal theme

For more information about Twig, visit http://twig-project.org , http://renebakx.nl/43/twig-for-drupal-example/ or http://renebakx.nl/35/introducing-the-twig-for-drupal-template-engine/





