<?php

/**
 * Short Code - module Short Code_Memo_view
 *
 * Show ShortCodeMemo on the menu tab
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

function Shortcodes_memo_view()
{
    global $plugin_tx, $pth,$plugin_cf;

//	require_once($pth['folder']['plugins'] .'utf8/str_ireplace.php');

//	$var = "<b>** " . $plugin_tx['shortcodes_xh']['memo'] ." **</b>". tag('br') . utf8_ireplace("\n",'<br>',$plugin_cf['shortcodes_xh']['tab_SimpleMemo']);

	// UTF-8 File 
	$var = "<b>** " . $plugin_tx['shortcodes_xh']['memo'] ." **</b>". tag('br') . str_replace("\n",'<br>',$plugin_cf['shortcodes_xh']['tab_SimpleMemo']);
    return $var;
}

?>
