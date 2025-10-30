<?php

	namespace app\api\controllers;

	use app\api\services\LanguageService;
	use app\api\repositories\LanguagesRepository;
	use app\api\helpers\CacheHelper;

	class LanguageController {

		public static function get() {

        $lang = $_SERVER['HTTP_X_SITE_LANG'] ?? 'portuguese';

        $service = new LanguageService(
            new LanguagesRepository(get_template_directory() . '/app/languages/translations')
        );

        $data = [
            'language'           => $lang,
            'translations'       => $service->getTranslations($lang),
            'availableLanguages' => $service->getAvailableLanguages()
        ];

        return new \WP_REST_Response($data, 200);

			// $lang = get_current_language(); // lê cookie e valida idioma

			// $lang = $_SERVER['HTTP_X_SITE_LANG'] ?? 'portuguese';
			// $cacheKey = "languages_cache_{$lang}";

			// $data = CacheHelper::getOrSet($cacheKey, function () use ($lang) {

			// 	$service = new LanguageService(new LanguagesRepository(get_template_directory() . '/app/languages/translations'));
			// 	$translations = $service->getTranslations($lang);
			// 	return [
			// 		'language'						=> $lang,
			// 		'translations'				=> $service->getTranslations($lang),
			// 		'availableLanguages'	=> $service->getAvailableLanguages()
			// 	];
			// }, 86400);

			// return new \WP_REST_Response($data, 200);

		}

		// public static function get() {

		// 	// if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
		// 	// 	return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
		// 	// }

		// 	$lang = get_current_language();
		// 	$cacheKey = "languages_cache_{$lang}";

		// 	$data = CacheHelper::getOrSet($cacheKey, function () use ($lang) {

		// 		$service = new LanguageService(new LanguagesRepository(get_template_directory() . '/app/languages/translations'));
		// 		$lang = get_current_language();

		// 	return [
		// 			'language' => $lang,
		// 			'translations' => $service->getTranslations($lang),
		// 			'availableLanguages' => $service->getAvailableLanguages()
		// 		];
		// 	}, 86400);

		// 	return new \WP_REST_Response($data, 200);
		// }

	}