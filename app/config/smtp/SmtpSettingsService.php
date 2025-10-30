<?php

	namespace app\config\smtp;

	class SmtpSettingsService {

		private SmtpSettingsRepository $repository;

		public function __construct(SmtpSettingsRepository $repository) {
			$this->repository = $repository;
		}

    public function save(array $data): bool {

			if (!filter_var($data['from'] ?? '', FILTER_VALIDATE_EMAIL)) {
				throw new \InvalidArgumentException('E-mail "from" inválido.');
			}

			return $this->repository->save($data);

		}

		public function get(): array {
			return $this->repository->get();
		}

	}
