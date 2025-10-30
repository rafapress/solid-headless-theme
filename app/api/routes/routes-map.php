<?php

	use app\api\controllers\AboutController;
	use app\api\controllers\ContactController;
	use app\api\controllers\BlogController;
	use app\api\controllers\HomeController;
	use app\api\controllers\ProductController;
	use app\api\controllers\TeamController;
	use app\api\theme_options\controllers\MediaUploadController;
	use app\api\theme_options\controllers\ThemeOptionsController;

	return [
		'about'															=> [AboutController::class, 'get'],
		'contact'														=> [ContactController::class, 'send', 'POST'],
		'blog'															=> [BlogController::class, 'list'],
		'home'															=> [HomeController::class, 'get'],
		'products'													=> [ProductController::class, 'list'],
		'product/details'										=> [ProductController::class, 'details'],
		'team'															=> [TeamController::class, 'list'],
		'theme_options'											=> [ThemeOptionsController::class, 'get'],
		'theme_options/save'								=> [ThemeOptionsController::class, 'save', 'POST'],
		'media/upload'											=> [MediaUploadController::class, 'upload', 'POST']
	];