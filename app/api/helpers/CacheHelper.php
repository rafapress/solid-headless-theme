<?php

	namespace app\api\helpers;

	class CacheHelper {

		private const LOG_PATH = '/log_cache.txt';

		public static function getOrSet(string $key, callable $callback, int $expiration = 3600) {

			$cached = get_transient($key);
			if ($cached !== false) return $cached;

			$data = $callback();
			if ($data !== null) set_transient($key, $data, $expiration);

			return $data;

		}

		public static function clearComponents(array $components): void {

			foreach ($components as $key) {

				$cache_key	= "{$key}_cache";
				$message		= delete_transient($cache_key)
					? "Cache '$cache_key' apagado com sucesso."
					: "Cache '$cache_key' não existia ou falhou ao apagar.";

				self::log($message);

			}

		}

		public static function delete(string $key): bool {
			return delete_transient($key);
		}

		public static function log(string $message): void {
			file_put_contents(get_template_directory() . self::LOG_PATH, $message . PHP_EOL, FILE_APPEND);
		}

	}