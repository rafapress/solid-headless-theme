<?php

	namespace app\api\services;

	use app\api\repositories\LanguagesRepository;

	class LanguageService {

		protected LanguagesRepository $repository;

		public function __construct(LanguagesRepository $repository) {
			$this->repository = $repository;
		}

		public function getTranslations(string $lang): array {
			return $this->repository->getTranslations($lang);
		}

		public function getAvailableLanguages(): array {
			return $this->repository->getAvailableLanguages();
		}

	}