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

defined( 'ABSPATH' ) || die( -1 );

use \ddur\Warp_iMagick\Base\Plugin\v1\Lib;
use \ddur\Warp_iMagick\Base\Meta_Settings;
use \ddur\Warp_iMagick\Settings_Renderer;
use \ddur\Warp_iMagick\Shared;

if ( ! class_exists( __NAMESPACE__ . '\Settings' ) ) {

	/** Final implementation of Plugin Settings. */
	final class Settings extends Meta_Settings {

		// phpcs:ignore
	# region Configuration and Construction

		/** Get Plugin Settings/Configuration, abstract method, must implement.
		 *
		 * @return array Plugin Configuration Settings compliant array.
		 */
		public function read_configuration() {
			return require __DIR__ . '/configuration.php';
		}


		/** Settings init. Called immediately after plugin class is constructed. */
		protected function init() {
			parent::init();

			/** Instantiate custom Settings_Renderer. */
			$this->renderer = new Settings_Renderer( $this );

		}

		/** Enqueue admin page scripts. Overridden. */
		public function enqueue_page_scripts() {

			Lib::enqueue_style( 'abstract-settings-admin-styled' );
			Lib::enqueue_script( 'abstract-settings-admin-styled' );

			$dependencies   = array( 'abstract-settings-admin-styled' );
			$plugin_version = $this->get_option( 'plugin-version', false );
			$relative_path  = Lib::relative_path( $this->plugin->get_path() );

			Lib::enqueue_style( $this->pageslug, $relative_path . '/assets/style.css', array(), $style_version = $plugin_version, 'screen' );

			Lib::enqueue_script( $this->pageslug, $relative_path . '/assets/script.js', $dependencies, $script_version = $plugin_version, $in_footer = true );
		}

		// phpcs:ignore
	# endregion

		// phpcs:ignore
	# region Form Display and Validation

		/** Get form/display field value. Overridden.
		 *
		 * From Options API to Settings UI (page&form).
		 * Validate (&transform) options.
		 *
		 * @param string $name of the field.
		 * @param mixed  $value of the field.
		 * @return mixed $value for display.
		 */
		protected function get_form_field_value( $name, $value ) {
			return $value;
		}

		/** Validate form submitted checkbox by key (field name).
		 *
		 * @param string $key - name of the checkbox field.
		 * @param array  $values - all submitted values.
		 */
		public static function validate_checkbox_key( $key, &$values ) {
			if ( ! array_key_exists( $key, $values ) ) {
				$values [ $key ] = false;
			} else {
				$values [ $key ] = self::validate_checkbox_value( $values [ $key ] );
			}
		}

		/** Validate form checkbox value.
		 *
		 * @param mixed $value of submitted checkbox field.
		 * @return bool $value validated to bool.
		 */
		public static function validate_checkbox_value( $value ) {
			switch ( $value ) {
				case true:
				case 'on':
					$value = true;
					break;
				default:
					if ( ! is_bool( $value ) ) {
						$value = false;
					}
			}
			return $value;
		}

		/** Validate (&transform) input values. Overridden.
		 *
		 * From Settings UI (form&submit) to Options API.
		 *
		 * @param array $values to validate.
		 * @return array $values validated.
		 */
		public function validate_options( $values ) {

			if ( ! is_array( $values ) ) {
				$values = array();
				$this->add_settings_update_error( "Invalid input type ({$get_type ($values)})" );
			}

			self::validate_checkbox_key( 'jpeg-colorspace-force', $values );

			self::validate_checkbox_key( 'png-reduce-colors-enable', $values );

			self::validate_checkbox_key( 'png-reduce-colors-dither', $values );

			self::validate_checkbox_key( 'webp-images-create', $values );

			self::validate_checkbox_key( 'wp-big-image-size-threshold-disabled', $values );

			self::validate_checkbox_key( 'image-max-width-enabled', $values );

			self::validate_checkbox_key( 'image-max-width-backup', $values );

			self::validate_checkbox_key( 'extra-size-same-width', $values );

			self::validate_checkbox_key( 'remove-settings', $values );

			if ( ! array_key_exists( 'image-max-width-pixels', $values ) ) {
				$values ['image-max-width-pixels'] = Shared::max_width_value_default();
			} else {
				$values ['image-max-width-pixels'] = (int) $values ['image-max-width-pixels'];
				if ( $values ['image-max-width-pixels'] < Shared::max_width_value_min() || $values ['image-max-width-pixels'] > Shared::max_width_value_max() ) {
					$values ['image-max-width-pixels'] = Shared::max_width_value_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-sharpen-image', $values ) ) {
				$values ['jpeg-sharpen-image'] = Shared::jpeg_sharpen_image_default();
			} else {
				$values ['jpeg-sharpen-image'] = (int) $values ['jpeg-sharpen-image'];
				if ( ! array_key_exists( $values ['jpeg-sharpen-image'], $this->get_form_sharpen_image() ) ) {
					$values ['jpeg-sharpen-image'] = Shared::jpeg_sharpen_image_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-sharpen-thumbnails', $values ) ) {
				$values ['jpeg-sharpen-thumbnails'] = Shared::jpeg_sharpen_thumbnails_default();
			} else {
				$values ['jpeg-sharpen-thumbnails'] = (int) $values ['jpeg-sharpen-thumbnails'];
				if ( ! array_key_exists( $values ['jpeg-sharpen-thumbnails'], $this->get_form_sharpen_thumbnails() ) ) {
					$values ['jpeg-sharpen-thumbnails'] = Shared::jpeg_sharpen_thumbnails_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-compression-quality', $values ) ) {
				$values ['jpeg-compression-quality'] = Shared::jpeg_quality_default();
			} else {
				$values ['jpeg-compression-quality'] = (int) $values ['jpeg-compression-quality'];
				if ( $values ['jpeg-compression-quality'] < Shared::jpeg_quality_value_min() ) {
					$values ['jpeg-compression-quality'] = Shared::jpeg_quality_default();
				}
				if ( $values ['jpeg-compression-quality'] > Shared::jpeg_quality_value_max() ) {
					$values ['jpeg-compression-quality'] = Shared::jpeg_quality_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-compression-type', $values ) ) {
				$values ['jpeg-compression-type'] = Shared::jpeg_compression_type_default();
			} else {
				$values ['jpeg-compression-type'] = (int) $values ['jpeg-compression-type'];
				if ( ! array_key_exists( $values ['jpeg-compression-type'], $this->get_form_jpeg_compression_types() ) ) {
					$values ['jpeg-compression-type'] = Shared::jpeg_compression_type_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-colorspace', $values ) ) {
				$values ['jpeg-colorspace'] = Shared::jpeg_colorspace_default();
			} else {
				$values ['jpeg-colorspace'] = (int) $values ['jpeg-colorspace'];
				if ( ! array_key_exists( $values ['jpeg-colorspace'], $this->get_form_jpeg_colorspaces() ) ) {
					$values ['jpeg-colorspace'] = Shared::jpeg_colorspace_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-interlace-scheme', $values ) ) {
				$values ['jpeg-interlace-scheme'] = Shared::jpeg_interlace_scheme_default();
			} else {
				$values ['jpeg-interlace-scheme'] = (int) $values ['jpeg-interlace-scheme'];
				if ( ! array_key_exists( $values ['jpeg-interlace-scheme'], $this->get_form_jpeg_interlace_types() ) ) {
					$values ['jpeg-interlace-scheme'] = Shared::jpeg_interlace_scheme_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-sampling-factor', $values ) ) {
				$values ['jpeg-sampling-factor'] = Shared::jpeg_sampling_factor_default();
			} else {
				$valid_sampling_factors = $this->get_form_jpeg_sampling_factors();
				if ( ! array_key_exists( $values ['jpeg-sampling-factor'], $valid_sampling_factors ) ) {
					$values ['jpeg-sampling-factor'] = Shared::jpeg_sampling_factor_default();
				}
			}

			if ( ! array_key_exists( 'jpeg-strip-meta', $values ) ) {
				$values ['jpeg-strip-meta'] = Shared::jpeg_strip_meta_default();
			} else {
				$values ['jpeg-strip-meta'] = (int) $values ['jpeg-strip-meta'];
				if ( ! array_key_exists( $values ['jpeg-strip-meta'], $this->get_form_strip_metadata() ) ) {
					$values ['jpeg-strip-meta'] = Shared::jpeg_strip_meta_default();
				}
			}

			if ( ! array_key_exists( 'png-sharpen-thumbnails', $values ) ) {
				$values ['png-sharpen-thumbnails'] = Shared::png_sharpen_thumbnails_default();
			} else {
				$values ['png-sharpen-thumbnails'] = (int) $values ['png-sharpen-thumbnails'];
				if ( ! array_key_exists( $values ['png-sharpen-thumbnails'], $this->get_form_sharpen_thumbnails() ) ) {
					$values ['png-sharpen-thumbnails'] = Shared::png_sharpen_thumbnails_default();
				}
			}

			if ( ! array_key_exists( 'png-reduce-max-colors-count', $values ) ) {
				$values ['png-reduce-max-colors-count'] = Shared::png_max_colors_value_default();
			} else {
				$values ['png-reduce-max-colors-count'] = (int) $values ['png-reduce-max-colors-count'];
				if ( $values ['png-reduce-max-colors-count'] < Shared::png_max_colors_value_min() ) {
					$values ['png-reduce-max-colors-count'] = Shared::png_max_colors_value_default();
				}
				if ( $values ['png-reduce-max-colors-count'] > Shared::png_max_colors_value_max() ) {
					$values ['png-reduce-max-colors-count'] = Shared::png_max_colors_value_default();
				}
			}

			if ( ! array_key_exists( 'png-strip-meta', $values ) ) {
				$values ['png-strip-meta'] = Shared::png_strip_meta_default();
			} else {
				$values ['png-strip-meta'] = (int) $values ['png-strip-meta'];
				if ( ! array_key_exists( $values ['png-strip-meta'], $this->get_form_strip_metadata() ) ) {
					$values ['png-strip-meta'] = Shared::png_strip_meta_default();
				}
			}

			if ( ! array_key_exists( 'webp-compression-quality', $values ) ) {
				$values ['webp-compression-quality'] = Shared::webp_quality_default();
			} else {
				$values ['webp-compression-quality'] = (int) $values ['webp-compression-quality'];
				if ( $values ['webp-compression-quality'] < Shared::webp_quality_value_min() ) {
					$values ['webp-compression-quality'] = Shared::webp_quality_default();
				}
				if ( $values ['webp-compression-quality'] > Shared::webp_quality_value_max() ) {
					$values ['webp-compression-quality'] = Shared::webp_quality_default();
				}
			}

			if ( ! array_key_exists( 'webp-jpeg-compression-quality', $values ) ) {
				$values ['webp-jpeg-compression-quality'] = Shared::webp_jpeg_quality_default();
			} else {
				$values ['webp-jpeg-compression-quality'] = (int) $values ['webp-jpeg-compression-quality'];
				if ( ! array_key_exists( $values ['webp-jpeg-compression-quality'], $this->get_form_jpeg_to_webp_compression_quality() ) ) {
					$values ['webp-jpeg-compression-quality'] = Shared::webp_jpeg_quality_default();
				}
			}

			$values ['image-max-width-backup'] = false;
			$values ['extra-size-same-width']  = false;

			$this->set_dynamic_menu_position( $values );

			delete_transient( $this->pageslug . '-update-settings' );

			return $values;
		}

		// phpcs:ignore
	# endregion

		// phpcs:ignore
	# region Generate Form Inputs / Validation Arrays

		/** Get possible JPEG Sharpen Image values for the form */
		public function get_form_sharpen_image() {

			$values = array();

			$values [0] = __( 'WP Default (unsharpMaskImage) *', 'warp-imagick' );

			$magic_test = false;
			if ( class_exists( '\\Imagick' ) ) {
				try {
					$magic_test = new \Imagick();
				} catch ( \Exception $e ) {
					return $values;
				}
			}

			if ( is_callable( array( $magic_test, 'sharpenImage' ) ) ) {
				$values [5]  = __( 'SharpenImage Sigma 0.5', 'warp-imagick' );
				$values [6]  = __( 'SharpenImage Sigma 0.6', 'warp-imagick' );
				$values [7]  = __( 'SharpenImage Sigma 0.7', 'warp-imagick' );
				$values [8]  = __( 'SharpenImage Sigma 0.8', 'warp-imagick' );
				$values [9]  = __( 'SharpenImage Sigma 0.9', 'warp-imagick' );
				$values [10] = __( 'SharpenImage Sigma 1.0', 'warp-imagick' );
				$values [11] = __( 'SharpenImage Sigma 1.1', 'warp-imagick' );
				$values [12] = __( 'SharpenImage Sigma 1.2', 'warp-imagick' );
				$values [13] = __( 'SharpenImage Sigma 1.3', 'warp-imagick' );
				$values [14] = __( 'SharpenImage Sigma 1.4', 'warp-imagick' );
				$values [15] = __( 'SharpenImage Sigma 1.5', 'warp-imagick' );
			}

			if ( $magic_test ) {
				$magic_test->clear();
				$magic_test->destroy();
				$magic_test = null;
			}

			return $values;
		}

		/** Get possible JPEG Sharpen Thumbnail values for the form */
		public function get_form_sharpen_thumbnails() {

			$values = array();

			$values [0] = __( 'WP Default (unsharpMaskImage) *', 'warp-imagick' );

			$magic_test = false;
			if ( class_exists( '\\Imagick' ) ) {
				try {
					$magic_test = new \Imagick();
				} catch ( \Exception $e ) {
					return $values;
				}
			}

			if ( is_callable( array( $magic_test, 'sharpenImage' ) ) ) {
				$values [5]  = __( 'SharpenImage Sigma 0.5', 'warp-imagick' );
				$values [6]  = __( 'SharpenImage Sigma 0.6', 'warp-imagick' );
				$values [7]  = __( 'SharpenImage Sigma 0.7', 'warp-imagick' );
				$values [8]  = __( 'SharpenImage Sigma 0.8', 'warp-imagick' );
				$values [9]  = __( 'SharpenImage Sigma 0.9', 'warp-imagick' );
				$values [10] = __( 'SharpenImage Sigma 1.0', 'warp-imagick' );
				$values [11] = __( 'SharpenImage Sigma 1.1', 'warp-imagick' );
				$values [12] = __( 'SharpenImage Sigma 1.2', 'warp-imagick' );
				$values [13] = __( 'SharpenImage Sigma 1.3', 'warp-imagick' );
				$values [14] = __( 'SharpenImage Sigma 1.4', 'warp-imagick' );
				$values [15] = __( 'SharpenImage Sigma 1.5', 'warp-imagick' );
			}

			if ( $magic_test ) {
				$magic_test->clear();
				$magic_test->destroy();
				$magic_test = null;
			}

			return $values;
		}

		/** Get possible JPEG compression types for the form */
		public function get_form_jpeg_compression_types() {

			$values = array();

			$values [0] = __( 'WordPress Default', 'warp-imagick' );

			if ( defined( '\\Imagick::COMPRESSION_JPEG' ) ) {
				$values [ \Imagick::COMPRESSION_JPEG ] = __( 'Imagick Default *', 'warp-imagick' );
			}

			return $values;
		}

		/** Get some available JPEG colorspaces for the form */
		public function get_form_jpeg_colorspaces() {

			$values = array();

			$values [0] = __( 'OFF (WP Default)', 'warp-imagick' );

			if ( defined( '\\Imagick::COLORSPACE_SRGB' ) ) {
				$values [ \Imagick::COLORSPACE_SRGB ] = __( 'sRGB *', 'warp-imagick' );
			}

			return $values;

		}

		/** Get sampling factor choices for the form */
		public function get_form_jpeg_sampling_factors() {

			$is_callable_set_image_property = false;

			$magic_test = false;
			if ( class_exists( '\\Imagick' ) ) {
				try {
					$magic_test = new \Imagick();
				} catch ( \Exception $e ) {
					return array(
						'' => 'ImageMagick Is Not Available',
					);
				}
			}

			if ( is_callable( array( $magic_test, 'setImageProperty' ) ) ) {
				$is_callable_set_image_property = true;
			}

			$magic_test->clear();
			$magic_test->destroy();
			$magic_test = null;

			if ( $is_callable_set_image_property ) {

				return array(
					''      => 'WordPress Default',
					'4:1:0' => '4:1:0 - Smallest file size',
					'4:1:1' => '4:1:1',
					'4:2:0' => '4:2:0 * Recommended by Google',
					'4:2:1' => '4:2:1',
					'4:2:2' => '4:2:2',
					'4:4:0' => '4:4:0',
					'4:4:1' => '4:4:1',
					'4:4:4' => '4:4:4 - Best color resolution',
				);

			} else {

				return array(
					'' => 'Not Available below ImageMagick 6.3.2',
				);
			}
		}

		/** Get strip metadata options for the form */
		public function get_form_strip_metadata() {

			$values = array();

			$values [0] = __( 'WordPress Default', 'warp-imagick' );
			$values [1] = __( 'Do Not Strip At All', 'warp-imagick' );
			$values [2] = __( 'Preserve Important', 'warp-imagick' );

			$magic_test = false;
			if ( class_exists( '\\Imagick' ) ) {
				try {
					$magic_test = new \Imagick();
				} catch ( \Exception $e ) {
					return $values;
				}
			}

			if ( is_callable( array( $magic_test, 'stripImage' ) ) ) {
				$values [3] = __( 'Strip All Metadata *', 'warp-imagick' );
			}

			if ( $magic_test ) {
				$magic_test->clear();
				$magic_test->destroy();
				$magic_test = null;
			}

			return $values;
		}

		/** Get available JPEG interlace types for the form */
		public function get_form_jpeg_interlace_types() {

			$values = array();

			$values [0] = __( 'WordPress Default', 'warp-imagick' );

			if ( defined( '\\Imagick::INTERLACE_JPEG' ) ) {
				$values [ \Imagick::INTERLACE_JPEG ] = __( 'Imagick Default', 'warp-imagick' );
			}
			if ( defined( '\\Imagick::INTERLACE_NO' ) ) {
				$values [ \Imagick::INTERLACE_NO ] = __( 'No Interlace', 'warp-imagick' );
			}
			if ( defined( '\\Imagick::INTERLACE_PLANE' ) ) {
				$values [ \Imagick::INTERLACE_PLANE ] = __( 'Progressive (PLANE)', 'warp-imagick' );
			}
			if ( defined( '\\Imagick::INTERLACE_PLANE' ) && defined( '\\Imagick::INTERLACE_NO' ) ) {
				$values [-1] = __( 'Auto Select *', 'warp-imagick' );
			}

			return $values;

		}

		/** Get sampling factor choices for the form */
		public function get_form_jpeg_to_webp_compression_quality() {
			$values     = array();
			$values [0] = __( 'Use JPEG quality *', 'warp-imagick' );
			$values [1] = __( 'Use WebP quality', 'warp-imagick' );
			return $values;
		}

		// phpcs:ignore
	# endregion

		// phpcs:ignore
	# region Settings Extended

		/** Fields Extended. With default values */
		protected function get_all_fields_extended() {
			return array(
				'configuration'  => array(),
				'plugin-version' => $this->get_plugin()->read_plugin_version(),
			);
		}

		/** Redirect event to renderer class instance method */
		public function on_render_settings_page() {
			$this->renderer->render_page_subtitle();
		}

		// phpcs:ignore
	# endregion

		// phpcs:ignore
	# region Plugin Manager

		/** Overridden to implement custom code on plugin activation requirements
		 *
		 * At this point, plugin PHP/WP requirements are already checked, maybe invalid (if configured).
		 *
		 * @access protected
		 * @param bool  $networkwide flag.
		 * @param array $settings - Plugin Settings (configured activate requirements).
		 * @return array empty or containing (exit) [$message/s] to abort activation
		 */
		protected function on_check_activate_requirements( $networkwide, $settings ) {

			delete_option( $this->get_plugin()->get_option_id() . '_disabled' );

			$fail = array();

			if ( class_exists( '\Imagick' ) ) {

				try {
					$imagick_required = new \Imagick();
				} catch ( Exception $e ) {
					$fail[] = 'Exception thrown on creating PHP \\Imagick class: ' . $e->getMessage();
				}
			}

			if ( ! isset( $imagick_required ) ) {
				$fail[] = 'PHP \\Imagick class does not exists.';
			} elseif ( ! $imagick_required instanceof \Imagick ) {
				$fail[] = 'PHP \\Imagick class is not available.';
			}

			if ( empty( $fail ) ) {
				$current_version = $imagick_required->getVersion();
				if ( is_array( $current_version ) ) {
					$module_version  = $current_version ['versionNumber'];
					$library_version = $current_version ['versionString'];

					$compare_version = '0.0.0';
					$partial_version = preg_split( '~[\s]+~', $library_version, 0, PREG_SPLIT_NO_EMPTY );
					foreach ( $partial_version as $part_version ) {
						if ( preg_match( '~^\d+\.\d+\.\d+~', $part_version ) ) {
							$compare_version = $part_version;
							break;
						}
					}
					if ( version_compare( $compare_version, '6.3.2', '<' ) ) {
						$fail[] = 'PHP Imagick module version is : ' . $module_version . '.';
						$fail[] = 'ImageMagick library version is : ' . $library_version . '.';
						$fail[] = 'Please upgrade module to ImageMagick library version 6.3.2 or newer.';
					}
				} elseif ( is_string( $current_version ) ) {

					$fail[] = 'ImageMagick library version is unknown.';
				} else {
					$fail[] = 'ImageMagick library version is not available.';
				}

				if ( empty( $fail ) && ! is_callable( array( $imagick_required, 'setImageProperty' ) ) ) {
					$fail[] = 'Imagick method "setImageProperty" is not available. Please update Imagick PHP module.';
				}

				$imagick_required->clear();
				$imagick_required->destroy();
				$imagick_required = null;

				if ( empty( $fail ) ) {

					add_filter(
						'wp_image_editors',
						function( $editors ) {

							$wp_editors = array( 'WP_Image_Editor_Imagick', 'WP_Image_Editor_GD' );

							if ( class_exists( 'Warp_Image_Editor_Imagick' ) ) {

								$wp_editors = array( 'Warp_Image_Editor_Imagick', 'WP_Image_Editor_Imagick', 'WP_Image_Editor_GD' );
							}

							foreach ( $editors as $editor ) {
								if ( ! in_array( $editor, $wp_editors, true ) ) {
									array_push( $wp_editors, $editor );
								}
							}
							return $wp_editors;
						}, 9999
					);

					if ( ! in_array( _wp_image_editor_choose(), array( 'WP_Image_Editor_Imagick', 'Warp_Image_Editor_Imagick' ), true ) ) {
						$fail[] = 'Default image editor is not Imagick Editor but: "' . _wp_image_editor_choose() . '".';
						$fail[] = 'Please check if other plugin has conflict with WordPress Imagick Editor.';
					}
					remove_all_filters( 'wp_image_editors', 9999 );
				}
			}

			return $fail;
		}

		/** On plugin activation failed.
		 *
		 * Gracefully handle failure. Do not die(), as parent method defaults.
		 *
		 * @access protected
		 * @param array $fail is an array of missing requirements - strings.
		 * @return void
		 */
		protected function on_activate_plugin_failed( $fail ) {

			if ( ! is_array( $fail ) ) {
				Lib::debug( 'Var $fail must be an array here.' );
			}
			update_option( $this->get_plugin()->get_option_id() . '_disabled', $fail, $autoload = true );
		}

		/** On plugin activation (success).
		 *
		 * Initialize (multi)site options.
		 *
		 * @access protected
		 * @param bool $networkwide flag.
		 * @return void
		 */
		protected function on_activate_plugin( $networkwide ) {

			delete_option( $this->get_plugin()->get_option_id() . '_disabled' );

			$this->init_all_options( $networkwide );

			parent::on_activate_plugin( $networkwide );
		}

		/** On Plugin deactivate, action handler
		 *
		 * @param bool $networkwide flag.
		 */
		protected function on_deactivate_plugin( $networkwide ) {

			delete_option( $this->get_plugin()->get_option_id() . '_disabled' );
			delete_user_setting(
				array(
					'warpimagicksections',
					'warpimagicktabindex',
					'warp-imagick-sections',
					'warp-imagick-tabindex',
				)
			);
		}

		/** On Plugin uninstall, action handler */
		protected static function on_uninstall_plugin() {

			$instance = self::instance();
			if ( $instance && $instance->get_plugin()->get_option( 'remove-settings', Shared::remove_plugin_settings_default() ) ) {
				self::remove_all_options( $instance->optionid );
			}
			parent::on_uninstall_plugin();

		}

		// phpcs:ignore
	# endregion

	}
}

