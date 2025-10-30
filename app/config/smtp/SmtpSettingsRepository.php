<?php

	namespace app\config\smtp;

	class SmtpSettingsRepository {

		private string $optionName = 'smtp_settings';

		public function save(array $data): bool {
			return update_option($this->optionName, $data);
		}

		public function get(): array {
			return get_option($this->optionName, []);
		}

	}