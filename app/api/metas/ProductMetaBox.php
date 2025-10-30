<?php

	add_action('add_meta_boxes', function () {

		add_meta_box(
			'product_custom_fields',
			'Informações do produto',
			'render_product_meta_box',
			'product',
			'normal',
			'high'
		);

	});

	function render_product_meta_box($post) {

		$fields = [
			'price'							=> 'Preço',
			'stock'							=> 'Quantidade',
			'brand'							=> 'Marca',
			'short_description'	=> 'Descrição',
			'warranty'					=> 'Garantia',
			'color'							=> 'Cor'
		];

		wp_nonce_field('save_product_meta_box', 'product_meta_box_nonce');

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

	add_action('save_post_product', function($post_id) {

		if (!isset($_POST['product_meta_box_nonce']) || !wp_verify_nonce($_POST['product_meta_box_nonce'], 'save_product_meta_box')) {
			return;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (!current_user_can('edit_post', $post_id)) return;

		$fields = ['price', 'stock', 'brand', 'short_description', 'warranty', 'color'];

		foreach ($fields as $field) {
			if (isset($_POST[$field])) {
				update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
			}
		}

	});