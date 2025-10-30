<?php

	namespace app\api\services;

	use app\api\repositories\HomeRepository;

	class HomeService {

		protected HomeRepository $repository;

		public function __construct(HomeRepository $repository) {
			$this->repository = $repository;
		}

		public function get(): array {
			return $this->repository->get();
		}

	}