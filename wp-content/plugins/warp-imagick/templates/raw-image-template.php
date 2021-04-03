<?php
/**
 * Copyright © 2017-2021 Dragan Đurić. All rights reserved.
 *
 * @package warp-imagick
 * @license GNU General Public License Version 2.
 * @copyright © 2017-2021 Dragan Đurić. All rights reserved.
 * @author Dragan Đurić <dragan dot djuritj at gmail dot com>
 * @link https://wordpress.org/plugins/warp-imagick/
 *
 * This copyright notice, source files, licenses and other included
 * materials are protected by U.S. and international copyright laws.
 * You are not allowed to remove or modify this or any other
 * copyright notice contained within this software package.
 */

/**
 * Custom Template for Media Attachment Images
 *
 * @package Warp iMagick
 * @version 1.0
 */
namespace ddur\Warp_iMagick;

use \ddur\Warp_iMagick\Base\Plugin\v1\Lib;
use \ddur\Warp_iMagick\Shared;
use \ddur\Warp_iMagick\Plugin;


/** Get array of media attachment images
 *
 * @param int $id of attachment.
 * @return array|false [$size-name => $file-path]
 */
function get_attachment_image_files( $id ) {

	$img_meta = \wp_get_attachment_metadata( $id );
	if ( ! is_array( $img_meta ) ) {
		return false;
	}
	if ( ! isset( $img_meta ['file'] ) ) {
		return false;
	}
	if ( ! is_string( $img_meta ['file'] ) ) {
		return false;
	}
	if ( ! isset( $img_meta ['sizes'] ) ) {
		return false;
	}
	if ( ! is_array( $img_meta ['sizes'] ) ) {
		return false;
	}

	$my_wp_query = $GLOBALS['wp_the_query'];
	if ( isset( $my_wp_query->query_vars[ Plugin::slug() ] ) ) {
		$query_value = strtolower( $my_wp_query->query_vars[ Plugin::slug() ] );
		$query_value = '' !== trim( $query_value ) ? $query_value : 'all';
	} else {
		$query_value = 'all';
	}

	$main_img_path = \trailingslashit( \wp_upload_dir() ['basedir'] ) . $img_meta ['file'];
	$base_dir_path = \trailingslashit( dirname( $main_img_path ) );

	$distinct_files = array();

	$sizes = $img_meta ['sizes'];

	uksort(
		$sizes, function( $a, $b ) use ( $sizes ) {

			$width_a = (int) $sizes [ $a ] ['width'];
			$width_b = (int) $sizes [ $b ] ['width'];
			if ( $width_a === $width_b ) {
				return 0;
			} elseif ( $width_a > $width_b ) {
				return 1;
			} else {
				return -1;
			}
		}
	);

	$width  = 0;
	$height = 0;

	if ( in_array( $query_value, array( 'raw', 'all', 'webp' ), true ) ) {
		foreach ( $sizes as $size_name => $img_meta_data ) {
			$distinct_file = $base_dir_path . $img_meta_data ['file'];
			if ( ! file_exists( $distinct_file ) ) {
				continue;
			}
			$geometry = \getimagesize( $distinct_file );
			if ( is_array( $geometry ) ) {
				$width  = (int) $geometry [0];
				$height = (int) $geometry [1];
			}
			$bytes     = (int) \filesize( $distinct_file );
			$size_name = str_replace( array( '_', '-' ), ' ', $size_name );
			if ( in_array( $query_value, array( 'raw', 'all' ), true ) ) {
				$distinct_files [ $distinct_file ] = array( $size_name, $width, $height, $bytes );
			}
			if ( in_array( $query_value, array( 'all', 'webp' ), true ) ) {
				$distinct_file = Shared::get_webp_file_name( $distinct_file );
				if ( ! file_exists( $distinct_file ) ) {
					continue;
				}
				$geometry = \getimagesize( $distinct_file );

				if ( is_array( $geometry ) ) {
					$width  = (int) $geometry [0];
					$height = (int) $geometry [1];
				}
				$bytes = (int) \filesize( $distinct_file );

				$distinct_files [ $distinct_file ] = array( $size_name . ' (webp)', $width, $height, $bytes );
			}
		}
	}

	$width  = 0;
	$height = 0;

	if ( in_array( $query_value, array( 'full', 'all' ), true ) ) {
		$distinct_file = $main_img_path;
		if ( file_exists( $distinct_file ) ) {
			$geometry = \getimagesize( $distinct_file );
			if ( is_array( $geometry ) ) {
				$width  = (int) $geometry [0];
				$height = (int) $geometry [1];
			}
			$bytes = (int) \filesize( $distinct_file );

			$distinct_files[ $distinct_file ] = array( 'full size', $width, $height, $bytes );
			if ( in_array( $query_value, array( 'full', 'all', 'webp' ), true ) ) {
				$distinct_file = Shared::get_webp_file_name( $distinct_file );
				if ( file_exists( $distinct_file ) ) {
					$geometry = \getimagesize( $distinct_file );

					if ( is_array( $geometry ) ) {
						$width  = (int) $geometry [0];
						$height = (int) $geometry [1];
					}
					$bytes = (int) \filesize( $distinct_file );

					$distinct_files [ $distinct_file ] = array( 'full size (webp)', $width, $height, $bytes );
				}
			}
		}
	}

	$width  = 0;
	$height = 0;

	if ( \function_exists( '\\wp_get_original_image_path' ) && ! empty( $img_meta ['original_image'] ) ) {
		if ( in_array( $query_value, array( 'full', 'all' ), true ) ) {
			$distinct_file = \wp_get_original_image_path( $id );
			if ( file_exists( $distinct_file ) ) {
				$geometry = \getimagesize( $distinct_file );
				if ( is_array( $geometry ) ) {
					$width  = (int) $geometry [0];
					$height = (int) $geometry [1];
				}
				$bytes = (int) \filesize( $distinct_file );

				$distinct_files[ $distinct_file ] = array( 'original upload', $width, $height, $bytes );
				if ( in_array( $query_value, array( 'full', 'all', 'webp' ), true ) ) {
					$distinct_file = Shared::get_webp_file_name( $distinct_file );
					if ( file_exists( $distinct_file ) ) {
						$geometry = \getimagesize( $distinct_file );

						if ( is_array( $geometry ) ) {
							$width  = (int) $geometry [0];
							$height = (int) $geometry [1];
						}
						$bytes = (int) \filesize( $distinct_file );

						$distinct_files [ $distinct_file ] = array( 'original upload (webp)', $width, $height, $bytes );
					}
				}
			}
		}
	}

	$files = array();
	foreach ( $distinct_files as $file_path => $size_data ) {

		$new_array_key = $size_data[0];
		$size_data[0]  = $file_path;

		$files [ $new_array_key ] = $size_data;
	}

	return $files;
}

