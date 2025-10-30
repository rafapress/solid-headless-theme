<?php

	namespace app\api\controllers;

	use app\api\services\HomeService;
	use app\api\repositories\HomeRepository;
	use app\api\helpers\CacheHelper;

	class HomeController {

		public static function get() {

			if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
				return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
			}

			$home = CacheHelper::getOrSet('home_cache', function () {
				$service = new HomeService(new HomeRepository());
				return $service->get();
			}, 604800); // 7 dias

			return new \WP_REST_Response($home, 200);

		}

	}