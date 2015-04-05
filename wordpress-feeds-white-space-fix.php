<?php
/**
 * Script used to fix white space error in Wordpress feeds XML
 * 
 * =============================================================================================
 * 
 * Setup
 * 
 * 1. Add this file on wordpress root 
 * 2. Include this file in index.php present on wordpress root
 * 
 * index.php
 * <?php
 * 
 * include_once('wordpress-feeds-white-space-fix.php');
 * 
 * define('WP_USE_THEMES', true);
 * require( dirname( __FILE__ ) . '/wp-blog-header.php' );
 * 
 * =============================================================================================
 * 
 * @author Arjun Jain <arjun@arjunjain.info>
 * @version 1.0
 * @license GPL v3 <https://www.gnu.org/licenses/gpl-3.0.txt>
 */

function wordpress_feeds_xml_white_space_fix_($input) {
	/* valid content-type? */
	$allowed = false;

	/* found content-type header? */
	$found = false;

	/* we mangle the output if (and only if) output type is text/* */
	foreach (headers_list() as $header) {
		if (preg_match("/^content-type:\\s+(text\\/|application\\/((xhtml|atom|rss)\\+xml|xml))/i", $header)) {
			$allowed = true;
		}

		if (preg_match("/^content-type:\\s+/i", $header)) {
			$found = true;
		}
	}

	/* do the actual work */
	if ($allowed || !$found) {
		return preg_replace("/\\A\\s*/m", "", $input);
	} else {
		return $input;
	}
}

/* start output buffering using custom callback */
ob_start("wordpress_feeds_xml_white_space_fix_");
