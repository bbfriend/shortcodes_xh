<?php
/**** CMSimple_XH  shortcodes_xh.php
 * include from cmsimple/userfuncs.php
 * @package   shortcodes_xh
 * @author    Takashi Uchiyama <http://cmsimple-jp.org/>
 *
 * Original :WordPress Ver4.4
***/
/**
 * CMSimple_XH API for creating bbcode like tags or what CMSimple_XH calls
 * "shortcodes." The tag and attribute parsing or regular expression code is
 * based on the Textpattern tag parser.
 *
 * A few examples are below:
 *
 * [shortcode /]
 * [shortcode foo="bar" baz="bing" /]
 * [shortcode foo="bar"]content[/shortcode]
 *
 * Shortcode tags support attributes and enclosed content, but does not entirely
 * support inline shortcodes in other shortcodes. You will have to call the
 * shortcode parser in your function to account for that.
 *
 * To apply shortcode tags to content:
 *
 *     $out = do_shortcode( $content );
 *
 * @link https://codex.wordpress.org/Shortcode_API
 *
 * @subpackage Shortcodes
 */

/**
 * Container for storing shortcode tags and their hook to call for the shortcode
 *
 * @name $shortcode_tags
 * @var array
 * @global array $shortcode_tags
 */
$shortcode_tags = array();

/**
 * Add hook for shortcode tag.
 *
 * There can only be one hook for each shortcode. Which means that if another
 * plugin has a similar shortcode, it will override yours or yours will override
 * theirs depending on which order the plugins are included and/or ran.
 *
 * Simplest example of a shortcode tag using the API:
 *
 *     // [footag foo="bar"]
 *     function footag_func( $atts ) {
 *         return "foo = {
 *             $atts[foo]
 *         }";
 *     }
 *     add_shortcode( 'footag', 'footag_func' );
 *
 * Example with nice attribute defaults:
 *
 *     // [bartag foo="bar"]
 *     function bartag_func( $atts ) {
 *         $args = shortcode_atts( array(
 *             'foo' => 'no foo',
 *             'baz' => 'default baz',
 *         ), $atts );
 *
 *         return "foo = {$args['foo']}";
 *     }
 *     add_shortcode( 'bartag', 'bartag_func' );
 *
 * Example with enclosed content:
 *
 *     // [baztag]content[/baztag]
 *     function baztag_func( $atts, $content = '' ) {
 *         return "content = $content";
 *     }
 *     add_shortcode( 'baztag', 'baztag_func' );
 *
 * @global array $shortcode_tags
 *
 * @param string   $tag  Shortcode tag to be searched in post content.
 * @param callable $func Hook to run when shortcode is found.
 */
function add_shortcode($tag, $func) {
	global $badcow_shortcode;

	$badcow_shortcode -> addShortcode($tag, $func);
}

/**
 * Removes hook for shortcode.
 *
 * @global array $shortcode_tags
 *
 * @param string $tag Shortcode tag to remove hook for.
 */
function remove_shortcode($tag) {
	global $badcow_shortcode;

	$badcow_shortcode -> removeShortcode($tag);
}

/**
 * Clear all shortcodes.
 *
 * This function is simple, it clears all of the shortcode tags by replacing the
 * shortcodes global by a empty array. This is actually a very efficient method
 * for removing all shortcodes.
 *
 * @global array $shortcode_tags
 */
function remove_all_shortcodes() {
	global $badcow_shortcode;

	$badcow_shortcode = array();
}

/**
 * Whether a registered shortcode exists named $tag
 *
 * @global array $shortcode_tags List of shortcode tags and their callback hooks.
 *
 * @param string $tag Shortcode tag to check.
 * @return bool Whether the given shortcode exists.
 */
function shortcode_exists( $tag ) {
	global $badcow_shortcode;

	return array_key_exists( $tag, $badcow_shortcode );
}

