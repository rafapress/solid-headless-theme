<?php

	namespace app\api\repositories;

	class TeamRepository {

		public function list(): ?array {

			$query = new \WP_Query([
				'post_type'      => 'team',
				'posts_per_page' => -1,
				'post_status'    => 'publish'
			]);

			$persons = [];

			while ($query->have_posts()) {

				$query->the_post();

				$id = get_the_ID();

				$persons[] = [
					'id'								=> $id,
					'name'							=> sanitize_text_field(get_post_meta($id, 'name', true)),
					'position'					=> sanitize_text_field(get_post_meta($id, 'position', true)),
					'description'				=> sanitize_text_field(get_post_meta($id, 'description', true)),
					'image'							=> get_the_post_thumbnail_url($id, 'full') ?: null
				];

			}

			wp_reset_postdata();

			return $persons;

		}

		public function details(string $slug): ?array {

			$query = new \WP_Query([
				'post_type'      => 'product',
				'name'           => $slug,
				'post_status'    => 'publish',
				'posts_per_page' => 1
			]);

			if (!$query->have_posts()) return null;

			$post = $query->posts[0];

			if (!$post || $post->post_type !== 'product' || $post->post_status !== 'publish') {
				return null;
			}

			return [
				'id'          			=> $post->ID,
				'title'       			=> get_the_title($post),
				'excerpt'     			=> get_the_excerpt($post),
				'image'       			=> get_the_post_thumbnail_url($post, 'medium'),
				'slug'        			=> get_post_field('post_name', $post),
				'price'       			=> (float) get_post_meta($post->ID, 'price', true),
				'stock'       			=> (int) get_post_meta($post->ID, 'stock', true),
				'brand'       			=> sanitize_text_field(get_post_meta($post->ID, 'brand', true)),
				'color'       			=> sanitize_text_field(get_post_meta($post->ID, 'color', true)),
				'warranty'    			=> sanitize_text_field(get_post_meta($post->ID, 'warranty', true)),
				'short_description'	=> wp_kses_post(get_post_meta($post->ID, 'short_description', true)),
			];

		}

	}
