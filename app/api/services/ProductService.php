<?php

	namespace app\api\services;

	use app\api\repositories\ProductRepository;

	class ProductService {

		private ProductRepository $repository;

		public function __construct(ProductRepository $repository) {
			$this->repository = $repository;
		}

		public function list(): array {
			return $this->repository->list();
		}

		public function details(string $slug): ?array {
			return $this->repository->details($slug);
		}

	}