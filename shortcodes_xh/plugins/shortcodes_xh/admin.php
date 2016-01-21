<?php

/**
 *  shortcodes_xh 
 *
 * @package	shortcodes_xh
 * @copyright	Copyright (c) 2015 T.Uchiyama <http://cmsimple-jp.org/>
 * @license	http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version 1.0.1
 * @link	http://cmsimple-jp.org
 */


/*
 * Prevent direct access.
 */
if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
/*
 * Register the plugin menu items.
 */
if (function_exists('XH_registerStandardPluginMenuItems')) {
    XH_registerStandardPluginMenuItems(false);
}

/**
 * Returns the plugin version information view.
 *
 * @return string  The (X)HTML.
 */
function shortcodes_xh_version()
{
    global $pth;

    return '<h1>Shortcodes_xh</h1>'."\n"
	. tag('img src="'.$pth['folder']['plugins'].'shortcodes_xh/help/ShortCode_XH.png" style="float: left; margin: 0 20px 20px 0"')
	. '<p>This plugin is to use the familiar <a href="https://codex.wordpress.org/Shortcode_API" target="_blank">WordPress shortcode syntax</a> in CMSimple_XH.</p>'
	. '<p>Version: '.SHORTCODES_XH_VERSION.'</p>'."\n"
	. '<p>Copyright &copy; 2015 <a href="http://cmsimple-jp.org" target="_blank">cmsimple-jp.org</a></p>'."\n"
	. '<p>Original <a href="https://github.com/Badcow/Shortcodes" target="_blank">Badcow/Shortcodes Latest commit 5 Apr 2015</a></p>'
	. '<p style="text-align: justify">'
	. '<b>License</b>'. tag('br') . "\n"
	. ' Art License Terms : <a href="http://creativecommons.org/licenses/by-sa/4.0/" target="_blank">Creative Commons License </a> . Detail <a href="https://github.com/Badcow/Shortcodes" target="_blank">https://github.com/Badcow/Shortcodes</a>'. tag('br')."\n"
	. ' Software License terms : <a href="http://www.gnu.org/licenses/" target="_blank">GPLv3.</a>';
}


/*
 * Handle the plugin administration.
 */
if (isset($shortcodes_xh) && $shortcodes_xh == 'true') {
//    $o .= print_plugin_admin('on'); //Returns the plugin menu.

//    if ($admin == 'plugin_config' || $admin == 'plugin_language') {
    if ($admin == 'plugin_language') {
        $o .= print_plugin_admin('on');
    } else {
        $o .= print_plugin_admin('off');
    }
    switch ($admin) {
    case '':
    case 'plugin_main':
	$o .= shortcodes_xh_version() .ShortcodesXH_systemCheck() ;
	break;
    default://Handles reading and writing of plugin files
	$o .= plugin_admin_common($action, $admin, $plugin);
    }
}

/**
 * Returns requirements information.
 *
 * @return string (X)HTML
 *
 * @global array The paths of system files and folders.
 * @global array The configuration of the plugins.
 * @global array The localization of the core.
 * @global array The localization of the plugins.
 */
function ShortcodesXH_systemCheck()
{
    global $pth, $plugin_cf, $tx, $plugin_tx ,$badcow_shortcode;

    define('SHCODE_PHP_VERSION', '5.3');
    $ptx = $plugin_tx['shortcodes_xh'];
    $imgdir = $pth['folder']['plugins'] . 'shortcodes_xh/images/';
    $ok = tag('img src="' . $imgdir . 'ok.png" alt="ok"');
    $warn = tag('img src="' . $imgdir . 'warn.png" alt="warning"');
    $fail = tag('img src="' . $imgdir . 'fail.png" alt="failure"');
    $o = tag('hr') . '<h4>' . "System check" . '</h4>'
        . (version_compare(PHP_VERSION, SHCODE_PHP_VERSION) >= 0 ? $ok : $fail)
        . '&nbsp;&nbsp;' . sprintf("PHP version >= %s" , SHCODE_PHP_VERSION)
        . tag('br') . tag('br') . PHP_EOL;
    $o .= tag('br') . (@isset($badcow_shortcode)  ? $ok : $warn)
        . '&nbsp;&nbsp;' . 'Class Badcow\Shortcodes\Shortcodes Load' . PHP_EOL;
    $o .= tag('br') . (function_exists('add_shortcode')  ? $ok : $warn)
        . '&nbsp;&nbsp;' . 'add_shortcode()' . PHP_EOL;
    $o .= tag('br') . (function_exists('do_shortcode')  ? $ok : $warn)
        . '&nbsp;&nbsp;' . 'do_shortcode()' . PHP_EOL;

    $o .= tag('br') . (strtoupper($tx['meta']['codepage']) == 'UTF-8' ? $ok : $warn)
        . '&nbsp;&nbsp;' . "Encoding 'UTF-8' configured" . PHP_EOL;

    return $o;
}

?>
