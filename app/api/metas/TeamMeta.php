<?php

	add_action('init', function () {

		$fields = [
			'name'					=> 'string',
			'position'			=> 'string',
			'description'		=> 'string',
			'image'					=> 'string'
		];

		foreach ($fields as $field => $type) {

			register_post_meta('team', $field, [
				'type'								=> $type,
				'single'							=> true,
				'show_in_rest'				=> true,
				'sanitize_callback'		=> 'sanitize_text_field',
				'auth_callback'				=> function () {
					return current_user_can('edit_posts');
				}
			]);
		}

	});
