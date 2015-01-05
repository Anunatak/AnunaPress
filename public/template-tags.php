<?php 

/**
 * Resizing of images on the fly
 *
 * @param string $img The source of the image (full URL if not in theme's 'images'-folder)
 * @param array $args The arguments for creating the image
 *
 * @return 	mixed 	Depending of arguments, it will either return or output the image URL or markup
 *
 * @author 	Tor Morten Jensen <tormorten@anunatak.no>
 **/
function anuna_img( $img, $args = '' ) {

	// default arguments
	$defaults = array(
		'type'		=> 'theme', // accepts: theme, url, placeholder, thumbnail
		'width'		=> 1024,
		'height'	=> 768,
		
	);

}

?>