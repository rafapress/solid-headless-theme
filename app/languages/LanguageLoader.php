<?php

	namespace app\languages;

	class LanguageLoader {

		private static $languages = [];

		public static function load(): void {

			$mapFile = __DIR__ . '/languages-map.php';

			if (!file_exists($mapFile)) {
				error_log("LanguageLoader: File not found - languages-map.php");
				return;
			}

			$map = require $mapFile;

			if (!is_array($map)) {
				error_log("LanguageLoader: languages-map.php must return an array");
				return;
			}

			foreach ($map as $languageFile) {

				$path = __DIR__ . '/' . $languageFile . '.php';

				if (file_exists($path)) {

					$translations = require $path;

					if (is_array($translations)) {
						self::$languages[$languageFile] = $translations;
					} else {
						error_log("LanguageLoader: File $languageFile.php must return an array");
					}

				} else {
					error_log("LanguageLoader: File not found - $languageFile.php");
				}
			}
		}

		public static function getTranslations(string $lang): array {
			if (empty(self::$languages)) {
				self::load();
			}
			return self::$languages[$lang] ?? [];
		}

		public static function getAvailableLanguages(): array {
			if (empty(self::$languages)) {
				self::load();
			}
			return array_keys(self::$languages);
		}

		public static function isValidLanguage(string $lang): bool {
			if (empty(self::$languages)) {
				self::load();
			}
			return array_key_exists($lang, self::$languages);
		}
	}