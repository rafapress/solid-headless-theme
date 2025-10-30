<?php

	namespace app\config;

	require_once __DIR__ . '/../rest/autoload.php';

	use app\api\metas\MetaLoader;
	use app\api\cpts\CptLoader;
	use app\api\theme_options\ThemeOptionsSettings; 
	use app\config\smtp\SmtpSettings;

	class Bootstrap {

		public static function init(): void {

			MetaLoader::load();
			CptLoader::load();

			ThemeOptionsSettings::init();
			SmtpSettings::init();

		}
	}

	Bootstrap::init();