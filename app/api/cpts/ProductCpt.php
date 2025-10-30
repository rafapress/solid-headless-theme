<?php

	add_action('init', function () {

		$labels = array(
			'name'								=> __('Products'),
			'singular_name'				=> __('Product'),
			'add_new'							=> __('Add New'),
			'add_new_item'				=> __('Add New'),
			'edit_item'						=> __('Edit'),
			'new_item'						=> __('New'),
			'all_items'						=> __('View all'),
			'view_item'						=> __('View'),
			'search_items'				=> __('Search'),
			'not_found'						=> __('No products found')
		);

		$args = array(
			'labels'							=> $labels,
			'description'					=> 'Product',
			'supports'						=> array('title', 'editor', 'excerpt', 'thumbnail'),
			'public'							=> true,
			'has_archive'					=> true,
			'show_in_rest'				=> true,
			'rewrite'							=> ['slug' => 'shop-products'],
			'menu_icon'						=> 'dashicons-cart'
		);

		register_post_type('product', $args);

	});