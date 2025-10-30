<?php

	namespace app\api\routes;

	class RouteLoader {

		protected string $namespace;
		protected array $routes;

		public function __construct(string $namespace, array $routes) {
			$this->namespace = $namespace;
			$this->routes = $routes;
		}

		public function register(): void {

			foreach ($this->routes as $endpoint => $handler) {

				$callback = [$handler[0], $handler[1]];
				$method   = isset($handler[2]) ? strtoupper($handler[2]) : 'GET';

				register_rest_route($this->namespace, '/' . $endpoint, [
					'methods'             => $method,
					'callback'            => $callback,
					'permission_callback' => '__return_true',
				]);

			}

		}
	}