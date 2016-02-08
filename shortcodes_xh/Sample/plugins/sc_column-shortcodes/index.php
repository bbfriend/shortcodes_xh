<?php
/*
Plugin Name: 	Sc_Column Shortcodes
Version: 		0.6.6.01
Description: 	Adds shortcodes to easily create columns in your posts or pages
Author: 		Utaka
Author URI: 	http://cmsimple-jp.org
Text Domain: 	column-shortcodes
License:		GPLv2

Original: 

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License version 2 as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'CPSH_VERSION', 	'0.6.6.01' );
define( 'CPSH_PREFIX', 	'z_' );

/**
 * Column Shortcodes
 *
 */
class Codepress_Column_Shortcodes {

	/**
	 * Prefix
	 *
	 */
	private $prefix ;

	/**
	 * Variables of CMSimple
	 *
	 */
	private $pthdata;//For CMSimple $pth
	private $admdata;//For CMSimple $adm
	private $editdata;//For CMSimple $edit

	/**
	 * Style Variable
	 *
	 */
	private $regist;

	/**
	 * Constructor
	 *
	 */
	function __construct() {

		global $pth,$adm,$edit; //CMSimple_XH's Variables

		$this->pthdata  = &$pth;
		$this->admdata  = &$adm;
		$this->editdata  = &$edit;

		$this->init();
	}

	/**
	 * Initialize plugin.
	 *
	 */
	public function init() {

		$this->prefix = CPSH_PREFIX;

		//Regist styling
			// Hook_system  http://cmsimpleforum.com/viewtopic.php?f=29&t=9711
				// add_action( 'enqueue_scripts',  array( $this, 'frontend_styles') );
			// Non Set Hook_system
				$this->frontend_styles();

		$this->add_shortcodes();

		// Out put styling
		if(!$this->admdata || (!$this->editdata && $this->admdata) ){
			// Enqueue System 
				// enqueue_style( 'cpsh-shortcodes' );
			//Non Set Enqueue System
				global $hjs;
				$hjs .= $this->regist;
		}
	}

	/**
	 * Regist frontend styles
	 *
	 */
	public function frontend_styles() {
		//Regist styling(Enqueue System http://cmsimpleforum.com/viewtopic.php?f=29&t=9878)
		/*	register_style(
				 'cpsh-shortcodes',
				 $this->pthdata['folder']['plugins'] .'sc_column-shortcodes/css/shortcodes.css',
				 array(),
				 CPSH_VERSION,
				 'all'
			 );
		*/
		// Non Set Enqueue System
			$this->regist= '<link rel="stylesheet" href="' .$this->pthdata['folder']['plugins'] .'sc_column-shortcodes/css/shortcodes.css' .'" type="text/css">';
	}

	/**
	 * Add shortcodes
	 *
	 */
	private function add_shortcodes() {
		foreach ( $this->get_shortcodes() as $shortcode ) {
			add_shortcode( $shortcode['name'], array( $this, 'columns' ) );
		}
	}

	/**
	 * Insert Markup
	 *
	 *
	 * @param array $atts
	 * @param string $content
	 * @param string $name
	 * @return string $ouput Column HTML output
	 */
	function columns( $atts, $content = null, $name='' ) {

		$content = $this->content_helper( $content );

		// last class
		$pos = strpos( $name, '_last' );

		if ( false !== $pos ) {
			$name = str_replace( '_last', ' last_column', $name );
		}

		// remove prefix from classname
		// @todo: prefix css instead of removing the prefix from class attr
		if ( $this->prefix ) {
			$name = str_replace( $this->prefix, '', $name );
		}

		$output = "<div class='content-column {$name}'>{$content}</div>";
		if ( false !== $pos ) {
			$output .= "<div class='clear_column'></div>";
		}

		return $output;
	}

	/**
	 * get shortcodes
	 *
	 */
	function get_shortcodes() {
		static $shortcodes;

		if ( ! empty( $shortcodes ) )
			return $shortcodes;

		// define column shortcodes
		$column_shortcodes = array(
			'full_width' 	=> array( 'display_name' => 'full width' ),
			'one_half' 		=> array( 'display_name' => 'one half' ),
			'one_third' 	=> array( 'display_name' => 'one third' ),
			'one_fourth' 	=> array( 'display_name' => 'one fourth' ),
			'two_third' 	=> array( 'display_name' => 'two third' ),
			'three_fourth' 	=> array( 'display_name' => 'three fourth' ),
			'one_fifth' 	=> array( 'display_name' => 'one fifth' ),
			'two_fifth' 	=> array( 'display_name' => 'two fifth' ),
			'three_fifth' 	=> array( 'display_name' => 'three fifth' ),
			'four_fifth' 	=> array( 'display_name' => 'four fifth' ),
			'one_sixth' 	=> array( 'display_name' => 'one sixth' ),
			'five_sixth' 	=> array( 'display_name' => 'five sixth' )

		);

		if ( ! $column_shortcodes )
			return array();

		foreach ( $column_shortcodes as $short => $options ) {

			// add prefix
			$shortcode = $this->prefix . $short;

			$shortcodes[] =	array(
				'name' 		=> $shortcode,
				'class'		=> $short,
				'options' 	=> array(
					'display_name' 	=> $options['display_name'],
					'open_tag' 		=> '\n'."[{$shortcode}]",
					'close_tag' 	=> "[/{$shortcode}]".'\n',
					'key' 			=> ''
				)
			);

			if ( 'full_width' == $short ) continue;

			$shortcodes[] =	array(
				'name' 		=> "{$shortcode}_last",
				'class'		=> "{$short}_last",
				'options' 	=> array(
					'display_name' 	=> $options['display_name'] . ' (' . 'last' . ')',
					'open_tag' 		=> '\n'."[{$shortcode}_last]",
					'close_tag' 	=> "[/{$shortcode}_last]".'\n',
					'key' 			=> ''
				)
			);
		}

		return $shortcodes;
	}


	/**
	 * Content Helper
	 *
	 *
	 * @param string $content
	 * @param bool $paragraph_tag Filter p-tags
	 * @param bool $br_tag Filter br-tags
	 * @return string Shortcode
	 */
	function content_helper( $content, $paragraph_tag = false, $br_tag = false ) {
		$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );

		if ( $br_tag ) {
			$content = preg_replace( '#<br \/>#', '', $content );
		}

		if ( $paragraph_tag ) {
			$content = preg_replace( '#<p>|</p>#', '', $content );
		}

		return do_shortcode( shortcode_unautop( trim( $content ) ) );
	}
}

new Codepress_Column_Shortcodes();
