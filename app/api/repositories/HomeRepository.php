<?php

	namespace app\api\repositories;

	class HomeRepository {

		public function getHomePageId(): ?int {

			$page = get_pages([
				'meta_key'		=> '_wp_page_template',
				'meta_value'	=> 'page-home.php',
				'number'			=> 1
			]);

			return $page[0]->ID ?? null;

		}

		public function get(): array {

			$homeId = $this->getHomePageId();

			if (!$homeId) return [];

			return [
				'show_products'	=> get_post_meta($homeId, 'home_show_products', true),
				'show_team'			=> get_post_meta($homeId, 'home_show_team', true)
			];

		}

	}