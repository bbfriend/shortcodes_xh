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



