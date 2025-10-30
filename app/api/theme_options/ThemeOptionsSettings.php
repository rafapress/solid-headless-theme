<?php

	namespace app\api\theme_options;

	use app\api\theme_options\ThemeOptionsPage;

	class ThemeOptionsSettings {

		public static function init(): void {
			new ThemeOptionsPage();
		}

	}