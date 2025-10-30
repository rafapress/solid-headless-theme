<?php

	namespace app\api\theme_options;

	use app\api\theme_options\services\ThemeOptionsService;
	use app\api\theme_options\repositories\ThemeOptionsRepository;
	use WP_REST_Request;
	use WP_REST_Response;

	class ThemeOptionsPage {

		public function __construct() {
			add_action('admin_menu', [$this, 'addThemeOptionsPage']);
			add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
		}

		public function addThemeOptionsPage(): void {
			add_theme_page(
				'Opções do Tema',
				'Opções do Tema',
				'manage_options',
				'theme-options',
				[$this, 'renderPage']
			);
		}

		public function renderPage(): void {

			$service = new ThemeOptionsService(new ThemeOptionsRepository());
			$options = $service->get();
			$active_tab = $_GET['tab'] ?? 'home';

			$fullbanner_url 	= esc_attr($options['fullbanner_url'] ?? '');
			$titulo_slogan 		= esc_attr($options['titulo_slogan'] ?? '');
			$texto_slogan 		= esc_textarea($options['texto_slogan'] ?? '');
			$facebook_link 		= esc_attr($options['facebook_link'] ?? '');
			$instagram_link 	= esc_attr($options['instagram_link'] ?? '');
			$linkedin_link 		= esc_attr($options['linkedin_link'] ?? '');
			$whatsapp_number	= esc_attr($options['whatsapp_number'] ?? '');

?>

<div class="wrap">

	<h1>Opções do Tema</h1>

	<h2 class="nav-tab-wrapper">
		<a href="?page=theme-options&tab=home" class="nav-tab <?= $active_tab == 'home' ? 'nav-tab-active' : ''; ?>">Home</a>
		<a href="?page=theme-options&tab=footer" class="nav-tab <?= $active_tab == 'footer' ? 'nav-tab-active' : ''; ?>">Rodapé</a>
	</h2>

	<form id="theme-options-form">

		<?php wp_nonce_field('wp_rest', 'theme_options_nonce'); ?>
		<input type="hidden" name="active_tab" value="<?= esc_attr($active_tab); ?>" />

		<?php if ($active_tab == 'home'): ?>

			<h3>Aba Home</h3>

			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">Fullbanner</th>
						<td>
							<input type="hidden" name="fullbanner_url" id="fullbanner_url" value="<?= $fullbanner_url; ?>" />
							<input type="file" id="upload_fullbanner_input" />
							<div id="fullbanner_preview" style="margin-top: 10px;">
								<?php if ($fullbanner_url): ?>
									<img src="<?= $fullbanner_url; ?>" style="max-width: 200px;">
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="titulo_slogan">Título Slogan</label></th>
						<td><input type="text" name="titulo_slogan" id="titulo_slogan" value="<?= $titulo_slogan; ?>" class="regular-text" /></td>
					</tr>
					<tr>
						<th scope="row"><label for="texto_slogan">Texto Slogan</label></th>
						<td><textarea name="texto_slogan" id="texto_slogan" rows="5" class="large-text"><?= $texto_slogan; ?></textarea></td>
					</tr>
				</tbody>
			</table>

		<?php elseif ($active_tab == 'footer'): ?>

			<h3>Aba Rodapé</h3>

			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="facebook_link">Link do Facebook</label></th>
						<td><input type="text" name="facebook_link" id="facebook_link" value="<?= $facebook_link; ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="instagram_link">Link do Instagram</label></th>
						<td><input type="text" name="instagram_link" id="instagram_link" value="<?= $instagram_link; ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="linkedin_link">Link do LinkedIn</label></th>
						<td><input type="text" name="linkedin_link" id="linkedin_link" value="<?= $linkedin_link; ?>" class="regular-text"></td>
					</tr>
					<tr>
						<th scope="row"><label for="whatsapp_number">Número do WhatsApp</label></th>
						<td><input type="text" name="whatsapp_number" id="whatsapp_number" value="<?= $whatsapp_number; ?>" class="regular-text"></td>
					</tr>
				</tbody>
			</table>

		<?php
			endif;
			submit_button('Salvar');
		?>
	</form>
</div>
<?php
	}

	public function enqueueScripts(string $hook): void {

		if ('appearance_page_theme-options' != $hook) return;

		wp_enqueue_script(
			'theme-options-admin-scripts',
			get_template_directory_uri() . '/app/api/theme_options/assets/scripts/themeOptionsAdmin.js',
			['wp-api'],
			null,
			true
		);
        
		wp_localize_script('theme-options-admin-scripts', 'appData', [
			'nonce' => wp_create_nonce('wp_rest'),
			'apiRoot' => rest_url('headless/v1/'),
		]);
	}

}