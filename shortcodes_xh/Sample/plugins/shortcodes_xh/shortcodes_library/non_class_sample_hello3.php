<?php
/**
 * Sample: NormalFile(not use class)  & Variables Type
 * Create a shortcode:  
 *		[sample_hello3]
 *		[sample_hello3 name="Yourname" myname="Myname"]
 * Returen
 *	@return string
 */


/**
 * Setup the object
 *
 * @param array $options An array of options for this object.
 */

	add_shortcode( 'sample_hello3',  'sample_hello2_func'  );



function sample_hello2_func($atts) {

	global $pth,$tx; //CMSimple_XH's Variables

	extract(
		shortcode_atts(
			array(
				"name" => $tx['site']['title'],//  default
				"myname" => ''			// default '' 
			),
			 $atts
		)
	);

	$schortcode_dir = "./" .strstr(dirname(__FILE__) , trim($pth['folder']['plugins'],"./"));

	if(!empty($myname)){
	  return 'Hello! ' . $name . ' , myname ' . $myname .': Sample3: <b>NormalFile(not use class)Type of Sample2</b> ';
	}
	return 'Your Site name = ' . $name . " : Sample3: <b>NormalFile(not use class)Type of Sample2</b>  ...(write to ". $schortcode_dir . '/class_sample_hello3.php)' ;
}