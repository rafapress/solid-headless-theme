<?php

function debug_to_file($message) {
	$upload_dir = wp_upload_dir();
	$log_file = $upload_dir['basedir'] . '/debug-home-metabox.txt';

	file_put_contents($log_file, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

	add_action('add_meta_boxes', function () {

		global $post;
		if (!$post) return;

		$template = get_page_template_slug($post->ID);

	debug_to_file("Template slug for post {$post->ID} is: {$template}");

		if (substr($template, -strlen('page-home.php')) === 'page-home.php') {
			add_meta_box(
				'home_sections_metabox',
				'Seções da Página Home',
				'render_home_meta_box',
				'page',
				'normal',
				'default'
			);
		}

	});

function render_home_meta_box($post) {
	wp_nonce_field('save_home_meta_box', 'home_meta_box_nonce');

	$show_products = get_post_meta($post->ID, 'home_show_products', true);
	$show_team     = get_post_meta($post->ID, 'home_show_team', true);

	echo '<p><strong>Exibir seção de Produtos?</strong><br>';
	echo '<label><input type="radio" name="home_show_products" value="1" ' . checked($show_products, '1', false) . '> Sim</label><br>';
	echo '<label><input type="radio" name="home_show_products" value="0" ' . checked($show_products, '0', false) . '> Não</label></p>';

	echo '<hr>';

	echo '<p><strong>Exibir seção de Equipe?</strong><br>';
	echo '<label><input type="radio" name="home_show_team" value="1" ' . checked($show_team, '1', false) . '> Sim</label><br>';
	echo '<label><input type="radio" name="home_show_team" value="0" ' . checked($show_team, '0', false) . '> Não</label></p>';
}

add_action('save_post_page', function ($post_id) {

	if (!isset($_POST['home_meta_box_nonce']) || !wp_verify_nonce($_POST['home_meta_box_nonce'], 'save_home_meta_box')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	if (!current_user_can('edit_post', $post_id)) return;

	if (isset($_POST['home_show_products'])) {
		update_post_meta($post_id, 'home_show_products', sanitize_text_field($_POST['home_show_products']));
	}

	if (isset($_POST['home_show_team'])) {
		update_post_meta($post_id, 'home_show_team', sanitize_text_field($_POST['home_show_team']));
	}
});
