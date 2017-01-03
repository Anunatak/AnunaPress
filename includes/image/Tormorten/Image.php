<?php 

namespace Tormorten;

use abeautifulsite\SimpleImage;

class Image extends SimpleImage {

	/**
	 * Multiply blend mode (like in InDesign)
	 * 
	 * @param  array  $rgbs The RGB value for the multiply
	 * 
	 * @return Image        This instance for method chaining
	 */
	public function multiply($rgbs = array(216, 0, 26))
	{
	    for ($x = 0; $x < $this->width; ++$x) {
	        for ($y = 0; $y < $this->height; ++$y) {
	            $rgb = imagecolorat($this->image, $x, $y);
	            $TabColors = imagecolorsforindex ( $this->image , $rgb );
	            $color_r = floor($TabColors['red'] * $rgbs[0] / 255);
	            $color_g = floor($TabColors['green'] * $rgbs[1] / 255);
	            $color_b = floor($TabColors['blue'] * $rgbs[2] / 255);
	            $newcol = imagecolorallocate( $this->image, $color_r,$color_g,$color_b );
	            imagesetpixel( $this->image, $x, $y, $newcol );
	        }
	    }
		return $this;
	}

	/**
	 * Resizes image by width but preserves image height
	 * 
	 * @param  integer $width Image width
	 * 
	 * @return Image
	 */
	public function resize_width($width) {
		$height = $this->height;
		return $this->adaptive_resize($width, $height);
	}

	/**
	 * Resizes image by height but preserves image width
	 * 
	 * @param  integer $height Image height
	 * 
	 * @return Image
	 */
	public function resize_height($height) {
		$width = $this->width;
		return $this->adaptive_resize($width, $height);
	}

}