set
1:Unzip

2:plugins/shortcodes_xh/* ----> plugins/shortcodes_xh/*

3:cmsimple/add_to_userfuncs.php ---> cmsimple/userfuncs.php
  * if you have already have a userfuncs.php, please copy the source code. Very simple code.

4: Open cmsimple/tplfuncs.php
   And Find  ¥¥¥in function content()" ,about Line540 
 
        return $o . preg_replace('/#CMSimple (.*?)#/is', '', $c[$s]);

   1 line added to the previous/Before 

		$c[$s] = do_shortcode($c[$s]); // Add for shortcode_xh


======== Result (final code) New function content() =========================
function content()
{
    global $s, $o, $c, $edit,  $cf ; 

    if (!($edit && XH_ADM) && $s > -1) {
        if (isset($_GET['search'])) {
            $search = XH_hsc(stsl($_GET['search']));
            $words = explode(' ', $search);
            $c[$s] = XH_highlightSearchWords($words, $c[$s]);
        }

        $c[$s] = do_shortcode($c[$s]);// Add for shortcode_xh

        return $o . preg_replace('/#CMSimple (.*?)#/is', '', $c[$s]);
    } else {
        return $o;
    }
}



==========Sample======================================
Read 
  shortcodes_xh/Sample/README.txt

