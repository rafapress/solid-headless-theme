<?php

get_header();

if (have_posts()) :
	while (have_posts()) : the_post();
		the_content();
	endwhile;
else :
	echo "<p>Nenhum conteúdo encontrado.</p>";
endif;

get_footer();
