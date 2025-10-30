<?php

	add_action('init', function () {

	$fields = [
		'home_show_products'	=> 'boolean',
		'home_show_team'			=> 'boolean'
	];

	foreach ($fields as $field => $type) {

		register_post_meta('page', $field, [
			'type'								=> $type,
			'single'							=> true,
			'show_in_rest'				=> true,
			'sanitize_callback'		=> ($type === 'boolean') ? 'boolval' : 'sanitize_text_field',
			'auth_callback'				=> function () {
				return current_user_can('edit_posts');
			}
		]);

	}

});
