<?php
/**
 * shortcodes_xh - main index.php
 *
 * This plugin is to use the familiar WordPress shortcode syntax in CMSimple_XH. 
 * index.php is called by pluginloader and returns (X)HTML META ELEMENTS to template.
 *
 * PHP versions 5
 *
 * @category  CMSimple_XH
 * @package   shortcodes_xh
 * @author    Takashi Uchiyama <http://cmsimple-xh.org/>
 * @core author  Badcow <https://github.com/Badcow/Shortcodes>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version   
 * @link      http://cmsimple-xh.org/
 */


/* utf8-marker = äöüß */

/*
 * Prevent direct access.
 */
if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * The plugin version.
 */
define('SHORTCODES_XH_VERSION', '1.01');

/*
 * Add a tab for admin-menu.
 */
if($plugin_cf['shortcodes_xh']['tab_show'] =='true'){
	$pd_router->add_tab(
	    $plugin_tx['shortcodes_xh']['tab'],
	    $pth['folder']['plugins'] . 'shortcodes_xh/Shortcodes_view.php'
	);
}

/*
 * read shortcodes_library.
 */
$sc_lib = Shortcodes_libraryFolder();
foreach( (array)glob( $sc_lib . '*.php'  )as $filename ) {

//	require_once $filename;
	@include_once $filename;
}

/**
 * Returns the data folder path. Tries to create it, if necessary.
 *
 * @return string
 *
 * @global array The paths of system files and folders.
 * @global array The configuration of the plugins.
 */
function Shortcodes_libraryFolder()
{
    global $pth, $plugin_cf;

    $pcf = $plugin_cf['shortcodes_xh'];

    if ($pcf['library_folder'] == '') {
        $fn = $pth['folder']['plugins'] . 'shortcodes_xh/shortcodes_library/';
    } else {
        $fn = $pth['folder']['base'] . $pcf['library_folder'];
    }
    if (substr($fn, -1) != '/') {
        $fn .= '/';
    }
    if (file_exists($fn)) {
        if (!is_dir($fn)) {
            e('cntopen', 'folder', $fn);
        }
    } else {
        if (!mkdir($fn, 0777, true)) {
            e('cntwriteto', 'folder', $fn);
        }
    }
    return $fn;
}

?>
