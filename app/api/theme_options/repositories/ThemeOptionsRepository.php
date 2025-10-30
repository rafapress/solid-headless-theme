<?php

	namespace app\api\theme_options\repositories;

	class ThemeOptionsRepository {

		// Use uma constante para a chave da opção. Isso garante que ela seja a mesma em get e update.
		private const OPTIONS_KEY = 'solid_theme_options'; // <--- CHAVE CORRIGIDA E CONSISTENTE

		public function get(): array {
			// Use a constante para obter a opção.
			return get_option(self::OPTIONS_KEY, []);
		}

		public function update(array $options): void {
			// Use a constante para atualizar a opção.
			update_option(self::OPTIONS_KEY, $options);
		}

	}