<?php
// Random Image

define('__RANDOM_IMAGE__', '0.0.1');

$random_image = new random_image();

//////////////////////////////////////////////////////////////////
class random_image {
	
	var $image;
	var $width;
	var $height;
	var $method;
	var $default_width;
	var $default_height;
	var $default_method;
	var $min_width;
	var $min_height;
	var $max_width;
	var $max_height;
	var $methods;
	var $colors;
	var $debug;

	//////////////////////////////////////////////////////////	
	function __construct() {
		
		$this->default_width  = 512;
		$this->min_width      = 1;
		$this->max_width      = 1024;
		
		$this->default_height = 512;
		$this->min_height     = 1;
		$this->max_height     = 1024;
		
		$this->methods = array('rand', 'mt_rand');
		$this->default_method = 'rand';
		
		$this->debug = TRUE;
		
		$this->set_width();
		$this->set_height();
		$this->set_method();
		$this->init_image();
		$this->set_colors();
		$this->fill_image();
		$this->debug_info();
		$this->commit_image();

	}

	//////////////////////////////////////////////////////////
	function init_image() {
		$this->image = imagecreatetruecolor($this->width, $this->height);
		if( $this->image ) {
			return;
		}
		print 'ERROR creating image'; 
		exit;
			
	}

	//////////////////////////////////////////////////////////
	function fill_image() {
		for ($x = 0; $x < $this->width; $x++) {
			for ($y = 0; $y < $this->height; $y++) {
				$random_color = $this->get_random_from_method(1, sizeof($this->colors));
				imagesetpixel($this->image, $x, $y, $this->colors[$random_color] );
			}
		}
	}

	/////////////////////////////////////////////////////////////////////
	function get_random_from_method( $min, $max ) {
		switch( $this->method ) {
			case 'rand':
				return rand($min, $max);
			case 'mt_rand':
				return mt_rand($min, $max);
			default:
				return FALSE;
		}
	}
		
	//////////////////////////////////////////////////////////
	function debug_info() {
		if( !$this->debug ) {
			return FALSE;
		}
		imagefilledrectangle(
			$this->image, 
			2, // x1
			$this->height-15, // y1
			222, // x2
			$this->height-2, // y2
			imagecolorallocate($this->image,0,0,0) // color black
		); 
		imagestring(
			$this->image, 
			3, // font
			6, // x
			$this->height-15, // y
			$this->method . ' - ' . $this->width . ' x ' . $this->height, // string
			imagecolorallocate($this->image,0,255,0) // color green
		); 
	}

	//////////////////////////////////////////////////////////
	function commit_image() {
		header('Content-type: image/png');
		imagepng($this->image);
		imagedestroy($this->image);		
	}

	//////////////////////////////////////////////////////////
	function set_width() {
		if( !isset($_GET['w']) || !$_GET['w'] || !$this->is_positive_number($_GET['w'])) {
			$this->width = $this->default_width;
			return FALSE;
		}
		if( $_GET['w'] < $this->min_width ) {
			$this->width = $this->min_width;
			return FALSE;
		}
		if( $_GET['w'] > $this->max_width ) {
			$this->width = $this->max_width;
			return FALSE;
		}
		$this->width = $_GET['w'];
		return TRUE;
	}

	//////////////////////////////////////////////////////////	
	function set_height() {
		if( !isset($_GET['h']) || !$_GET['h'] || !$this->is_positive_number($_GET['h'])) {
			$this->height = $this->default_height;
			return FALSE;
		}
		if( $_GET['h'] < $this->min_height ) {
			$this->height = $this->min_height;
			return FALSE;
		}
		if( $_GET['h'] > $this->max_height ) {
			$this->height = $this->max_height;
			return FALSE;
		}
		$this->height = $_GET['h'];
		return TRUE;
	}

	//////////////////////////////////////////////////////////	
	function set_method() {
		if( !isset($_GET['m']) || !$_GET['m'] || !in_array($_GET['m'], $this->methods) ) {
			$this->method = $this->default_method;
			return FALSE;
		}
		$this->method = $_GET['m'];
		return TRUE;
	}
	
	//////////////////////////////////////////////////////////
	function set_colors() {
		$this->colors = array();
		$this->colors[1] = imagecolorallocate($this->image, 255, 0,   0  ); // red
		$this->colors[2] = imagecolorallocate($this->image, 0,   255, 0  ); // green
		$this->colors[3] = imagecolorallocate($this->image, 0,   0,   255); // blue
		$this->colors[4] = imagecolorallocate($this->image, 0,   255, 255); // cyan
		$this->colors[5] = imagecolorallocate($this->image, 255, 0,   255); // magenta
		$this->colors[6] = imagecolorallocate($this->image, 255, 255, 0  ); // yellow
		$this->colors[7] = imagecolorallocate($this->image, 0,   0,   0  ); // black
		$this->colors[8] = imagecolorallocate($this->image, 255, 255, 255);	// white
	}

	//////////////////////////////////////////////////////////
	function is_positive_number($n='') { 
        if ( preg_match('/^[0-9]*$/', $n )) { return TRUE; }
		return FALSE;
	}
	
} // end class random_image
