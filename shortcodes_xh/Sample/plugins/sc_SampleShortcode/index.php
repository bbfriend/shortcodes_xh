<?php
/**
 *  Sample_shortcode 
 *
 * @package	shortcodes_xh
 * @copyright	Copyright (c) 2015 T.Uchiyama <http://cmsimple-jp.org/>
 * @license	http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version 1.0.1
 * @link	http://cmsimple-jp.org

 * 4type Shortcode
 *	1:[y_url href="http://www.cmsimple-xh.org"]Site[/y_url]
 *	2:[y_htag no="1"]ABCDE[/y_htag]
 *	3:[y_class color="#00f" font-size="13px"]CMSimple_XH... [/y_class]
 *	4:[y_hide]This text is only login_user can see [/y_hide]
 */

if ( ! class_exists( 'Sample_shortcode' ) ) { //redeclare Check

	class Sample_shortcode {

		/**
		 * Setup the object
		 *
		 * @param array $options An array of options for this object.
		 */
		function __construct( $options = array() ) {

/*** sample Shortcode ***/

	/** Enclosing ***/
			/**
				1: [y_url href="http://www.cmsimple-xh.org"]Site[/y_url]
			 ***/
			add_shortcode("y_url",  array( $this, 'myUrl' ) );


			/*****
				2: [y_htag no="1"]ABCDE[/y_htag]
			 ***/
			add_shortcode("y_htag",  array( $this, 'htags' ) );


			/*****
				3: [y_class color="#00f" font-size="13px"]CMSimple_XH is conceived as a one administrator system. That's why we could keep it small and simple. [/y_class]
			 ***/
			add_shortcode('y_class',  array( $this, 'sample_class' ) );

			/*****
				4: [sample_hide]This text is only login_user can see [/sample_hide]
			 ***/
			add_shortcode("y_hide", array( $this, 'sample_hide' ) );

			/*****
				5:[dpc]{{{test('aaaaa','bbbb');}}}[/dpc]
			 ***/
			add_shortcode("dpc", array( $this, 'display_plugin_code' ) );
		}




	/** [y_url href=hhttp://www.example.comh]Site[/y_url] ***/
		public function myUrl($atts, $content = null) {
			extract(
				shortcode_atts(
					array(
						"href" => 'http://'
					),
					 $atts
				)
			);
			return '<a href="'.$href.'">'.$content.'</a>';
		}

	/** [y_htag no="1"]ABCDE[/y_htag] ***/
		public function htags($atts, $content = null) {
			extract(
				shortcode_atts(
					array(
						"no" => '1'
					),
					 $atts
				)
			);

			//Nested : http://codex.wordpress.org/Shortcode_API#Nested_Shortcodes
			$content = do_shortcode($content);

			return '<h' .$no.'>'.$content.'</h' .$no.'>';
		}

	/*****
		[y_class color="#f00" size="13px"]CMSimple_XH ... [/y_class]
	***/
		public function sample_class( $atts, $content = null ) {
			extract(
				shortcode_atts(
					array(
						"color" => '#00f',
						"size"=> '16px'
					),
					 $atts
				)
			);
			$val = <<< EOS
				<span style="color:{$color}; font-size:{$size};">{$content}</span>
EOS;
			    return $val;
		}

	/*****
		 [y_hide]This text is only a login_user can see [/y_hide]
	 ***/
		public function sample_hide($x,$text=null){
		    if(!logincheck()){ 
		        return "Here is the text to show to non-logged-in user."; 
		    }else{ 
		        return do_shortcode($text); 
		    } 
		} 

	/*****
		 [dpc]{{{test('aaaaa','bbbb');}}}[/dpc]
	 ***/
		public function display_plugin_code($x,$content=null){
			$return = '';

			$content = htmlspecialchars_decode($content);

			for($i = 0; $i < strlen($content); $i++) {
			    $return .= '&#x'.bin2hex(substr($content, $i, 1)).';';
			}
			return $return;
		} 
	}

	new Sample_shortcode();

} // class_exists
?>