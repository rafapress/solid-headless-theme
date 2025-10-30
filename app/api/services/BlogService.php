<?php

	namespace app\api\services;

	use app\api\repositories\BlogRepository;

	class BlogService {

		private BlogRepository $repository;

		public function __construct(BlogRepository $repository) {
			$this->repository = $repository;
		}

		public function list(): array {
			return $this->repository->list();
		}

	}