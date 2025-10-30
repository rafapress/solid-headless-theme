<?php

	namespace app\api\services;

	use app\api\repositories\AboutRepository;

	class AboutService {

		private AboutRepository $repository;

		public function __construct(AboutRepository $repository) {
			$this->repository = $repository;
		}

		public function get(): array {
			return $this->repository->get();
		}

	}