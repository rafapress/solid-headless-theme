<?php

	namespace app\api\theme_options\services;

	use app\api\theme_options\repositories\ThemeOptionsRepository;

	class ThemeOptionsService {

		private ThemeOptionsRepository $repository;

    public function __construct(ThemeOptionsRepository $repository) {
			$this->repository = $repository;
    }

    public function get(): array {
			return $this->repository->get();
    }

    public function save(array $data): void {
			// Chama a sanitização antes de salvar os dados.
			$sanitizedData = $this->sanitize($data);
			$this->repository->update($sanitizedData);
    }

    private function sanitize(array $data): array {

			$sanitized = [];

			// Campos da Aba Home
			if (isset($data['fullbanner_url'])) {
				$sanitized['fullbanner_url'] = esc_url_raw($data['fullbanner_url']);
			}
			if (isset($data['titulo_slogan'])) {
				$sanitized['titulo_slogan'] = sanitize_text_field($data['titulo_slogan']);
			}
			if (isset($data['texto_slogan'])) {
				$sanitized['texto_slogan'] = sanitize_textarea_field($data['texto_slogan']);
			}

			// Campos da Aba Rodapé
			if (isset($data['facebook_link'])) {
				$sanitized['facebook_link'] = esc_url_raw($data['facebook_link']);
			}
			if (isset($data['instagram_link'])) {
				$sanitized['instagram_link'] = esc_url_raw($data['instagram_link']);
			}
			if (isset($data['linkedin_link'])) {
				$sanitized['linkedin_link'] = esc_url_raw($data['linkedin_link']);
			}
			if (isset($data['whatsapp_number'])) {
				// Sanitiza o número do WhatsApp (remover caracteres não numéricos)
				$sanitized['whatsapp_number'] = preg_replace('/[^0-9]/', '', $data['whatsapp_number']);
			}

      return $sanitized;

		}
	}