<!DOCTYPE html>
<html>
<head>
	<?php wp_head(); ?>
</head>

<?php
	$template_slug	= basename(get_page_template(), '.php');
	$template				= str_replace('page-', '', $template_slug);
?>

<body <?php body_class(); ?> data-template="<?= esc_attr($template ?: 'default'); ?>">

