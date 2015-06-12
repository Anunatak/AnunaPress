<?php 

/**
 * Template Tags 
 *
 * These functions are pluggable if defined before the 'wp' 
 * action hook e.g. on 'after_theme_setup'. None of the functions 
 * works in code before the 'wp' action hook.
 *
 * @link       https://github.com/Anunatak/AnunaPress
 * @since      1.0.0
 *
 * @package    Anunapress
 * @subpackage Anunapress/includes
 */

if( apply_filters( 'anunatak_load_anuna_img', true ) ) {

	if( !function_exists( 'anuna_img' ) ) :

	/**
	 * Resizing of images on the fly
	 *
	 * @param 	string 	$img 	(required) The source of the image (full URL if not in theme's 'images'-folder)
	 * @param 	array 	$args 	(optional) The arguments for creating the image
	 *
	 * @return 	mixed 	Depending of arguments, it will either return or output the image URL or markup
	 *
	 * @author 	Tor Morten Jensen <tormorten@anunatak.no>
	 **/
	function anuna_img( $img = '', $args = '' ) {

		// filter the merged args
		$args			= apply_filters( 'anuna_img_args_parsed', $args );

		// default placeholder args
		$placeholder 	= array(
			'color'					=> '000000',
			'background'			=> 'c0c0c0',
			'text'					=> __( 'Placeholder', 'anunapress' )
		);

		// default arguments
		$defaults 		= array(
			'type'					=> 'theme', // accepts: theme, url, placeholder, thumbnail
			'width'					=> 1024, // the default width of the image
			'height'				=> 768, // the height of the image
			'crop'					=> true, // to hard or soft crop the image
			'output'				=> 'html', // accepts: html, array, src
			'upscale'				=> true, // blows up smaller images to fit scale,
			'classes'				=> '', // the classes for the image
			'alt'					=> '', // the image alt text.
			'title'					=> '', // the title of the image.
			'id'					=> '', // the ID of the image.
			'theme_folder'			=> '/images/', // the default image folder in the theme
			'placeholder'			=> $placeholder, // placeholder options
			'post_id'				=> null, // the ID of the current post. defaults to $post->ID
			'echo'					=> true, // to echor or not
		);

		// filter the defaults
		$defaults	= apply_filters( 'anuna_img_defaults', $defaults );

		// merge with args
		$args 		= wp_parse_args( $args, $defaults );

		// filter the merged args
		$args		= apply_filters( 'anuna_img_args_parsed', $args );

		// default vars
		$src 			= ''; // the source url
		$classes 		= $args['classes']; // all the classes
		$alt 			= ''; // the alt text
		$title 			= ''; // the title
		$folder_dir 	= get_template_directory() . $args['theme_folder'];
		$folder_url 	= get_template_directory_uri() . $args['theme_folder'];
		$crop 			= $args['crop'] === 'true' || $args['crop'] === true ? true : false; 
		$upscale 		= $args['upscale'] === 'true' || $args['upscale'] === true ? true : false;
		$do_resize 		= false;
		$width 			= $args['width'];
		$height 		= $crop ? $args['height'] : null;
		$attachment_id 	= 0;
		$return 		= false;
		$echo 			= $args['echo'] === 'true' || $args['echo'] === true ? true : false; 

		if( $args['post_id'] === null ) {
			global $post;
			$post_id = null;
			if($post)
				$post_id = $post->ID;
		}
		else {
			$post_id = $args['post_id'];
		}

		// find the type
		switch ( $args['type'] ) {

			// images in theme folder
			case 'theme' :

				if( file_exists( $folder_dir . $img ) ) {
					$attachment_id 	= 'theme-'. sanitize_title( $img ); 
					$src 			= $folder_url . $img;
					$classes 		.= $attachment_id;

					// get alt text
					$alt 			= $args['alt'] ? $args['alt'] : $img;

					// get title text
					$title 			= $args['title'] ? $args['title'] : $img;
				}

				break;

			// placeholder images
			case 'placeholder' :

				// start building the url
				$src = 'http://placehold.it/';

				// set the width
				$alternate = $args['width'];

				// set the height if crop is true
				if( $crop ) {
					$alternate .= 'x'. $args['height'];
				}

				// set the background color
				$alternate .= '/'. $args['placeholder']['background'];

				// set the color
				$alternate .= '/'. $args['placeholder']['color'];

				// set the text
				$alternate .= '&text='. urlencode( $args['placeholder']['text'] );

				$src = $src . $alternate;

				// check if file exists locally
				if( ini_get('allow_url_fopen') ) {

					$filename 	= sanitize_title( $alternate );
					$ext 		= 'gif';

					$dir 		= wp_upload_dir();

					$uploadDir 	= $dir['basedir'];
					$uploadUrl 	= $dir['baseurl'];

					$fileDir 	= $uploadDir . '/placeholders/' . $filename . '.' . $ext; 
					$fileUrl 	= $uploadUrl . '/placeholders/' . $filename . '.' . $ext; 

					if( file_exists( $fileDir ) ) {
						$src = $fileUrl;
					}
					else {

						if( !is_dir( $uploadDir . '/placeholders/' ) ) {
							wp_mkdir_p( $uploadDir . '/placeholders/' );
						}

						$imageSrc = file_get_contents( $src );

						file_put_contents($fileDir, $imageSrc);

						$src = $fileUrl;
					}


				}

				// set the alt text
				$alt = $args['alt'] ? $args['alt'] : $args['placeholder']['text'];

				// set the title text
				$title = $args['title'] ? $args['title'] : $args['placeholder']['text'];
				
				break;

			case 'thumbnail' :

				// get the attachment ID
				$attachment_id 	= get_post_thumbnail_id( $post_id );

				// get the attachment src
				$src 			= wp_get_attachment_url( $attachment_id );

				// get alt text
				$alt 			= $args['alt'] ? $args['alt'] : get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );

				// get title text
				$title 			= $args['title'] ? $args['title'] : get_the_title( $attachment_id );

				// perform resizing
				$do_resize 		= true;

				break;
			
			default:
				
				// set the source to the image for all else
				$src = $img;

				$attachment_id	= sanitize_title( $src );

				// get alt text
				$alt 			= $args['alt'] ? $args['alt'] : $src;

				// get title text
				$title 			= $args['title'] ? $args['title'] : $src;

				// perform resizing
				$do_resize 		= true;

				break;
		}

		if( $do_resize ) {

			require_once plugin_dir_path( __FILE__ ) . '../includes/aqresizer/aq_resizer.php';
			$old_src = $src;
			$src = aq_resize( $src, $width, $height, $crop, true, $upscale );
			if(!$src) {
				$src = $old_src;
			}

		}

		switch( $args['output'] ) {

			// builds the html
			case 'html':

				$id = $args['id'] ? $args['id'] : 'attachment-image-' . $attachment_id;

				$return = '<img ';
				$return .= 'src="'. $src .'" ';
				$return .= 'alt="'. $alt .'" ';
				$return .= 'title="'. $title .'" ';
				$return .= 'class="'. $classes .'" ';
				$return .= 'id="'. $id .'" ';
				$return .= '/>';

				break;

			// builds the array
			case 'array':

				$return = array(
					'src' 		=> $src,
					'alt' 		=> $alt,
					'title'		=> $title,
					'class'		=> $classes,
					'id'		=> $id,
					'original'	=> $img
				);

				break;

			// returns the source
			case 'src':

				$return = $src;

				break;

			default:
				$return = $img;
				break;

		}

		if( $echo )
			echo $return;
		else
			return $return;



	}

	endif;

}

?>