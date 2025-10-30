<?php

	namespace app\api\controllers;

	use app\api\services\BlogService;
	use app\api\repositories\BlogRepository;
	use app\api\helpers\CacheHelper;

	class BlogController {

		public static function list() {

			if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
				return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
			}

			$blog = CacheHelper::getOrSet('blog_cache', function () {
				$service = new BlogService(new BlogRepository());
				return $service->list();
			}, 604800); // 7 dias

			return new \WP_REST_Response($blog, 200);

		}

	}