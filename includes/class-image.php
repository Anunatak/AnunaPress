<?php

/**
 * Anuna_Image
 *
 * A neat class to resize images in WordPress on the fly
 *
 * @link       https://github.com/Anunatak/AnunaPress
 * @since      1.0.0
 *
 * @package    Anunapress
 * @subpackage Anunapress/includes
 */
class AnunaPress_Image {

    /**
     * The source image
     * @var string
     */
    protected $image;

    /**
     * The image arguments
     * @var array
     */
    protected $args;

    /**
     * The current image URL
     * @var string
     */
    protected $src;

    /**
     * Image classes
     * @var string
     */
    protected $classes;

    /**
     * Alt info
     * @var string
     */
    protected $alt;

    /**
     * The image title
     * @var string
     */
    protected $title;

    /**
     * The path to the theme folder image directory
     * @var string
     */
    protected $folder_dir;

    /**
     * The URL to the theme folder image directory
     * @var string
     */
    protected $folder_url;

    /**
     * Whether to crop the image or not
     * @var boolean
     */
    protected $crop;

    /**
     * Whether to scale smaller images up or not
     * @var boolean
     */
    protected $upscale;

    /**
     * If a resize is to be performed
     * @var boolean
     */
    protected $do_resize;

    /**
     * The desired width of the image
     * @var integer
     */
    protected $width;

    /**
     * The desired height of the image
     * @var integer
     */
    protected $height;

    /**
     * The ID for the attachment
     * @var mixed
     */
    protected $attachment_id;

    /**
     * The data to be returned/outputted.
     * @var mixed
     */
    protected $return;

    /**
     * Whether to echo or return the data
     * @var boolean
     */
    protected $echo;

    /**
     * The current post ID
     * @var integer
     */
    protected $post_id;

    /**
     * Image Defaults
     * @var array
     */
    protected $defaults = array(
        'type'             => 'theme', // accepts: theme, url, placeholder, thumbnail
        'width'            => 1024, // the default width of the image
        'height'           => 768, // the height of the image
        'crop'             => true, // to hard or soft crop the image
        'output'           => 'html', // accepts: html, array, src
        'upscale'          => true, // blows up smaller images to fit scale,
        'classes'          => '', // the classes for the image
        'alt'              => '', // the image alt text.
        'title'            => '', // the title of the image.
        'id'               => '', // the ID of the image.
        'theme_folder'     => '/images/', // the default image folder in the theme
        'post_id'          => null, // the ID of the current post. defaults to $post->ID
        'echo'             => true, // to echor or not
    );

    /**
     * Make sure everything is ready
     * @param string $image The image we are trying to resize. Could be empty if we don't know the URL.
     * @param mixed  $args  An array or a querystring containing the image arguments
     */
    public function __construct($image = '', $args)
    {
        $this->image = $image;
        $this->setArgs($args);
    }

    /**
     * Parses image arguments with the defaults and sets them
     * @param mixed $args An array or a querystring containing the image arguments
     */
    protected function setArgs($args)
    {
        $defaults   = apply_filters( 'anuna_img_defaults', $this->defaults );
        $args       = wp_parse_args( $args, $this->defaults );
        $this->args = apply_filters( 'anuna_img_args_parsed', $args );
    }

    /**
     * Processes the image
     * This is the method that is used outside of the class to get the finalized images
     * @return mixed
     */
    public function process()
    {
        $this->setVars();
        $this->setImage();
        $this->resize();
        $this->setOutput();
        if($this->echo) {
            echo $this->return;
        }
        else {
            return $this->return;
        }
    }

    /**
     * Set class variables
     */
    protected function setVars()
    {
        $this->src           = ''; // the source url
        $this->classes       = $this->args['classes']; // all the classes
        $this->alt           = ''; // the alt text
        $this->title         = ''; // the title
        $this->folder_dir    = get_template_directory() . $this->args['theme_folder'];
        $this->folder_url    = get_template_directory_uri() . $this->args['theme_folder'];
        $this->crop          = $this->args['crop'] === 'true' || $this->args['crop'] === true || $this->args['crop'] === '1' ? true : false;
        $this->upscale       = $this->args['upscale'] === 'true' || $this->args['upscale'] === true || $this->args['upscale'] === '1' ? true : false;
        $this->do_resize     = false;
        $this->width         = $this->args['width'];
        $this->height        = $this->crop ? $this->args['height'] : null;
        $this->attachment_id = 0;
        $this->return        = false;
        $this->echo          = $this->args['echo'] === 'true' || $this->args['echo'] === true || $this->args['echo'] === '1' ? true : false;

        if( $this->args['post_id'] === null ) {
            global $post;
            $this->post_id = null;
            if($post)
                $this->post_id = $post->ID;
        }
        else {
            $this->post_id = $this->args['post_id'];
        }
    }

    /**
     * Set the image
     */
    protected function setImage()
    {
        $method = 'image'. ucfirst($this->args['type']);
        if(method_exists($this, $method)) {
            $this->$method();
        }
        else {
            $this->imageDefault();
        }
    }