/**
 * Whether the passed content contains the specified shortcode
 *
 * @global array $shortcode_tags
 *
 * @param string $content Content to search for shortcodes.
 * @param string $tag     Shortcode tag to check.
 * @return bool Whether the passed content contains the given shortcode.
 */
function has_shortcode( $content, $tag ) {
	global $badcow_shortcode;

	return $badcow_shortcode -> contentHasShortcode($content, $tag);
}


/**
 * Search content for shortcodes and filter shortcodes through their hooks.
 *
 * If there are no shortcode tags defined, then the content will be returned
 * without any filtering. This might cause issues when plugins are disabled but
 * the shortcode will still show up in the post or content.
 *
 * @global array $shortcode_tags List of shortcode tags and their callback hooks.
 *
 * @param string $content Content to search for shortcodes.
 * @param bool $ignore_html When true, shortcodes inside HTML elements will be skipped.
 * @return string Content with shortcodes filtered out.
 */
function do_shortcode( $content, $ignore_html = false ) {
	global $badcow_shortcode;

	return $badcow_shortcode -> process($content);
}

/**
 * Retrieve the shortcode regular expression for searching.
 *
 * The regular expression combines the shortcode tags in the regular expression
 * in a regex class.
 *
 * The regular expression contains 6 different sub matches to help with parsing.
 *
 * 1 - An extra [ to allow for escaping shortcodes with double [[]]
 * 2 - The shortcode name
 * 3 - The shortcode argument list
 * 4 - The self closing /
 * 5 - The content of a shortcode when it wraps some content.
 * 6 - An extra ] to allow for escaping shortcodes with double [[]]
 *
 * @global array $shortcode_tags
 *
 * @param array $tagnames List of shortcodes to find. Optional. Defaults to all registered shortcodes.
 * @return string The shortcode search regular expression
 */
function get_shortcode_regex( $tagnames = null ) {
	global $badcow_shortcode;

	return $badcow_shortcode -> shortcodeRegex();
}

/**
 * Regular Expression callable for do_shortcode() for calling shortcode hook.
 * @see get_shortcode_regex for details of the match array contents.
 *
 * @access private
 *
 * @global array $shortcode_tags
 *
 * @param array $m Regular expression match array
 * @return string|false False on failure.
 */
function do_shortcode_tag( $m ) {
	global $badcow_shortcode;

	return $badcow_shortcode -> processTag($m);

}

/**
 * Search only inside HTML elements for shortcodes and process them.
 *
 * Any [ or ] characters remaining inside elements will be HTML encoded
 * to prevent interference with shortcodes that are outside the elements.
 * Assumes $content processed by KSES already.  Users with unfiltered_html
 * capability may get unexpected output if angle braces are nested in tags.
 *
 * @param string $content Content to search for shortcodes
 * @param bool $ignore_html When true, all square braces inside elements will be encoded.
 * @param array $tagnames List of shortcodes to find.
 * @return string Content with shortcodes filtered out.
 */
