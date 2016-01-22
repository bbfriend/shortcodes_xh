# shortcodes_xh
This plugin is to use the familiar <a href="https://codex.wordpress.org/Shortcode_API" target="_blank">WordPress shortcode syntax</a> in CMSimple_XH. Supports enclosing shortcodes such as [myshortcode]content[/myshortcode]
  
1:Unzip the distribution on your computer.  
2:Upload the whole directory to your server into the CMSimple_XH directory.   
◦plugins/shortcodes_xh/* ----> plugins/shortcodes_xh/*.  
◦cmsimple/userfuncs.php ---> cmsimple/userfuncs.php  
 * if you have already have a userfuncs.php, please copy the source code. Very simple code.  

3:.Open your template.htm ,Change 
content() --> xh_content()  

## Usage  See..
◦ <a href="https://codex.wordpress.org/Shortcode_API" target="_blank">Wordpress Shortcode API </a>  
◦ <a href="https://codex.wordpress.org/Function_Reference/add_shortcode" target="_blank">Function Reference/add shortcode </a>  
◦ <a href="https://generatewp.com/shortcodes/" target="_blank">WordPress Shortcodes Generator </a>    


## Function List
global $badcow_shortcode  
  
/** plugins\shortcodes_xh\class\shortcodes_xh.php **/  
 add_shortcode($tag, $func)  
 remove_shortcode($tag)  
 remove_all_shortcodes()  
 shortcode_exists( $tag )  
 has_shortcode( $content, $tag )  
 do_shortcode( $content, $ignore_html = false )  
 get_shortcode_regex( $tagnames = null )  
 do_shortcode_tag( $m )  
 unescape_invalid_shortcodes( $content )   
 get_shortcode_atts_regex()  
 strip_shortcodes( $content )  
 strip_shortcode_tag( $m )  
  
 do_shortcodes_in_html_tags( $content, $ignore_html, $tagnames )   
 shortcode_atts( $pairs, $atts, $shortcode = '' )  
 
   

 /** Core ***/  
 plugins\shortcodes_xh\class\shortcodes.php



