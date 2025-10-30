<?php

	namespace app\api\repositories;

	class LanguagesRepository {

		protected string $translationsPath;

		public function __construct(string $translationsPath) {
			$this->translationsPath = rtrim($translationsPath, '/');
		}

		public function getTranslations(string $lang): array {

			$file = "{$this->translationsPath}/{$lang}.json";

			if (!file_exists($file)) return [];

			$content = file_get_contents($file);
			$translations = json_decode($content, true);

			return is_array($translations) ? $translations : [];

		}

		public function getAvailableLanguages(): array {

			$files = glob("{$this->translationsPath}/*.json");
			$langs = [];

			foreach ($files as $file) {
				$basename = basename($file, '.json');
				$langs[$basename] = ucfirst($basename);
			}
			return $langs;
		}

	}