<?php
/*** Most Simple Sample Short code
	Useage:	 [sample_hello]
	Action:	 Display "Congratulations..."
 ***/
function sample_hello_func() {
  return 'Congratulation (^o^)/  Installation Success! Shortcode_xh ....(sample :wrote in shortcodes_xh/shortcodes_library/)';
}
add_shortcode( 'sample_hello', 'sample_hello_func' ); 