#The drupal 7 implementation of the Twig template language AKA TFD

##General information and installation

For more information about Twig, visit http://twig-project.org

To use this engine you will need to clone Twig from git (https://github.com/fabpot/Twig.git) into 
your sites/all/libraries folder


#git clone https://github.com/fabpot/Twig.git ./sites/all/libraries/Twig

And this library also cloned into /sites/all/libraries in a folder called TFD

#git clone https://github.com/renebakx/twig-for-druapl.git ./sites/all/libraries/TFD

Then move the twig.engine file to ./themes/engines/twig/ so that is on the same level as the phptemplate 
engine drupal comes with.

To create a theme for twig, simply set engine = twig in your theme.info and start creating templates


##More information and usage of Twig##
Please refer to the original project documentation found on http:/twig-project.org

##Drupal specific extensions

### Autorender

This version of the TWIG engine uses auto render to prevent themers get RSI from typing
{{node.field_somefield|render}} for every single field they want to render from the
render array (of doom) so the can safely type {{node.field_something}} 

On rendering of the compiled template TFD check if the called variable is a string, callable or array.
If it's a string it simple does echo $string, if it's a callable it return a proper method() for it.
And if it's an array, it assumes it's a renderable array and maps it to the render($string); method of drupal.

This way the objects hidden with hide() are respected.

###Functions aka {% %} calls

**theme**, maps to the drupal theme() method 
	{% theme('node',vars.nodelist.node.1) %}
	
**render** and **hide** maps to the render() and hide() methods
	{% hide(page.header) %}

**path_to_theme**, gives you the path the current theme, concat of base_path() + path_to_theme()
	<img src="{%path_to_theme%}/assets/asset.jpg">
	
**with**, allows a scope-shift into a defined array.
	{% with expr [as localName] [, expr2 [as localName2], [....]]  {sandboxed|merged} %}
    	..Do Stuff..
  	{% endwith %}
For a more detailed example see /engines/twig/lib/TFD/TokenParser/With.php

**switch**, gives you a php like switch system

	{% switch page.regions %}
		{%case 'header %}
			{% include 'header.tpl.html'}
			{# no break needed, as this default #}
		{%case 'content' fallthrough %}
			{# do something and fall trough to next case #}
	{% endswitch %}

###Filters (aka {{variable|filter}})

**dump**, if the devel module is activated, a dpr is issued. Or you can decide yourself by adding a parameter dump('dpm')
Parameters are : var_dump or v, print_r or p,  dpr, dpm

**url** maps to the url() function
	{{node.nid|url}}

**image_url** maps an image cache preset to a filename
{{node.fid|image_url('preset')}}

**t** maps to the t() method
{{'Download'|t}} or {{'Download'|t('nl')}}

**render** like the render function, but now as filter

	{{page.footer|render}}
	{{page.header.form.search|render}}

** hide, same the render function but then to hide();

### Expanding filters 

You can expand twig with your own filters, by implementing hook_twig_filters(&$filters) in your own module

	my_module_twig_filters(&$filters){
		$filters['foo'] = new Twig_Filter_Function('my_module_twig_filter_foo');
	}
	
	function my_module_twig_filter_foo($var){
		return $var .' with foo!';
	}
	
Or just map it to an php function
	my_module_twig_filters(&$filters){
		$filters['rot13'] = new Twig_Filter_Function('str_rot13');
	}

Jups.. it's that easy, so what are you waiting for.. get Twiggy with it :-)
\


	

