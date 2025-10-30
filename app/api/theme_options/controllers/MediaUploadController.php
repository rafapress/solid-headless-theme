<?php

	namespace app\api\theme_options\controllers;

	use WP_REST_Request;
	use WP_REST_Response;

	class MediaUploadController {

		public static function upload(WP_REST_Request $request): WP_REST_Response {

			if (! function_exists('wp_handle_upload')) {
				require_once(ABSPATH . 'wp-admin/includes/file.php');
			}

			if (empty($_FILES['file'])) {
				return new WP_REST_Response(['message' => 'Nenhum arquivo enviado.'], 400);
			}

			$file = $_FILES['file'];

			$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
			if (!in_array($file['type'], $allowed_types)) {
				return new WP_REST_Response(['message' => 'Tipo de arquivo não suportado.'], 400);
			}

			$upload_dir		= \wp_upload_dir();
			$upload_file	= \wp_handle_upload($file, ['test_form' => false]);

			if (isset($upload_file['error']) && $upload_file['error'] !== false) {
				return new \WP_REST_Response(['message' => 'Upload error: ' . $upload_file['error']], 500);
			}

			$attachment_id = \wp_insert_attachment(
				[
					'guid'           => $upload_file['url'],
					'post_mime_type' => $upload_file['type'],
					'post_title'     => \sanitize_file_name($file['name']),
					'post_content'   => '',
					'post_status'    => 'inherit'
				],

				$upload_file['file']

			);

			if (\is_wp_error($attachment_id)) {
				return new \WP_REST_Response(['message' => 'Erro ao inserir na biblioteca de mídia.'], 500);
			}
        
			return new \WP_REST_Response(['url' => $upload_file['url']], 200);

		}
	}