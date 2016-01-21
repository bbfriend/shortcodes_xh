<?php

/**
 * Shortcodes for CMSimple_XH

 *This is a port of WordPress' brilliant shortcode feature for use outside of WordPress. The code has remained largely unchanged.
The purpose of this project is to use the familiar WordPress shortcode syntax in CMSimple_XH.

 * Version:    1.0.1
 * Build:      20151225
 * Copyright:  Takashi Uchiyama
 * Website:    http://cmsimple-jp.org
 * */

	global $pth;

    include_once($pth['folder']['plugins'] . 'shortcodes_xh/core/Shortcodes.php');

	$badcow_shortcode = new Badcow\Shortcodes\Shortcodes();

    include_once($pth['folder']['plugins'] . 'shortcodes_xh/core/shortcodes_xh.php');

/**
 * Returns the contents area.
 *
 * @return string (X)HTML.
 *
 * @global int    The index of the current page.
 * @global string The output of the contents area.
 * @global array  The content of the pages.
 * @global bool   Whether edit mode is active.
 * @global array  The configuration of the core.
 */
function xh_content()
{
    global $s, $o, $c, $edit,  $cf ; 

    if (!($edit && XH_ADM) && $s > -1) {
        if (isset($_GET['search'])) {
            $search = XH_hsc(stsl($_GET['search']));
            $words = explode(' ', $search);
            $c[$s] = XH_highlightSearchWords($words, $c[$s]);
        }

// Add for shortcode_xh
//		global  $badcow_shortcode; 
//		$c[$s] = $badcow_shortcode->$shortcode->process($c[$s]);
	//	do_shortcode() == $badcow_shortcode->$shortcode->process()
		$c[$s] = do_shortcode($c[$s]);


        return $o . preg_replace('/#CMSimple (.*?)#/is', '', $c[$s]);
    } else {
        return $o;
    }
}

/*** Sample Short code
	Useage:	 [sample_hello]
	Action:	 Display "Congratulations!"
 ***/
function sample_hello_func() {
  return 'Congratulation (^o^)/  Installation Success! Shortcode_xh ....(sample :wrote in cmsimple/userfuncs.php)';
}
add_shortcode( 'sample_hello', 'sample_hello_func' ); 

