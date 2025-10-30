<?php

	if (!defined('ABSPATH')) exit;

	require_once __DIR__ . '/app/config/bootstrap.php';

	use app\api\routes\RouteLoader;
	use app\api\helpers\CacheHelper;

	function get_component_list(): array {

		$components = [];
		$dir = get_template_directory() . '/app/components/';

		if (!is_dir($dir)) return [];

		foreach (scandir($dir) as $file) {
			if (pathinfo($file, PATHINFO_EXTENSION) === 'js') {
				$components[] = pathinfo($file, PATHINFO_FILENAME);
			}
		}

		return $components;

	}

	add_action('rest_api_init', function () {
		$routes = require __DIR__ . '/app/api/routes/routes-map.php';
		(new RouteLoader('headless/v1', $routes))->register();
	});

	add_action('wp_enqueue_scripts', function () {

		$theme_uri = get_template_directory_uri();
		$theme_dir = get_template_directory();

		foreach (glob($theme_dir . '/assets/css/*.css') as $css_file) {
			$handle = 'theme-' . basename($css_file, '.css');
			wp_enqueue_style($handle, $theme_uri . '/assets/css/' . basename($css_file), [], filemtime($css_file));
		}

		foreach (glob($theme_dir . '/assets/scripts/*.js') as $js_file) {
			$handle = 'theme-' . basename($js_file, '.js');
			wp_enqueue_script($handle, $theme_uri . '/assets/scripts/' . basename($js_file), [], filemtime($js_file), true);
		}

		wp_enqueue_script('headless-app', get_template_directory_uri() . '/app/app.js', [], null, true);

		wp_localize_script('headless-app', 'HeadlessData', [
			'nonce'				=> wp_create_nonce('wp_rest'),
			'siteUrl'			=> get_site_url(),
			'components'	=> get_component_list(),
			'themeName'		=> wp_get_theme()->get('TextDomain'),
			'sitePath'		=> parse_url(get_site_url(), PHP_URL_PATH)
		]);

	});

	add_filter('script_loader_tag', function ($tag, $handle, $src) {
		$module_scripts = ['headless-app'];
		if (in_array($handle, $module_scripts)) {
			return '<script type="module" src="' . esc_url($src) . '"></script>';
		}
		return $tag;
	}, 10, 3);

	add_action('init', function () {
		add_rewrite_rule('^post/([^/]*)/?$', 'index.php?pagename=post&post_slug=$matches[1]', 'top');
	});

	$clear_cache = function ($post_id) {
		if (wp_is_post_revision($post_id)) return;
		CacheHelper::clearComponents(get_component_list());
	};

	add_action('save_post', $clear_cache);
	add_action('delete_post', $clear_cache);

	function get_current_language(): string {

		$lang				= sanitize_key($_COOKIE['site_lang'] ?? '');
		$available	= array_keys(LanguageLoader::getAvailableLanguages());
		return in_array($lang, $available, true) ? $lang : 'portuguese';

	}

	function get_phrase(string $key): string {

		static $translator	= null;
		$current_lang				= get_current_language();

		if ($translator === null || $translator->lang !== $current_lang) {
			$translator = new Translator($current_lang);
		}

		return $translator->translate($key);

	}

	add_action('after_setup_theme', function () {

		$theme_textdomain = wp_get_theme()->get('TextDomain');

		add_theme_support('title-tag');

		add_theme_support('custom-logo', [
			'height'			=> 100,
			'width'				=> 400,
			'flex-height'	=> true,
			'flex-width'	=> true
		]);

		add_theme_support('post-thumbnails');

		add_theme_support('html5', ['search-form', 'gallery', 'caption']);

		register_nav_menus([
			'primary'	=> __('Menu Principal', $theme_textdomain),
			'footer'	=> __('Menu Rodapé', $theme_textdomain)
		]);

	});

	add_action('wp_head', function () {
		$favicon_url = get_template_directory_uri() . '/favicon.ico';
		echo '<link rel="icon" href="' . esc_url($favicon_url) . '" type="image/x-icon" />' . "\n";
	});

// function _jqmigrate_mute() {
//   wp_add_inline_script('jquery-migrate', 'jQuery.migrateMute = true;', 'before');
// }
// ​
// add_action('wp_enqueue_scripts', '_jqmigrate_mute');
// add_action('admin_enqueue_scripts', '_jqmigrate_mute');

// add_filter( 'template_include', 'load_static_html_from_theme' );

// function load_static_html_from_theme( $template ) {
//     if ( is_page() ) {
//         $current_slug = get_post_field( 'post_name', get_post() );

//         $html_file = get_template_directory() . '/pages/' . $current_slug . '.html';

//         if ( file_exists( $html_file ) ) {
//             readfile( $html_file );
//             exit;
//         }
//     }

//     return $template;
// }