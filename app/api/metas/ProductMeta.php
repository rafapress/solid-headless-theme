<?php

	add_action('init', function () {

		$fields = [
			'price'								=> 'float',
			'stock'								=> 'integer',
			'brand'								=> 'string',
			'short_description'		=> 'string',
			'warranty'						=> 'string',
			'color'								=> 'string'
		];

		foreach ($fields as $field => $type) {

			if ($type === 'integer') {
				$sanitize = 'intval';
			} elseif ($type === 'float') {
				$sanitize = 'floatval';
			} else {
				$sanitize = 'sanitize_text_field';
			}

			register_post_meta('product', $field, [
				'type'								=> $type,
				'single'							=> true,
				'show_in_rest'				=> true,
				'sanitize_callback'		=> $sanitize,
				'auth_callback'				=> function () {
					return current_user_can('edit_posts');
				}
			]);

		}

	});