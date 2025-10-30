<?php

	namespace app\config\smtp;

	class SmtpSettings {

		public static function init(): void {

			require_once __DIR__ . '/SmtpSettingsRepository.php';
			require_once __DIR__ . '/SmtpSettingsService.php';
			require_once __DIR__ . '/SmtpSettingsPage.php';

			$repository = new SmtpSettingsRepository();
			$service = new SmtpSettingsService($repository);
			$page = new SmtpSettingsPage($service);
			$page->register();

		}

	}