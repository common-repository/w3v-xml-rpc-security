<?php
/*
Plugin Name:  w3v-xml-rpc-security
Plugin URI:   https://wordpress-demo.w3villa.com/
Description:  Securing site by disable XML-RPC by removing some methods and make more secure your wordpress site.
Version:      1.0
Requires at least: 5.0
Requires PHP:      5.6
Author:       W3villa
Author URI:   https://w3villa.com/
License: GPLv3
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  xml_rpc
*/

/*
  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License version 2 as published by
  the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <https://www.gnu.org/licenses/gpl.html>.
 */

add_filter('xml_rpc_enabled', '__return_false');

add_filter('xml_rpc_methods', 'w3v_block_xml_rpc_attacks');

/**
 * Unset XML-RPC Methods.
 *
 * @param array $methods Array of current XML-RPC methods.
 */
function w3v_block_xml_rpc_attacks($methods)
{
	unset($methods['pingback.ping']);
	unset($methods['pingback.extensions.getPingbacks']);
	return $methods;
}

/**
 * Check WP version and vaildate.
 */
if (version_compare($wp_version, '5.0') >= 0) {

	add_action('wp', 'w3v_remove_x_pingback_header_44', 9999);

	/**
	 * Remove X-Pingback from Header for WP 4.4+.
	 */
	function w3v_remove_x_pingback_header_44()
	{
		header_remove('X-Pingback');
	}
} else {

	add_filter('wp_headers', 'w3v_remove_x_pingback_header');

	/**
	 * Remove X-Pingback from Header for older WP versions.
	 *
	 * @param array $headers Array with current headers.
	 */
	function w3v_remove_x_pingback_header($headers)
	{
		unset($headers['X-Pingback']);
		return $headers;
	}
}
