=== Warp iMagick: WordPress Image Compressor, Image Optimizer, Convert WebP ===
Plugin Name: Warp iMagick: Compress, Optimize &amp; Sharpen Images. Convert WebP. Disable "big image" threshold.
Author: Dragan Đurić
Contributors: ddur
License: GPLv2
Requires PHP: 5.6
Tested up to: 5.7
Stable tag: 1.3.13
Requires at least: 5.3
Tags: compress images, convert webp, image compression, image optimizer, sharpen

Service free compress, optimize &amp; sharpen images. Disable "big image" threshold. Convert to WebP.

== Description ==

* **Quick & easy to use: Install, activate, configure and start uploading new media images!**
To (re)compress existing media images use ["Regenerate Thumbnails Plugin"](https://wordpress.org/plugins/regenerate-thumbnails/) or ["WP CLI media regenerate" command](https://developer.wordpress.org/cli/commands/media/regenerate/).

* **New in 1.3.13 - "Full size Compressed".**
Original file will be compressed to 'filename'-(Width)x(Height).'ext'. Original image remains unchanged. Due to PHP-imagick resource limits, only if upload/original is not larger than 2500x2500 pixels.

* **New in 1.3.13 - "Sharpen JPEG Image".**
Dual setting to sharpen full-size and thumbnail/sizes JPEG images.

* **New in 1.3.13 - "Transparent WebP".**
Both transparent and opaque PNG images are converted to Webp.

* **After activation, only settings you maybe want to change is JPEG Compression Quality and SharpenImage Sigma.**
Choose your compression quality from 30% to 95%. Sharpen Image from 0.5 to 1.5 Sigma. For the rest of the settings, use defaults or feel free to experiment and have fun with. 😇


[youtube https://www.youtube.com/watch?v=SnFOEhi0ym0]


[youtube https://www.youtube.com/watch?v=F1kYBnY6mwg]


* **Automatic image optimization to thumbnails and conversion to WebP clones:**
No limits in number or size of images. No external service required. Compress better or keep higher image quality than WordPress does by default. Images will be automatically compressed on upload or on "regenerate thumbnails". Uploaded image is always preserved in original state. Image Compression will always start from original image quality. You can't "overoptimize". Reoptimize existing images with ["Regenerate Thumbnails plugin"](https://wordpress.org/plugins/regenerate-thumbnails/) single or batch process, or with ["WP CLI media regenerate" command](https://developer.wordpress.org/cli/commands/media/regenerate/).

* **Compatible with ["WP CLI media regenerate" command](https://developer.wordpress.org/cli/commands/media/regenerate/) and/or with ["Regenerate Thumbnails" plugin](https://wordpress.org/plugins/regenerate-thumbnails/).**
**Important Note:** Since WordPress 5.3, BIG JPEG images reduced to 2560x2560 (by "Big Image Size Threshold" feature) and then manually edited by user, on regenerate, will be restored back to original (unedited) version. User edited modifications will be lost. See [GitHub issue](https://github.com/Automattic/regenerate-thumbnails/issues/102). Same bug/issue applies both to ["WP CLI media regenerate" command](https://developer.wordpress.org/cli/commands/media/regenerate/) and ["Regenerate Thumbnails plugin"](https://wordpress.org/plugins/regenerate-thumbnails/). To fix that bug/issue, install or upgrade Warp iMagick plugin to version 1.3.13 or above.

* **Compatible up to PHP 7.4.9 and tested against coding standards.**
Tested with [PHP_CodeSniffer (phpcs)](https://github.com/squizlabs/PHP_CodeSniffer) using [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/) [GitHub](https://github.com/WordPress/WordPress-Coding-Standards) rules and [PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility) rules.

* **Improve your site performance, Google PageSpeed score and SEO ranking when serving better compressed JPEG/PNG or WebP images.**
Every JPEG and every non-transparent PNG media image or thumbnail found during image optimization process is converted to WebP and saved as copy with .webp extension added. Default PNG&JPEG to WebP images compression quality is 75% (configurable). In addition, JPEG to WebP compression quality can be set to use & follow compression quality set for JPEG images.

* **WebP Delivery Note**
Due to variety of hosting server software, cache pugins or CDN used, this plugin even does not try to automagically configure your server to deliver WebP images. You will find instructions on how to configure server and deliver WebP images on the settings page. Click on **HELP** at the top right of the plugin **SETTINGS PAGE**. Serving WebP images requires manual (DIY) configuration of Apache .htaccess file or NGinx configuration & restart, or IIS or LiteSpeed ...

* **Warp-iMagick - Image Optimizer gives you full control over images, file size and quality in image optimization process.**
Images optimization is customizable with advanced image compression settings. See the plenty of options used to optimize images in the **Features** section below.

* **Multisite support**
Designed to work on WP multisite. No known reason to fail on WP multisite, but not extensively tested yet!

* **Clean uninstall**
By default, no plugin settings are left in your database after uninstall. Feel free to install and activate to make a trial. However, you can choose to preserve plugin options after uninstall. For detailed uninstall info related to added WebP images, see the **FAQ** section below.

* **Privacy**
Warp-iMagick plugin does not collect nor send any personally identifiable data from your server. WordPress builtin cookies are used to store admin-settings page-state.

* **Known conflicts**
Due to use of [bfi_thumb library](https://github.com/bfintal/bfi_thumb) which completely takes over wordpress WP_Image_Editor classes, in [Ajax Search Lite](https://wordpress.org/plugins/ajax-search-lite/) plugin and in [Circles Gallery](https://wordpress.org/plugins/circles-gallery/) plugin, Warp iMagick plugin will fail to activate while those plugins are active. Activating those plugins after Warp iMagick may cause malfunction of Warp iMagick.

= Features =

* **Free and Private: No external service or signup required.**
Plugin uses only PHP software installed on your server.

== Installation ==

= Using The WordPress Plugin Repository =
1. Navigate to the 'Plugins' -> 'Add New' .
2. Search for 'Warp iMagick'.
3. Select and click 'Install Now'.
4. Activate the plugin.

== Upgrade Notice ==
None.

== Screenshots ==
1. **JPEG Settings**
2. **PNG Settings**
3. **WebP Settings**
4. **Other Settings**
5. **Regenerate Thumbnails**
6. **WebP Mobile Page Score**

== Frequently Asked Questions ==

= Which PHP extensions are required by this plugin? =
1. PHP-Imagick to compress JPEG/PNG files (required).
2. PHP-GD for WebP files (optional, but usually installed).

In order to modify/resize/crop photos or images, Wordpress requires at least PHP-GD. When both extensions are installed, WordPress prefers PHP-Imagick over PHP-GD.

= Do I have both required PHP extensions installed? =
1. WordPress 5.2 and above: Administrator: Menu -> Tools -> Site Health -> Info -> Expand "Media Handling" and check if "ImageMagick version string" and "GD version" have values.
2. WordPress 5.1 and below: Install [Health Check & Troubleshooting](https://wordpress.org/plugins/health-check/) plugin. Open "Health Check" plugin page and click on "PHP Information" tab. You will find there all PHP extensions installed and enabled. Search (Ctrl-F) on page for "Imagick" and "GD".
3. WordPress Editor class must be WP_Image_Editor_Imagick (or Warp_Image_Editor_Imagick) but **NOT** WP_Image_Editor_GD.
4. PHP-Imagick extension must be linked with ImageMagick library version **6.3.2** or newer.
5. PHP-GD extension version must be at least 2.0.0 to be accepted by WordPress Image Editor.

= Does my web hosting service provide PHP Imagick and GD extensions? =
1. [WPEngine](https://wpengine.com/support/platform-settings/): Both by default.
2. [EasyWP](https://www.namecheap.com/support/knowledgebase/article.aspx/9697/2219/php-modules-and-extensions-on-shared-hosting-servers): Both by default.
3. [DreamHost](https://help.dreamhost.com/hc/en-us/articles/214893957): By configuration.
4. [SiteGround](https://www.siteground.com/kb/enable-imagick-imagemagick/): Must enable.
5. Ask your host-service provider.

= How to install missing PHP-Imagick extension? =
1. [CPanel based host](https://documentation.cpanel.net/display/68Docs/PHP+Extensions+and+Applications+Package#PHPExtensionsandApplicationsPackage-PHPExtensionsandApplicationsPackageInstaller)
2. [PHP-Imagick setup](https://www.php.net/manual/en/imagick.setup.php)
3. Debian/Ubuntu: "apt-get install php-imagick".
4. Fedora/CentOs: "yum install php-imagick".
5. Ask your host-service provider.

= How to serve WebP images? =
See the settings page **HELP** for instructions on how to configure server to redirect .jpg/.png to .jpg.webp/.png.webp, if such file exists and browser suports WebP image format.

= Why WebP files have two extensions? =
To prevent overwriting duplicate "WebP" files. With single extension, when you upload "image.png" and "image.jpg", second "image.webp" would overwrite previous one.

= Why is WebP setting (checkbox) disabled? =
Because your server has no PHP-GD graphic editing extension or your PHP-GD extension has no WebP support.

= What happens with images when plugin is deactivated or deleted? =
1. Existing images remain optimized. If you run ["Regenerate Thumbnails"](https://wordpress.org/plugins/regenerate-thumbnails/) batch process, after plugin is deactivated or deleted, batch process will restore original file-size and quality of WordPress thumbnails.
2. If you have WebP images, they won't be deleted. You can delete all WebP images while plugin is active. To delete WebP images, disable WebP option and then batch-run ["Regenerate Thumbnails"](https://wordpress.org/plugins/regenerate-thumbnails/) for all media images.

= Why plugin fails to activate on my server? =
Because your server has no PHP-Imagick installed or has too old version of PHP-Imagick.

== Changelog ==

= 1.3.13 =
* Original JPEG is compressed to filename-WxH and attached as full-size.
* Original JPEG image is available via wp_get_original_image_path().
* Convert all (not transparent and transparent) PNG images to WebP.
* By WP "-rotated" JPEG images are compressed after rotation.
* Enforce strip-meta setting to 'image_strip_meta' filters.
* ICC profile is removed from thumbnails converted to sRGB.
* New option setting to Sharpen JPEG image and thumbnails.
* JPEG Colorspace choices reduced to sRGB or disabled.
* Option to reduce images to maximum width is removed.
* Default JPEG compression quality has changed to 60%.
* Maximal JPEG compression quality increased to 95%.
* Maximal WebP compression quality increased to 95%.
* Fix: Remove user-setting on deactivate/uninstall.
* FixUI: Show/hide second WebP compression quality.

= Older =
* [Complete Changelog.txt](https://plugins.trac.wordpress.org/browser/warp-imagick/tags/1.3.13/changelog.txt)