function do_shortcodes_in_html_tags( $content, $ignore_html, $tagnames ) {
	// Normalize entities in unfiltered HTML before adding placeholders.
	$trans = array( '&#91;' => '&#091;', '&#93;' => '&#093;' );
	$content = strtr( $content, $trans );
	$trans = array( '[' => '&#91;', ']' => '&#93;' );

	$pattern = get_shortcode_regex( $tagnames );
	$textarr = wp_html_split( $content );

	foreach ( $textarr as &$element ) {
		if ( '' == $element || '<' !== $element[0] ) {
			continue;
		}

		$noopen = false === strpos( $element, '[' );
		$noclose = false === strpos( $element, ']' );
		if ( $noopen || $noclose ) {
			// This element does not contain shortcodes.
			if ( $noopen xor $noclose ) {
				// Need to encode stray [ or ] chars.
				$element = strtr( $element, $trans );
			}
			continue;
		}

		if ( $ignore_html || '<!--' === substr( $element, 0, 4 ) || '<![CDATA[' === substr( $element, 0, 9 ) ) {
			// Encode all [ and ] chars.
			$element = strtr( $element, $trans );
			continue;
		}

		$attributes = wp_kses_attr_parse( $element );
		if ( false === $attributes ) {
			// Some plugins are doing things like [name] <[email]>.
			if ( 1 === preg_match( '%^<\s*\[\[?[^\[\]]+\]%', $element ) ) {
				$element = preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $element );
			}

			// Looks like we found some crazy unfiltered HTML.  Skipping it for sanity.
			$element = strtr( $element, $trans );
			continue;
		}

		// Get element name
		$front = array_shift( $attributes );
		$back = array_pop( $attributes );
		$matches = array();
		preg_match('%[a-zA-Z0-9]+%', $front, $matches);
		$elname = $matches[0];

		// Look for shortcodes in each attribute separately.
		foreach ( $attributes as &$attr ) {
			$open = strpos( $attr, '[' );
			$close = strpos( $attr, ']' );
			if ( false === $open || false === $close ) {
				continue; // Go to next attribute.  Square braces will be escaped at end of loop.
			}
			$double = strpos( $attr, '"' );
			$single = strpos( $attr, "'" );
			if ( ( false === $single || $open < $single ) && ( false === $double || $open < $double ) ) {
				// $attr like '[shortcode]' or 'name = [shortcode]' implies unfiltered_html.
				// In this specific situation we assume KSES did not run because the input
				// was written by an administrator, so we should avoid changing the output
				// and we do not need to run KSES here.
				$attr = preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $attr );
			} else {
				// $attr like 'name = "[shortcode]"' or "name = '[shortcode]'"
				// We do not know if $content was unfiltered. Assume KSES ran before shortcodes.
				$count = 0;
				$new_attr = preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $attr, -1, $count );
				if ( $count > 0 ) {
					// Sanitize the shortcode output using KSES.
					$new_attr = wp_kses_one_attr( $new_attr, $elname );
					if ( '' !== trim( $new_attr ) ) {
						// The shortcode is safe to use now.
						$attr = $new_attr;
					}
				}
			}
		}
		$element = $front . implode( '', $attributes ) . $back;

		// Now encode any remaining [ or ] chars.
		$element = strtr( $element, $trans );
	}

	$content = implode( '', $textarr );

	return $content;
}

/**
 * Remove placeholders added by do_shortcodes_in_html_tags().
 *
 * @param string $content Content to search for placeholders.
 * @return string Content with placeholders removed.
 */
function unescape_invalid_shortcodes( $content ) {
        // Clean up entire string, avoids re-parsing HTML.
        $trans = array( '&#91;' => '[', '&#93;' => ']' );
        $content = strtr( $content, $trans );

        return $content;
}

/**
 * Retrieve the shortcode attributes regex.
 *
 * @return string The shortcode attribute regular expression
 */
function get_shortcode_atts_regex() {
	return '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
}

/**
 * Retrieve all attributes from the shortcodes tag.
 *
 * The attributes list has the attribute name as the key and the value of the
 * attribute as the value in the key/value pair. This allows for easier
 * retrieval of the attributes, since all attributes have to be known.
 *
 * @param string $text
 * @return array|string List of attribute values.
 *                      Returns empty array if trim( $text ) == '""'.
 *                      Returns empty string if trim( $text ) == ''.
 *                      All other matches are checked for not empty().
 */
function shortcode_parse_atts($text) {
	global $badcow_shortcode;

	return $badcow_shortcode -> parseAttributes($text);
}

