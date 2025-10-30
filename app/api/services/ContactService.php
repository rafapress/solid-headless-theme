<?php

	namespace app\api\services;

	use app\api\repositories\ContactRepository;

	class ContactService {

		private ContactRepository $repository;

		public function __construct(ContactRepository $repository) {
			$this->repository = $repository;
		}

		public function send(array $data): array {

			require_once get_template_directory() . '/app/libs/PHPMailer/PHPMailerAutoload.php';
			require_once get_template_directory() . '/app/libs/PHPMailer/class.phpmailer.php';
			require_once get_template_directory() . '/app/libs/PHPMailer/class.smtp.php';

			$name			= sanitize_text_field($data['name'] ?? '');
			$email		= sanitize_email($data['email'] ?? '');
			$message	= sanitize_textarea_field($data['message'] ?? '');

			if (!$name || !$email || !$message) {
				return [
					'success'	=> false,
					'message'	=> 'Campos obrigatórios faltando.'
				];
			}

			$config = $this->repository->getMailConfig();

			// echo '<pre>' . print_r($config, true) . '</pre>';

			if (!$config) {
				return [
					'success' => false,
					'message' => 'Configurações de e-mail ausentes.'
				];
			}

			$mail = new \PHPMailer();

			$mail->isSMTP();
			$mail->SMTPDebug		= 0;
			$mail->Host					= $config['host'];
			$mail->Port					= $config['port'];
			$mail->SMTPAuth			= $config['smtpAuth'];
			$mail->Username			= $config['username'];
			$mail->Password			= $config['password'];
			$mail->SMTPSecure		= 'tls';

			$mail->setFrom($config['from'], $config['fromName']);
			$mail->addReplyTo($config['replyTo'] ?: $email, $name);
			$mail->addAddress($config['from'], $config['fromName']);

			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8';
			$mail->Subject = 'Contato via website';
			$mail->MsgHTML($this->buildMessage($name, $email, $message));

			$response = [
				'success'	=> true,
				'message'	=> 'Mensagem enviada com sucesso.'
			];

			if (!$mail->send()) {

				$response = [
					'success'	=> false,
					'message'	=> 'Erro ao enviar e-mail.',
					'debug'		=> $mail->ErrorInfo
				];

			}

			return $response;

		}

		private function buildMessage(string $name, string $email, string $message): string {

			return '
				<p><strong>Nome:</strong> ' . esc_html($name) . '</p>
				<p><strong>E-mail:</strong> ' . esc_html($email) . '</p>
				<p><strong>Mensagem:</strong><br>' . nl2br(esc_html($message)) . '</p>
				<hr>
				<p>Enviado via website <strong>hausti.app</strong></p>
			';

		}

	}
