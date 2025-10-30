<?php

	namespace app\config\smtp;

	class SmtpSettingsPage {

		private SmtpSettingsService $service;
		private string $pageSlug = 'smtp-settings';

		public function __construct(SmtpSettingsService $service) {
			$this->service = $service;
		}

		public function register(): void {
			add_action('admin_menu', [$this, 'addMenu']);
			add_action('admin_init', [$this, 'registerSettings']);
		}

		public function addMenu(): void {
			add_options_page(
				'Configurações de SMTP',
				'Configurações de SMTP',
				'manage_options',
				$this->pageSlug,
				[$this, 'renderPage']
			);
		}

		public function registerSettings(): void {

			register_setting('smtp_settings_group', 'smtp_settings', [
				'sanitize_callback' => [$this, 'sanitize']
			]);

			add_settings_section(
				'smtp_main_section',
				'',
				fn() => print '<p>Configure os dados de envio SMTP abaixo.</p>',
				$this->pageSlug
			);

			$fields = [
				'host'			=> 'Servidor SMTP (host)',
				'port'			=> 'Porta',
				'smtpAuth'	=> 'SMTP Auth (true/false)',
				'username'	=> 'Usuário',
				'password'	=> 'Senha',
				'from'			=> 'Remetente (from)',
				'fromName'	=> 'Nome do remetente',
				'replyTo'		=> 'E-mail de resposta (reply-to)'
			];

			foreach ($fields as $name => $label) {
				add_settings_field(
					$name,
					$label,
					fn() => $this->renderField($name),
					$this->pageSlug,
					'smtp_main_section'
				);
			}

		}

		public function sanitize($input): array {

			$output = [];

			foreach ($input as $key => $value) {
				if ($key === 'port') {
					$output[$key] = intval($value);
				} elseif (in_array($key, ['host', 'smtpAuth', 'username', 'password', 'from', 'fromName', 'replyTo'])) {
					$output[$key] = sanitize_text_field($value);
				}
			}

			return $output;

		}

		public function renderPage(): void {

	?>
		<div class="wrap">
			<h1>Configurações de SMTP</h1>
			<form method="post" action="options.php">
			<?php
				settings_fields('smtp_settings_group');
				do_settings_sections($this->pageSlug);
				submit_button();
			?>
			</form>
		</div>
	<?php

		}

		private function renderField(string $name): void {

			$settings = $this->service->get();
			$value = $settings[$name] ?? '';
			$type = $name === 'password' ? 'password' : 'text';
			echo "<input type='{$type}' name='smtp_settings[{$name}]' value='" . esc_attr($value) . "' class='regular-text'>";

		}

	}