/**
 * Combine user attributes with known attributes and fill in defaults when needed.
 *
 * The pairs should be considered to be all of the attributes which are
 * supported by the caller and given as a list. The returned attributes will
 * only contain the attributes in the $pairs list.
 *
 * If the $atts list has unsupported attributes, then they will be ignored and
 * removed from the final returned list.
 *
 * @param array  $pairs     Entire list of supported attributes and their defaults.
 * @param array  $atts      User defined attributes in shortcode tag.
 * @param string $shortcode Optional. The name of the shortcode, provided for context to enable filtering
 * @return array Combined and filtered attribute list.
 */
function shortcode_atts( $pairs, $atts, $shortcode = '' ) {
	$atts = (array)$atts;
	$out = array();
	foreach ($pairs as $name => $default) {
		if ( array_key_exists($name, $atts) )
			$out[$name] = $atts[$name];
		else
			$out[$name] = $default;
	}
	/**
	 * Filter a shortcode's default attributes.
	 *
	 * If the third parameter of the shortcode_atts() function is present then this filter is available.
	 * The third parameter, $shortcode, is the name of the shortcode.
	 *
	 * @param array  $out       The output array of shortcode attributes.
	 * @param array  $pairs     The supported attributes and their defaults.
	 * @param array  $atts      The user defined shortcode attributes.
	 * @param string $shortcode The shortcode name.
	 */
	if ( $shortcode ) {
		$out = apply_filters( "shortcode_atts_{$shortcode}", $out, $pairs, $atts, $shortcode );
	}

	return $out;
}

/**
 * Remove all shortcode tags from the given content.
 *
 * @global array $shortcode_tags
 *
 * @param string $content Content to remove shortcode tags.
 * @return string Content without shortcode tags.
 */
function strip_shortcodes( $content ) {
	global $badcow_shortcode;

	return $badcow_shortcode ->stripAllShortcodes($content);

}

/**
 *
 * @param array $m
 * @return string|false
 */
function strip_shortcode_tag( $m ) {
	global $badcow_shortcode;

	return $badcow_shortcode -> stripShortcodeTag($m);
}

#/**
# * Don't auto-p wrap shortcodes that stand alone
# *
# * Ensures that shortcodes are not wrapped in `<p>...</p>`.
# *
# * wordpress/wp-includes/formatting.php  @since 2.9.0
# *
# * @param string $pee The content.
# * @return string The filtered content.
# */
function shortcode_unautop( $pee ) {
	global $badcow_shortcode;
	$shortcode_tags = (array)$badcow_shortcode;

	if ( empty( $shortcode_tags ) || !is_array( $shortcode_tags ) ) {
		return $pee;
	}

	$tagregexp = join( '|', array_map( 'preg_quote', array_keys( $shortcode_tags ) ) );
//	$spaces = wp_spaces_regexp();
	$spaces = '[\r\n\t ]|\xC2\xA0|&nbsp;';

	$pattern =
		  '/'
		. '<p>'                              // Opening paragraph
		. '(?:' . $spaces . ')*+'            // Optional leading whitespace
		. '('                                // 1: The shortcode
		.     '\\['                          // Opening bracket
		.     "($tagregexp)"                 // 2: Shortcode name
		.     '(?![\\w-])'                   // Not followed by word character or hyphen
		                                     // Unroll the loop: Inside the opening shortcode tag
		.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
		.     '(?:'
		.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
		.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
		.     ')*?'
		.     '(?:'
		.         '\\/\\]'                   // Self closing tag and closing bracket
		.     '|'
		.         '\\]'                      // Closing bracket
		.         '(?:'                      // Unroll the loop: Optionally, anything between the opening and closing shortcode tags
		.             '[^\\[]*+'             // Not an opening bracket
		.             '(?:'
		.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
		.                 '[^\\[]*+'         // Not an opening bracket
		.             ')*+'
		.             '\\[\\/\\2\\]'         // Closing shortcode tag
		.         ')?'
		.     ')'
		. ')'
		. '(?:' . $spaces . ')*+'            // optional trailing whitespace
		. '<\\/p>'                           // closing paragraph
		. '/s';

	return preg_replace( $pattern, '$1', $pee );
}