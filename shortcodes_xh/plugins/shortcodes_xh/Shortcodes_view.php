<?php

/**
 * Short Code - module Short Code_view
 *
 * Show ShortCodelist in the menu tab
 * 
 *
 * PHP versions 5
 *
 * @category  CMSimple_XH
 * @package   shortcodes_xh
 * @author    Takashi Uchiyama <http://cmsimple-xh.org/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   
 * @link      http://cmsimple-xh.org/
 */

/* utf8-marker = äöüß */

function Shortcodes_view()
{
    global $sn, $su, $plugin_tx, $pth, $onload, $bjs;

//    $bjs .= <<<EOT
// <script type="text/javascript">/* <![CDATA[ */
//var SHORT_CODES_VIEW = {};

//SHORT_CODES_VIEW.init = function () {
// 
// 

// 
// 
// 
//};
// /* ]]> */</script>
//EOT;
//    $onload .= 'SHORT_CODES_VIEW.init();';

	global $badcow_shortcode;

	$var = '<b>'.$plugin_tx['shortcodes_xh']['available'] . '</b>'. $plugin_tx['shortcodes_xh']['more_information'] . tag('br');

	if(!isset($badcow_shortcode) ){
		$var .= $plugin_tx['shortcodes_xh']['none'];
		return $var;
	} 

	$shortcode2 = (array) $badcow_shortcode; // Cast

	$keys = array_keys( $shortcode2["\0Badcow\Shortcodes\Shortcodes\0shortcodes"] );

	sort($keys);

	foreach ($keys as $key) {
	    $var .= ' [' . $key . ' / ';
	} 

    return $var;
}

?>
