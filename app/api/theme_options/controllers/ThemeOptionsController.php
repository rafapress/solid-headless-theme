<?php

	namespace app\api\theme_options\controllers;

	use app\api\theme_options\services\ThemeOptionsService;
	use app\api\theme_options\repositories\ThemeOptionsRepository;
	use app\api\helpers\CacheHelper;
	use WP_REST_Response;
	use WP_REST_Request;

	class ThemeOptionsController {

		public static function get() {

			$options = CacheHelper::getOrSet('theme_options_cache', function () {
				$service = new ThemeOptionsService(new ThemeOptionsRepository());
				return $service->get();
			}, 604800);

			return new \WP_REST_Response($options, 200);

    }

		public static function save() {

			$service = new ThemeOptionsService(new ThemeOptionsRepository());

			$data = json_decode(file_get_contents('php://input'), true);
			if (empty($data)) {
				$data = $_POST;
			}

			$service->save($data);

			return new \WP_REST_Response(['message' => 'Opções salvas com sucesso.'], 200);

		}

		public static function checkPermission(WP_REST_Request $request): bool {

			if (!current_user_can('manage_options')) {
				return false;
			}

			$nonce = $request->get_header('X-WP-Nonce');
			if (!wp_verify_nonce($nonce, 'wp_rest')) return false;

			return true;

		}

	}