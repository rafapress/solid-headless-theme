<?php

	namespace app\api\controllers;

	use app\api\services\AboutService;
	use app\api\repositories\AboutRepository;
	use app\api\helpers\CacheHelper;

	class AboutController {

		public static function get() {

			if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
				return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
			}

			$about = CacheHelper::getOrSet('about_cache', function () {
				$service = new AboutService(new AboutRepository());
				return $service->get();
			}, 604800); // 7 dias

			return new \WP_REST_Response($about, 200);

		}

	}