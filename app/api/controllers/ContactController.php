<?php

	// namespace app\api\controllers;

	// use app\api\services\ContactService;
	// use app\api\repositories\ContactRepository;

	// class ContactController {

	namespace app\api\controllers;

	use app\api\services\ContactService;
	use app\api\repositories\ContactRepository;
	use WP_REST_Request;
	use WP_REST_Response;

	class ContactController {

		public static function send(WP_REST_Request $request): WP_REST_Response {

			$data = $request->get_json_params();

			var_dump($data);

			$service = new ContactService(new ContactRepository());
			$response = $service->send($data);

			return new \WP_REST_Response([
				'message' => 'Resultado do envio',
				'resultado' => $response
			]);

			// $data = $request->get_json_params();

			// // DEBUG: log para o servidor
			// error_log('[ContactController] Dados recebidos: ' . print_r($data, true));

			// $service = new ContactService(new ContactRepository());
			// $response = $service->send($data);

			// return new \WP_REST_Response([
			// 	'message' => 'Resultado do envio',
			// 	'resultado' => $response
			// ]);

		}
	}

		// public static function send(\WP_REST_Request $request) {

    // $params = $request->get_json_params();

    // $name = sanitize_text_field($params['name'] ?? '');
    // $email = sanitize_email($params['email'] ?? '');
    // $message = sanitize_textarea_field($params['message'] ?? '');

    // if (!$name || !$email || !$message) {
    //     return new \WP_REST_Response(['message' => 'Todos os campos são obrigatórios.'], 400);
    // }

    // // Exemplo: enviar email (simplificado)
    // $to = get_option('admin_email');
    // $subject = "Contato do site: $name";
    // $body = "Nome: $name\nEmail: $email\nMensagem:\n$message";
    // $headers = ['Content-Type: text/plain; charset=UTF-8'];

    // $sent = wp_mail($to, $subject, $body, $headers);

    // if (!$sent) {
    //     return new \WP_REST_Response(['message' => 'Falha ao enviar e-mail.'], 500);
    // }

			// if (!wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'] ?? '', 'wp_rest')) {
			// 	return new \WP_REST_Response(['message' => 'Unauthorized'], 403);
			// }

			// return new \WP_REST_Response(['message' => 'Teste']);

			// $data = $request->get_json_params();

			// return $data;

			// var_dump($data);			

			// $service	= new ContactService(new ContactRepository());
			// $response = $service->send($data);

			// return new \WP_REST_Response(['message' => 'Mensagem enviada com sucesso!']);

	// 	}

	// }