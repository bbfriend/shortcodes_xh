=====================
sample Short Code 
 Operation check
=====================
1:Sample/
	plugins/sc_SampleShortcode 				 --> plugins/sc_SampleShortcode
	plugins/sc_column-shortcode				 --> plugins/sc_column-shortcodes
	plugins/shortcodes_xh/shortcodes_library --> plugins/shortcodes_xh/shortcodes_library

2: Please write to the page...


= Sample Shortcode (plugins/shortcodes_xh/shortcodes_library/*)======
[sample_hello]
[sample_hello2]
[sample_hello2 name="Yourname" myname="Myname"]
[sample_hello3]
[sample_hello3 name="Yourname" myname="Myname"]

= 4type Shortcode (plugins/sc_SampleShortcode)======
* 1:[y_url href="http://www.cmsimple-xh.org"]Site[/y_url]
* 2: no=1,2,3,4,5 [y_htag no="1"]ABCDE[/y_htag]
* 3:[y_class color="#00f" font-size="13px"]CMSimple_XH... [/y_class]
* 4:[y_hide]This text is only login_user can see [/y_hide]

= Column Shortcodes (plugins/sc_column-shortcodes)======
[z_one_half]1/2 [/z_one_half][z_one_half_last]1/2 [/z_one_half_last]
[z_one_third]1/3 [/z_one_third][z_one_third]1/3 [/z_one_third][z_one_third_last]1/3 [/z_one_third_last]
[z_one_fourth]1/4[/z_one_fourth][z_one_fourth]1/4[/z_one_fourth][z_one_fourth]1/4[/z_one_fourth][z_one_fourth_last]1/4[/z_one_fourth_last]
[z_one_fifth]1/5[/z_one_fifth][z_one_fifth]1/5[/z_one_fifth][z_one_fifth]1/5[/z_one_fifth][z_one_fifth]1/5[/z_one_fifth][z_one_fifth_last]1/5[/z_one_fifth_last]
[z_one_half]1/2[/z_one_half][z_one_fourth]1/4[/z_one_fourth][z_one_fourth_last]1/4[/z_one_fourth_last]
[z_two_third]2/3[/z_two_third][z_one_third_last] 1/3[/z_one_third_last]