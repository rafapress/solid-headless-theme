<?php

	namespace app\api\controllers;

	use app\api\services\ProductService;
	use app\api\repositories\ProductRepository;
	use app\api\helpers\CacheHelper;

	class ProductController {

		public static function list() {

			if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
				return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
			}

			$products = CacheHelper::getOrSet('products_cache', function () {
				$service = new ProductService(new ProductRepository());
				return $service->list();
			}, 604800); // 7 dias

			return new \WP_REST_Response($products, 200);

			$service	= new ProductService(new ProductRepository());
			$products	= $service->list();

			return new \WP_REST_Response($products, 200);

		}

		public static function details(\WP_REST_Request $request) {

			if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
				return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
			}

			$slug = sanitize_title($request['slug']);

			if (!$slug) {
				return new \WP_REST_Response(['message' => 'Invalid Slug'], 400);
			}

			$product = CacheHelper::getOrSet('product-details_cache', function () {
				$service = new ProductService(new ProductRepository());
				return $service->details($slug);
			}, 604800); // 7 dias

			if (!$product) {
				return new \WP_REST_Response(['message' => 'Product not found'], 404);
			}

			return new \WP_REST_Response($product, 200);

		}

	}