    /**
     * For theme images
     */
    protected function imageTheme()
    {
        if( file_exists( $this->folder_dir . $this->image ) ) {
            $this->attachment_id = 'theme-'. sanitize_title( $this->image );
            $this->src           = $this->folder_url . $this->img;
            $this->classes       .= $this->attachment_id;

            // get alt text
            $this->alt   = $this->args['alt'] ? $this->args['alt'] : $this->image;

            // get title text
            $this->title = $this->args['title'] ? $this->args['title'] : $this->image;
        }
    }

    /**
     * For placeholders
     */
    protected function imagePlaceholder()
    {
        // start building the url
        $this->src = 'http://lorempixel.com/';

        // set the width
        $alternate = $this->args['width'];

        // set the height if crop is true
        if( $crop ) {
            $alternate .= '/'. $this->args['height'];
        }

        $src = $src . $alternate;

        // check if file exists locally
        if( ini_get('allow_url_fopen') ) {

            $filename  = sanitize_title( $alternate );
            $ext       = 'gif';
            $dir       = wp_upload_dir();
            $uploadDir = $dir['basedir'];
            $uploadUrl = $dir['baseurl'];
            $fileDir   = $uploadDir . '/placeholders/' . $filename . '.' . $ext;
            $fileUrl   = $uploadUrl . '/placeholders/' . $filename . '.' . $ext;

            if( file_exists( $fileDir ) ) {
                $this->src = $fileUrl;
            }
            else {
                if( !is_dir( $uploadDir . '/placeholders/' ) ) {
                    wp_mkdir_p( $uploadDir . '/placeholders/' );
                }
                $imageSrc = file_get_contents( $src );
                file_put_contents($fileDir, $imageSrc);
                $this->src = $fileUrl;
            }
        }

        // set the alt text
        $this->alt   = $this->args['alt'];

        // set the title text
        $this->title = $this->args['title'];
    }

    /**
     * For image thumbnails
     *
     * Fetches the featured image for the current post
     */
    protected function imageThumbnail()
    {
        // get the attachment ID
        $this->attachment_id = get_post_thumbnail_id( $this->post_id );

        // get the attachment src
        $this->src           = wp_get_attachment_url( $this->attachment_id );

        // get alt text
        $this->alt           = $this->args['alt'] ? $this->args['alt'] : get_post_meta( $this->attachment_id, '_wp_attachment_image_alt', true );

        // get title text
        $this->title         = $this->args['title'] ? $this->args['title'] : get_the_title( $this->attachment_id );

        // perform resizing
        $this->do_resize     = true;
    }

    /**
     * For all other images
     *
     * If no other method is suited we'll assume we have provided an url and gets ready
     * to process that.
     */
    protected function imageDefault()
    {
        // set the source to the image for all else
        $this->src = $this->image;

        $this->attachment_id    = sanitize_title( basename($this->src) );

        // get alt text
        $this->alt          = $this->args['alt'] ? $this->args['alt'] : $this->src;

        // get title text
        $this->title            = $this->args['title'] ? $this->args['title'] : $this->src;

        // perform resizing
        $this->do_resize        = true;
    }

    /**
     * Does the actual resizing of the image
     * @see https://github.com/syamilmj/Aqua-Resizer Aqua Resizer – WordPress Image resizing on the fly.
     */
    protected function resize()
    {
        if( $this->do_resize ) {
            require_once plugin_dir_path( ANUNAPRESS_FILE ) . 'includes/vendor/aqresizer/aq_resizer.php';
            $old_src = $this->src;

            if(substr($this->src, 0, 4) !== 'http') {
                $this->src = home_url($this->src);
            }
            $this->src = aq_resize( $this->src, $this->width, $this->height, $this->crop, true, $this->upscale );
            if(!$this->src) {
                $this->src = $old_src;
            }

        }
    }

    /**
     * Sets the output method
     */
    protected function setOutput()
    {
        $method = 'output'. ucfirst($this->args['output']);
        if(method_exists($this, $method)) {
            $this->$method();
        }
        else {
            $this->outputDefault();
        }
    }

    /**
     * Sets HTML output
     */
    protected function outputHtml()
    {
        $id = $this->args['id'] ? $this->args['id'] : 'attachment-image-' . $this->attachment_id;

        $this->return = '<img ';
        $this->return .= 'src="'. $this->src .'" ';
        $this->return .= 'alt="'. basename($this->alt) .'" ';
        $this->return .= 'title="'. basename($this->title) .'" ';
        $this->return .= 'class="'. $this->classes .'" ';
        $this->return .= 'id="'. $id .'" ';
        $this->return .= '/>';
    }

    /**
     * Provides a nice array that can be used
     */
    protected function outputArray()
    {
        $this->return = array(
            'src'       => $this->src,
            'alt'       => $this->alt,
            'title'     => $this->title,
            'class'     => $this->classes,
            'id'        => $this->id,
            'original'  => $this->image
        );
    }

    /**
     * Output the image URL
     */
    protected function outputSrc() {
        $this->return = $this->src;
    }

    /**
     * By default we'll just output what we got in.
     */
    protected function outputDefault()
    {
        $this->return = $this->image;
    }

}

if(!class_exists('Anuna_Img')) {
    class Anuna_Img extends AnunaPress_Image {}
}
