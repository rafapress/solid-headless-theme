<?php

	namespace app\api\cpts;

	class CptLoader {

		public static function load(): void {

			$map = require __DIR__ . '/cpts-map.php';

	    foreach ($map as $cptFile) {
	      $path = __DIR__ . '/' . $cptFile . '.php';
	      if (file_exists($path)) {
	        require_once $path;
	      } else {
	        error_log("CptLoader: Arquivo não encontrado - $cptFile");
	      }

	    }

		}

	}
