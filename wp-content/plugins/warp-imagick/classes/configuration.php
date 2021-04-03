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

namespace ddur\Warp_iMagick;

use \ddur\Warp_iMagick\Shared;
use \ddur\Warp_iMagick\Plugin;

defined( 'ABSPATH' ) || die( -1 );

return array(

	'plugin'          => array(

		'requires' => array(

			'wp'         => '5.3',
			'php'        => '5.6',

			'extensions' => array(
				'imagick' => 'PHP Imagick',
			),

			'classes'    => array(
				'\\Imagick' => 'PHP Imagick extension',
			),

			'functions'  => array(
				'\\getimagesize'               => 'Required PHP function',
				'\\wp_get_original_image_path' => 'WordPress 5.3+ required',
			),

			'constants'  => array(
				'\\Imagick::COMPRESSION_JPEG' => 'PHP Imagick extension',
				'\\Imagick::COLORSPACE_SRGB'  => 'PHP Imagick extension',
				'\\Imagick::INTERLACE_PLANE'  => 'PHP Imagick extension',
				'\\Imagick::INTERLACE_JPEG'   => 'PHP Imagick extension',
			),
		),

		'metabox'  => array(
			'link' => 'https://wordpress.org/plugins/' . Plugin::slug() . '/',
			'name' => 'WordPress.org Plugin Page',
		),




	),
	'menu'            => array(
		'title'         => 'Warp iMagick',
		'menu-icon'     => 'dashicons-hammer',
		'parent-slug'   => 'upload.php',
		'position'      => 99,


		'settings-name' => __( 'Settings', 'warp-imagick' ),
		'settings-icon' => '☢',
	),
	'page'            => array(
		'title'     => 'Warp iMagick - Image Compressor',
		'subtitle'  => __( 'Compress JPEG, PNG and generate WebP images.', 'warp-imagick' ),
		'help-tabs' => array(
			array(
				'id'      => 'overview',
				'title'   => __( 'Overview', 'warp-imagick' ),
				'content' => '
<p><b>Compress JPEG PNG and generate WebP images.</b></p>
<p>Reduce file size of WP generated JPEG and PNG thumbnails and sizes. Generate optimized WebP version of JPEG and PNG images.</p>
<p>When optimization or other setting are changed, use <a target=_blank rel="noopener noreferrer" href=https://wordpress.org/plugins/regenerate-thumbnails>"Regenerate Thumbnails" plugin</a> to regenerate or batch-regenerate images with new settings.</p>
',
			),
			array(
				'id'      => 'jpeg-reduction',
				'title'   => __( 'JPEG Reduction', 'warp-imagick' ),
				'content' => '
<p><b>Reduce file size of JPEG images.</b></p>
<p>Plugin default values are marked with \'*\'.</p>
<p>WordPress default JPEG compression quality is 82%.</p>
',
			),
			array(
				'id'      => 'png-reduction',
				'title'   => __( 'PNG Reduction', 'warp-imagick' ),
				'content' => '
<p><b>Reduce file size of PNG images.</b></p>
<p>Lossy compress by reducing number of colors.</p>
<p>Enable <a target=_blank rel="noopener noreferrer" href=https://en.wikipedia.org/wiki/Dither >Dither</a> to improve transition between colors. Disabled for transparent+palette images.</p>
<p>Configure maximum number of colors in the image. Images with number of colors less than maximum will not be quantized again.</p>
<p>Lossless compression is set to maximum (9). Every PNG image is tested with two default filter/strategy settings (WordPress/Imagick) and smaller file size is saved.</p>
',
			),
			array(
				'id'      => 'webp-images',
				'title'   => __( 'WebP Images', 'warp-imagick' ),
				'content' => '
<p><b>Serving <a target=_blank rel="noopener noreferrer" href=https://developers.google.com/speed/webp>WebP</a> Images.</b></p>
<p>Enable to generate optimized <a target=_blank rel="noopener noreferrer" href=https://en.wikipedia.org/wiki/Webp>WebP</a> versions for all media-attached JPEG/PNG images.</p>
<p>Transparent PNG images are exception. Current PHP software cannot generate transparent WebP images.
<p>This settings may be disabled if your server\'s PHP software is not capable to generate WebP images.
<p>When enabled, each image thumbnail/size (including upload) will have optimized WebP version. Named with ".webp" extension appended at the end of original image file name. In example: "image-768x300.jpg.webp" will be found along with "image-768x300.jpg".</p>
<p>To serve WebP images, configure server to transparently serve WebP images to browsers supporting "image/webp" mime-type.</p>
<p>Configuring server to serve WebP images is not done by this plugin because change could potentially break your site. You will have to DIY (Do It Yourself).
<p>Below is Apache .htaccess configuration snippet that should work on most Apache servers. Snippet is tested on Apache 2.4 install on Debian 9 (stretch).</p>
<p><b>Backup/Save your original .htaccess file before applying changes!</b> Copy snippet and add it at the top of .htaccess file in site root.</p>
<p style="background:#eaeaea;padding:5px"><code style="white-space:pre;color:DarkRed;background:none;padding:0"># BEGIN Warp-iMagick - First line of .htaccess file.
# Transparently serve WebP images instead of JPEG/PNG to WebP enabled browsers.
&lt;IfModule mod_mime.c&gt;
	AddType image/webp .webp
&lt;/IfModule&gt;
&lt;ifModule mod_rewrite.c&gt;
	RewriteEngine On
	RewriteBase /
	RewriteCond %{HTTP_ACCEPT} image/webp
	RewriteCond %{REQUEST_URI} (?i)(.*)\.(jpe?g|png)$
	RewriteCond %{DOCUMENT_ROOT}%1\.%2.webp -f
	RewriteRule (?i)(.*)\.(jpe?g|png)$ %1\.%2\.webp [T=image/webp,E=webp:1,L]
	&lt;IfModule mod_headers.c&gt;
		Header append Vary Accept env=REDIRECT_webp
	&lt;/IfModule&gt;
&lt;/IfModule&gt;
# END Warp-iMagick


</code></p>
<p>Line "<code>AddType image/webp .webp</code>" will enable Apache to respond with Content-Type: "image/webp" for requested WebP images, regardless of rewrite rules below. Only if mod_mime is enabled and image/webp not already recognized by.</p>
<p>Line "<code>RewriteCond %{HTTP_ACCEPT} image/webp</code>" detects whether browser can accept WebP images or not.</p>
<p>Line "<code>RewriteCond %{REQUEST_URI} (?i)(.*)\.(jpe?g|png)$</code>" matches when WebP enabled browser has requested for JPEG/PNG image.</p>
<p>Line "<code>RewriteCond %{DOCUMENT_ROOT}%1\.%2.webp -f</code>" tests if WebP version of JPEG/PNG image exists on the server file system.</p>
<p>Line "<code>RewriteRule (?i)(.*)\.(jpe?g|png)$ %1\.%2\.webp [T=image/webp,E=webp:1,L]</code>" will make Apache to respond with WebP image content, set environment variable and stop looking for other rewrite rules. Mime type "image/webp" is set regardless if mod_mime is enabled or not.</p>
<p>Line "<code>Header append Vary Accept env=REDIRECT_webp</code>" will inform your browser and/or CDN that content of JPEG/PNG image response can Vary: based on browser header Accept: content. Only if mod_headers is enabled. Your CDN may or may not cache response with Vary: Accept header.</p>
<p></p>
<p>To check if WebP rewrite rules are working after .htaccess modifications:
<ol>
<li>Use most recent Chrome browser.</li>
<li>In plugin settings enable WebP images.</li>
<li>Upload JPEG/PNG image while WebP images still enabled :).</li>
<li>Attach media to some page and open that page, or view/open attachment page if your site/theme supports it.</li>
<li>Open Chrome Development Tools [Ctrl+Shift+I].</li>
<li>Select Network Tab.</li>
<li>Press [F5] or [Ctrl-R] to reload page.</li>
<li>Find image request and click on it to expand Request/Response headers.</li>
<li>Check Response headers for image. "Content-Type:" should be "image/webp", and "Content-Length:" should be smaller than original JPEG/PNG image size.</li>
</ol>
</p>
<p>Instructions "How to configure server to serve WebP images" for other http-servers, is not difficult to find on internet.</p>
<p>Good <b>Nginx</b> instructions: <a target=_blank rel="noopener noreferrer" href=https://github.com/uhop/grunt-tight-sprite/wiki/Recipe:-serve-WebP-with-nginx-conditionally>Recipe: serve WebP with nginx conditionally</a>.</p>
',
			),
			array(
				'id'      => 'max-width',
				'title'   => __( 'Maximum Width', 'warp-imagick' ),
				'content' =>
				'
<p>Enable to limit maximum width of upload/original image.</p>
<p>When enabled, JPEG/PNG images will be reduced/downsized on upload or on (batch) regenerate thumbnails.</p>
<p>Recommended maximum width value is 2048 px or at least as wide as widest registered image size.</p>
<p>Reducing is proportional, reduced image will have same aspect ratio as original.</p>
<p><b>Reducing is irreversible, still, you can disable limit and upload full size image again.</b></p>
',
			),
			array(
				'id'      => 'plugin',
				'title'   => __( 'Plugin Options', 'warp-imagick' ),
				'content' =>
				'
<p>Set checkbox "on" to <b>remove</b> plugin settings when plugin is deleted.</p>
<p>Set checkbox "off" to <b>keep</b> plugin settings after plugin is deleted.</p>
<p><b>Defaults to "on" when plugin activated and no previous settings stored.</b></p>
',
			),
		),
	),

	'capability'      => 'manage_options',

	'fields-extended' => array(
		'plugin-link'       => '',
		'plugin-link-title' => 'Warp WordSpeed Club',
	),

	'sections'        => array(

		'jpeg-thumb-options'                          => array(
			'title'  => __( 'JPEG Settings', 'warp-imagick' ),
			'fields' => array(

				'jpeg-compression-quality' => array(
					'label'   => __( 'Compression Quality', 'warp-imagick' ) . ' (' . Shared::jpeg_quality_default() . '%*)',
					'type'    => 'range',
					'style'   => 'width:200px',
					'title'   => __( 'Compression Quality in percentage. WordPress Default is 82%.', 'warp-imagick' ),
					'default' => Shared::jpeg_quality_default(),
					'options' => array(
						'min'   => Shared::jpeg_quality_value_min(),
						'max'   => Shared::jpeg_quality_value_max(),
						'units' => __( '%', 'warp-imagick' ),
					),
				),

				'jpeg-sharpen-image'       => array(
					'label'   => __( 'Sharpen JPEG Full Size Image', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'default' => Shared::jpeg_sharpen_image_default(),
					'title'   => __( 'Sharpen Image over WP Default sharpening. Select WP Default (unsharpMaskImage) or WP Default + SharpenImage( 0, $sigma ). Sharper image will produce larger file size. Small sigma or none recommended for full size. Default value is "WP Default" (no extra sharpening).', 'warp-imagick' ),
					'options' => array(
						'source'   => 'callback',
						'callback' => 'get_form_sharpen_image',
					),
				),

				'jpeg-sharpen-thumbnails'  => array(
					'label'   => __( 'Sharpen JPEG Thumbnails', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'default' => Shared::jpeg_sharpen_thumbnails_default(),
					'title'   => __( 'Sharpen Thumbnails over WP Default sharpening. Select WP Default (unsharpMaskImage) or WP Default + SharpenImage( 0, $sigma ). Sharper image will produce larger file size. Test to find your optimal $sigma or disable. Default value is "WP Default" (no extra sharpening).', 'warp-imagick' ),
					'options' => array(
						'source'   => 'callback',
						'callback' => 'get_form_sharpen_thumbnails',
					),
				),

				'jpeg-compression-type'    => array(
					'label'   => __( 'Compression Type', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'title'   => __( 'Use WordPress default or Imagick default compression type. Default value is "Imagick".', 'warp-imagick' ),
					'default' => Shared::jpeg_compression_type_default(),
					'options' => array(
						'disabled' => ( defined( '\\Imagick::COMPRESSION_JPEG' ) ? false : true ),
						'source'   => 'callback',
						'callback' => 'get_form_jpeg_compression_types',
					),
				),

				'jpeg-colorspace'          => array(
					'label'   => __( 'Convert Colors to "sRGB" Colorspace', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'title'   => __( 'Convert image colors from other colorspaces to sRGB Colorspace or leave original image colorspace. Google recommends converting to sRGB colorspace. Colorspace sRGB allows removing all metadata, including important metadata like ICC profile.', 'warp-imagick' ),
					'default' => Shared::jpeg_colorspace_default(),
					'options' => array(
						'disabled' => ( defined( '\\Imagick::COLORSPACE_SRGB' ) ? false : true ),
						'source'   => 'callback',
						'callback' => 'get_form_jpeg_colorspaces',
					),
				),

				'jpeg-colorspace-force'    => array(
					'label'   => __( 'Test Option: Convert from Undefined Colorspace', 'warp-imagick' ),
					'type'    => 'checkbox',
					'style'   => 'width:200px',
					'title'   => __( 'When colorspace conversion enabled, allow convert from undefined colorspace. Default is OFF (not allowed).', 'warp-imagick' ),
					'default' => false,
					'options' => array(
						'disabled' => ( defined( '\\Imagick::COLORSPACE_UNDEFINED' ) ? false : true ),
					),
				),

				'jpeg-sampling-factor'     => array(
					'label'   => __( 'Color Sampling factor', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'title'   => __( 'Reduce image file size by selecting color sampling factor (lossy color compression). Choose from smallest file size to best color resolution. Default value is "4:2:0" as recommended by Google.', 'warp-imagick' ),
					'default' => Shared::jpeg_sampling_factor_default(),
					'options' => array(
						'source'   => 'callback',
						'callback' => 'get_form_jpeg_sampling_factors',
					),
				),

				'jpeg-strip-meta'          => array(
					'label'   => __( 'Strip meta data', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'default' => Shared::jpeg_strip_meta_default(),
					'title'   => __( 'WordPress by default strips most of metadata except protected profiles. "Strip All" applies only if image colorspace is sRGB, else "Preserve Important" is used. Default value is "Strip All".', 'warp-imagick' ),
					'options' => array(
						'source'   => 'callback',
						'callback' => 'get_form_strip_metadata',
					),
				),

				'jpeg-interlace-scheme'    => array(
					'label'   => __( 'Interlace scheme', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'default' => Shared::jpeg_interlace_scheme_default(),
					'title'   => __( 'Interlace scheme WP/ON/OFF or AUTO to try both and select smaller file size. Default value is "AUTO".', 'warp-imagick' ),
					'options' => array(
						'source'   => 'callback',
						'callback' => 'get_form_jpeg_interlace_types',
					),
				),
			),
		),

		'png-image-options'                           => array(
			'title'  => __( 'PNG Settings', 'warp-imagick' ),
			'render' => 'render_png_thumb_options',
			'fields' => array(



				'png-reduce-colors-enable'    => array(
					'label'   => __( 'Reduce Colors', 'warp-imagick' ),
					'type'    => 'checkbox',
					'default' => Shared::png_reduce_colors_enabled_default(),
					'title'   => __( 'Lossy Compression. When enabled, colors will be reduced to maximum number of colors (see below). Default value is on (true)', 'warp-imagick' ),
					'options' => array(
						'disabled' => ( defined( '\\Imagick::IMGTYPE_PALETTE' ) ? false : true ),
					),
				),

				'png-reduce-colors-dither'    => array(
					'label'   => __( 'Dither Colors', 'warp-imagick' ),
					'type'    => 'checkbox',
					'default' => Shared::png_reduce_colors_dither_default(),
					'title'   => __( 'Color Compensation. When enabled, dither to improve color transients (see https://en.wikipedia.org/wiki/Dither). File size will increase when enabled. Disabled on transparent images when max colors is 256 or less. Default value is off (false).', 'warp-imagick' ),
				),

				'png-reduce-max-colors-count' => array(
					'label'   => __( 'Maximum Colors', 'warp-imagick' ) . ' (' . Shared::png_max_colors_value_default() . '*)',
					'type'    => 'range',
					'style'   => 'width:200px',
					'default' => Shared::png_max_colors_value_default(),
					'title'   => __( 'Lossy Compression. If image has more colors than Maximum Colors, number of colors will be reduced down. If number of colors is less than or equal to 256, image colors will be converted to palette. File size and color quality will increase with more colors', 'warp-imagick' ),
					'options' => array(
						'min'   => Shared::png_max_colors_value_min(),
						'max'   => Shared::png_max_colors_value_max(),
						'step'  => Shared::png_max_colors_value_min(),
						'units' => __( 'colors', 'warp-imagick' ),
					),
				),

				'png-strip-meta'              => array(
					'label'   => __( 'Strip meta data', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'default' => Shared::png_strip_meta_default(),
					'title'   => __( 'WordPress by default strips most of metadata except protected profiles. Default value is "Strip All".', 'warp-imagick' ),
					'options' => array(
						'source'   => 'callback',
						'callback' => 'get_form_strip_metadata',
					),
				),
			),
		),

		'webp-image-options'                          => array(
			'title'  => __( 'WebP Settings', 'warp-imagick' ),
			'render' => 'render_webp_thumb_options',
			'fields' => array(
				'webp-images-create'            => array(
					'label'   => __( 'Generate WebP Images', 'warp-imagick' ),
					'type'    => 'checkbox',
					'default' => Shared::webp_images_create_default(),
					'title'   => __( 'If enabled, for every media image/thumbnail, WebP image will be added on media upload or when thumbnails are regenerated. See Help Tab at the right-top of the page, section "WebP Images" for "how to serve instructions".', 'warp-imagick' ),
					'options' => array(
						'disabled' => ! Plugin::instance()->can_generate_webp_clones(),
					),
				),
				'webp-compression-quality'      => array(
					'label'   => __( 'WebP Compression Quality', 'warp-imagick' ) . ' (' . Shared::webp_quality_default() . '*)',
					'type'    => 'range',
					'style'   => 'width:200px',
					'default' => Shared::webp_quality_default(),
					// Translators: %s is default compression quality value.
					'title'   => sprintf( __( 'Lossy Compression. WebP compression quality. Default value is %s. Default cwebp value is 75. Max value to pass Google Page Speed Test is 75+10%% (about 82). Applies to converted PNG images. For converted JPEG images may or may not apply, see WebP/JPEG quality below).', 'warp-imagick' ), Shared::webp_quality_default() ),
					'options' => array(
						'min'   => Shared::webp_quality_value_min(),
						'max'   => Shared::webp_quality_value_max(),
						'step'  => 1,
						'units' => __( '%', 'warp-imagick' ),
					),
				),
				'webp-jpeg-compression-quality' => array(
					'label'   => __( 'WebP Compression Quality for JPEG images.', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					// Translators: %s is default compression quality value.
					'title'   => sprintf( __( 'WebP compression quality when converting from JPEG images. Use JPEG compression quality or WebP compression quality above. Not using JPEG settings may result in larger WebP image file sizes than matching JPEG source image file size. Default is to use JPEG compression quality, up to (%s).', 'warp-imagick' ), Shared::webp_quality_value_max() ),
					'default' => Shared::webp_jpeg_quality_default(),
					'options' => array(
						'source'   => 'callback',
						'callback' => 'get_form_jpeg_to_webp_compression_quality',
					),
				),

			),
		),

		'disable-wp-big-image-size-threshold-section' => array(
			'title'  => __( 'Disable BIG JPEG Image Size & Scaling Threshold', 'warp-imagick' ),
			'fields' => array(
				'wp-big-image-size-threshold-disabled' => array(
					'label'   => __( 'Disable "BIG Image Size Threshold" filter introduced in WordPress 5.3.', 'warp-imagick' ),
					'type'    => 'checkbox',
					'default' => Shared::big_image_size_threshold_disabled_default(),
					'title'   => __( 'Disabled by default. When checked (on), prevents BIG JPEG image to be downsized and reduced to thumbnail quality. WordPress (version 5.3+) "Big Image Size Threshold" filter (defaults to 2560x2560 pixels), will be disabled!".', 'warp-imagick' ),
					'options' => array(),
				),
			),
		),





		'plugin-options'                              => array(
			'title'  => __( 'Plugin Settings', 'warp-imagick' ),
			'fields' => array(

				'remove-settings'  => array(
					'label'   => __( 'Remove settings on uninstall', 'warp-imagick' ),
					'type'    => 'checkbox',
					'style'   => 'width:200px',
					'default' => Shared::remove_plugin_settings_default(),
					'title'   => __( 'Remove plugin settings along with plugin uninstall and delete', 'warp-imagick' ),
				),

				'menu-parent-slug' => array(
					'label'   => __( 'Select parent menu', 'warp-imagick' ),
					'type'    => 'select',
					'style'   => 'width:200px',
					'default' => Shared::menu_parent_slug_default(),
					'title'   => __( 'Select parent menu', 'warp-imagick' ),
					'options' => array(
						'source' => 'values',
						'values' => array(
							''                    => 'Default',
							0                     => 'Top',
							'index.php'           => 'Dashboard',
							'upload.php'          => 'Media',
							'tools.php'           => 'Tools',
							'options-general.php' => 'Settings',
							99                    => 'Bottom',
						),
					),
				),
			),
		),

		'defined-sizes'                               => array(
			'title'  => __( 'Sizes Found', 'warp-imagick' ),
			'render' => 'render_section_image_extra_sizes',
			'submit' => false,
			'fields' => array(),
		),


		'terms-of-use'                                => array(
			'title'  => __( 'Copyright, License, Privacy and Disclaimer', 'warp-imagick' ),
			'render' => 'render_section_terms',
			'submit' => false,
			'fields' => array(),
		),
	),

	'tabs'            => array(
		'main-options' => array(
			'title'    => 'Compress Settings',
			'sections' => 3,
		),
		'conf-options' => array(
			'title'    => 'General Settings',
			'sections' => 2,
		),
		'site-conf'    => array(
			'title'    => 'Site Configuration',
			'sections' => 1,
			'submit'   => false,
		),
		'terms-of-use' => array(
			'title'    => 'Terms of Use',
			'sections' => 1,
			'submit'   => false,
		),
	),
);
