<?php

	namespace app\api\repositories;

	class AboutRepository {

		public function get(): ?array {

			$page = get_page_by_path('about');

			if (!$page) return null;

			return [
				'id'				=> $page->ID,
				'title'			=> get_the_title($page),
				'content'		=> apply_filters('the_content', $page->post_content),
				'image'			=> get_the_post_thumbnail_url($page->ID, 'full') ?: null,
			];

		}

	}