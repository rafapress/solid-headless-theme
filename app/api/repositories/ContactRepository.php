<?php

	namespace app\api\repositories;

	class ContactRepository {

		public function getMailConfig(): ?array {

			$config = get_option('smtp_settings');

			if (empty($config) || !is_array($config)) {
				return null;
			}

			return [
				'host'      => trim($config['host'] ?? ''),
				'port'      => (int) ($config['port'] ?? 587),
				'smtpAuth'  => filter_var($config['smtpAuth'] ?? false, FILTER_VALIDATE_BOOLEAN),
				'username'  => trim($config['username'] ?? ''),
				'password'  => trim($config['password'] ?? ''),
				'from'      => trim($config['from'] ?? ''),
				'fromName'  => trim($config['fromName'] ?? ''),
				'replyTo'   => trim($config['replyTo'] ?? '')
			];

		}

	}