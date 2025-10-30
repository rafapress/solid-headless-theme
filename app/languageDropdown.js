import TranslationService from './translationService.js';

function renderLanguageDropdown(containerId = 'header-language-container') {

	const container = document.getElementById(containerId);
	if (!container) return;

	const languages = TranslationService.getAvailableLanguages();
	const currentLang = TranslationService.getCurrentLang();

	const select = document.createElement('select');
	select.id = 'select-language';

	for (const [slug, label] of Object.entries(languages)) {

		const option = document.createElement('option');

		option.value = slug;
		option.textContent = label;

		if (slug === currentLang) option.selected = true;
		select.appendChild(option);

	}

	select.addEventListener('change', () => {
		document.cookie = `site_lang=${select.value}; path=/; max-age=${60 * 60 * 24 * 30}`;
		location.reload();
	});

	container.appendChild(select);

}

export default renderLanguageDropdown;