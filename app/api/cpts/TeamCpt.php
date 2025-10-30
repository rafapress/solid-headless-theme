<?php

	add_action('init', function () {

		$labels = array(
			'name'                => __('Team'),
			'singular_name'       => __('Team'),
			'add_new'             => __('Add New'),
			'add_new_item'        => __('Add New'),
			'edit_item'           => __('Edit'),
			'new_item'            => __('New'),
			'all_items'           => __('View all'),
			'view_item'           => __('View'),
			'search_items'        => __('Search'),
			'not_found'						=> __('No persons found')
		);

		$args = array(
			'labels'							=> $labels,
			'description'					=> 'Team',
			'supports'						=> array('title', 'editor', 'excerpt', 'thumbnail'),
			'public'							=> true,
			'has_archive'					=> true,
			'show_in_rest'				=> true,
			'rewrite'							=> ['slug' => 'company-team']
		);

		register_post_type('team', $args);

	});