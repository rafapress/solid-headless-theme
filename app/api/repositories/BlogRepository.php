<?php

	namespace app\api\repositories;

	class BlogRepository {

		public function list(): ?array {

			return [
				'title'		=> 'Título do Artigo',
				'content'	=> 'Lorem Ipsum'
			];

		}

	}