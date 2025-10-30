<?php

	namespace app\api\services;

	use app\api\repositories\TeamRepository;

	class TeamService {

		private TeamRepository $repository;

		public function __construct(TeamRepository $repository) {
			$this->repository = $repository;
		}

		public function list(): array {
			return $this->repository->list();
		}

	}