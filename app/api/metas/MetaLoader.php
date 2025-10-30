<?php

	namespace app\api\metas;

	class MetaLoader {

		public static function load(): void {

			$map = require __DIR__ . '/metas-map.php';

			foreach ($map as $metaFile) {

				$path = __DIR__ . '/' . $metaFile . '.php';
				if (file_exists($path)) {
					require_once $path;
				} else {
					error_log("MetaLoader: File not found - $metaFile");
				}

			}
		}

	}