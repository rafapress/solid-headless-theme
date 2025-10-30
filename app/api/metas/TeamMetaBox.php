<?php

	add_action('add_meta_boxes', function () {

		add_meta_box(
			'team_custom_fields',
			'Informações',
			'render_team_meta_box',
			'team',
			'normal',
			'high'
		);

	});

	function render_team_meta_box($post) {

		$fields = [
			'name'							=> 'Nome',
			'position'					=> 'Cargo',
			'description'				=> 'Descrição',
			'image'							=> 'Foto'
		];

		wp_nonce_field('save_team_meta_box', 'team_meta_box_nonce');

		echo '<table class="form-table">';

		foreach ($fields as $key => $label) {
			$value = get_post_meta($post->ID, $key, true);
			echo '<tr>';
			echo "<th><label for='{$key}'>{$label}</label></th>";
			echo "<td><input type='text' name='{$key}' id='{$key}' value='" . esc_attr($value) . "' class='regular-text' /></td>";
			echo '</tr>';
		}

		echo '</table>';

	}

	add_action('save_post_team', function($post_id) {

		if (!isset($_POST['team_meta_box_nonce']) || !wp_verify_nonce($_POST['team_meta_box_nonce'], 'save_team_meta_box')) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (!current_user_can('edit_post', $post_id)) return;

		$fields = ['name', 'position', 'description', 'image'];

		foreach ($fields as $field) {
			if (isset($_POST[$field])) {
				update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
			}
		}

	});