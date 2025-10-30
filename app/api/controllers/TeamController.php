<?php

	namespace app\api\controllers;

	use app\api\services\TeamService;
	use app\api\repositories\TeamRepository;
	use app\api\helpers\CacheHelper;

	class TeamController {

		public static function list() {

			if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
				return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
			}

			$team = CacheHelper::getOrSet('team_cache', function () {
				$service = new TeamService(new TeamRepository());
				return $service->list();
			}, 604800); // 7 dias

			return new \WP_REST_Response($team, 200);

		}

	}