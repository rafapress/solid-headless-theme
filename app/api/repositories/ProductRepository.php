<?php

	namespace app\api\repositories;

	class ProductRepository {

		public function list(): array {

			$query = new \WP_Query([
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			]);

			$products = [];

			while ($query->have_posts()) {

				$query->the_post();

				$id = get_the_ID();

				$products[] = [
					'id'          			=> $id,
					'title'       			=> get_the_title(),
					'excerpt'     			=> get_the_excerpt(),
					'image'       			=> get_the_post_thumbnail_url($id, 'medium'),
					'slug'        			=> get_post_field('post_name', $id),
					'price'							=> (float) get_post_meta($id, 'price', true),
					'stock'							=> (int) get_post_meta($id, 'stock', true),
					'brand'       			=> sanitize_text_field(get_post_meta($id, 'brand', true)),
					'color'       			=> sanitize_text_field(get_post_meta($id, 'color', true)),
					'warranty'    			=> sanitize_text_field(get_post_meta($id, 'warranty', true)),
					'short_description'	=> wp_kses_post(get_post_meta($id, 'short_description', true)),
				];

			}

			wp_reset_postdata();

			return $products;

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
