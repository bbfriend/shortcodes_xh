<?php
/**
 *  Sample_shortcode 
 *
 * @package	shortcodes_xh
 * @copyright	Copyright (c) 2015 T.Uchiyama <http://cmsimple-jp.org/>
 * @license	http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @version 1.0.1
 * @link	http://cmsimple-jp.org
 */

if ( ! class_exists( 'Sample_shortcode' ) ) {

	/**
	 * 
	 */
	class Sample_shortcode {

		/**
		 * Setup the object
		 *
		 * @param array $options An array of options for this object.
		 */
		function __construct( $options = array() ) {

			
//			global $shortcode;


/*** sample Shortcode ***/

		// Shortcodes_XH : Short code handler settings



	/** Enclosing ***/
			/**
				 [sample_url href="http://www.cmsimple-xh.org"]Site[/sample_url]
			 ***/
			add_shortcode("sample_url",  array( $this, 'myUrl' ) );


			/*****
				 [sample_htag no="1"]ABCDE[/sample_htag]
			 ***/
			add_shortcode("sample_htag",  array( $this, 'htags' ) );


			/*****
				 [sample_class color="#00f" font-size="13px"]CMSimple_XH is conceived as a one administrator system. That's why we could keep it small and simple. [/sample_class]
			 ***/
			add_shortcode('sample_class',  array( $this, 'sample_class' ) );

			/*****
				 [sample_hide]This text is only login_user can see [/sample_hide]
			 ***/
			add_shortcode("sample_hide", array( $this, 'sample_hide' ) );

		}


	/** [sample_url href=hhttp://www.example.comh]Site[/sample_url] ***/
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

	/** [sample_htag no="1"]ABCDE[/sample_htag] ***/
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
//			global $badcow_shortcode; 
//			$content = $badcow_shortcode->process($content);
			$content = do_shortcode($content);

			return '<h' .$no.'>'.$content.'</h' .$no.'>';
		}

	/*****
		[sample_class color="#f00" size="13px"]CMSimple_XH ... [/sample_class]
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
		 [sample_hide]This text is only a login_user can see [/sample_hide]
	 ***/
		public function sample_hide($x,$text=null){
		    if(!logincheck()){ 
		        return "Here is the text to show to non-logged-in user."; 
		    }else{ 
//				global $badcow_shortcode; 
//		        return $badcow_shortcode->process($text); 
		        return do_shortcode($text); 
		    } 
		} 

	}

	new Sample_shortcode();

} // class_exists
?>