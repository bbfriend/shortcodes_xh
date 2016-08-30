set
1:Unzip

2:plugins/shortcodes_xh/* ----> plugins/shortcodes_xh/*

3:cmsimple/add_to_userfuncs.php ---> cmsimple/userfuncs.php
  * if you have already have a userfuncs.php, please copy the source code. Very simple code.

4: Open cmsimple/function.php
   And Find  ¥¥¥in evaluate_scripting" ,about Line340 
 
            return evaluate_cmsimple_scripting(evaluate_plugincall($text), $compat);

   1 line added to the previous/Before 

	$text = do_shortcode($text); // Add for shortcode_xh


======== Result (final code) New function content() =========================
function evaluate_scripting($text, $compat = true)
{
// @codingStandardsIgnoreEnd

	$text = do_shortcode($text); // Add for shortcode_xh

    return evaluate_cmsimple_scripting(evaluate_plugincall($text), $compat);
}



==========Sample======================================
Read 
  shortcodes_xh/Sample/README.txt

