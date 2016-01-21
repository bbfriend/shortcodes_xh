<?php
/**
 * Sample: Class  & Variables Type
 * Create a shortcode:  
 *		[sample_hello2]
 *		[sample_hello2 name="Yourname" myname="Myname"]
 * Returen
 *	@return string
 */

if ( ! class_exists( 'Sample_hello2' ) ) {

	class Sample_hello2 {

		var $txdata,$pthdata; //Class's Variables

		/**
		 * Setup the object
		 *
		 * @param array $options An array of options for this object.
		 */
		function __construct( $options = array() ) {

			global $pth,$tx; //CMSimple_XH's Variables

			$this->txdata  = &$tx;
			$this->pthdata  = &$pth; 


			add_shortcode( 'sample_hello2', array( $this, 'sample_hello2_func' ) );

		}

		public function sample_hello2_func($atts) {
			extract(
				shortcode_atts(
					array(
						"name" => $this->txdata['site']['title'],//  default
						"myname" => ''			// default '' 
					),
					 $atts
				)
			);

			$schortcode_dir = "./" .strstr(dirname(__FILE__) , trim($this->pthdata['folder']['plugins'],"./"));
			if(!empty($myname)){
			  return 'Hello! ' . $name . ' , myname ' . $myname .': Sample:<b> shortcode +  Parameters +Class</b> ';
			}
			return 'Your Site name = ' . $name . " : Sample: <b>shortcode + CMSimple_XH's Variables + Class</b>  ...(write to ". $schortcode_dir . '/class_sample_hello2.php)' ;
		}

	}

	new Sample_hello2();

} // class_exists