/** Return <img> elements */
function get_img_html_elements() {

	if ( ! is_callable( '\\getimagesize' ) ) {
		Lib::error( 'Function is not callable: \getimagesize' );
		return '';
	}

	$my_wp_query = $GLOBALS['wp_the_query'];
	$img_files   = get_attachment_image_files( $my_wp_query->post->ID );

	if ( ! is_array( $img_files ) || count( $img_files ) === 0 ) {
		return '';
	}

	$html      = '';
	$break     = 0;
	$root_path = wp_normalize_path( untrailingslashit( ABSPATH ) );
	foreach ( $img_files as $size_name => $size_data ) {

		$file_path = \wp_normalize_path( $size_data[0] );
		$byte_size = $size_data[3];
		$file_size = \size_format( $byte_size );

		if ( Lib::starts_with( $file_path, $root_path ) ) {
			if ( $break ) {
				if ( $break !== $size_data [1] ) {
					$break = $size_data [1];
					$html .= '<br>' . PHP_EOL;
				}
			} else {
				$break = $size_data [1];
			}
			$file_size = esc_attr( $file_size );
			$size_name = esc_attr( $size_name );
			$src       = esc_url_raw( substr( $file_path, strlen( $root_path ) ) );
			$width     = esc_attr( $size_data [1] );
			$height    = esc_attr( $size_data [2] );
			$basename  = basename( $file_path );
			$byte_size = esc_attr( $byte_size );
			$title     = esc_attr( "WP Size Name: $size_name\nWidth&Height: ${width}x${height}px\nFile Basename: $basename\nFile Byte-size: $file_size ($byte_size bytes)" );
			$html     .= "<img data-file-size='$byte_size' data-size-name='$size_name' src='$src' width='$width' height='$height' title='$title'>" . PHP_EOL;
		}
	}

	return $html;
}
?><!doctype html><head><title>Thumbnails</title></head><html><body>
<?php Lib::echo_html( get_img_html_elements() ); ?></body></html>
