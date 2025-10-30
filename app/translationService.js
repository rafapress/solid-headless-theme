import { apiFetch } from './app.js';

const TranslationService = (() => {

	let translations = {};
	let loaded = false;
	let currentLang = 'portuguese';
	let availableLanguages = {};

	function getCookie(name) {

		const value = `; ${document.cookie}`;
		const parts = value.split(`; ${name}=`);

		if (parts.length === 2) return parts.pop().split(';').shift();

		return null;

	}

async function load(force = false) {

	const langFromCookie = getCookie('site_lang') || 'portuguese';

	// Se o idioma mudou, revalide
	if (!force && loaded && langFromCookie === currentLang) return;

	currentLang = langFromCookie;

  loaded = false; // forçar recarregamento
  currentLang = getCookie('site_lang') || 'portuguese';
  console.log('TranslationService.load: currentLang =', currentLang);

		if (loaded) return;

		currentLang = getCookie('site_lang') || 'portuguese';

		try {

			const res = await fetch(`${HeadlessData.siteUrl}/wp-json/headless/v1/languages`, {
				headers: {
					'X-WP-Nonce': HeadlessData.nonce,
					'X-Site-Lang': currentLang
				}
			});

			const data = await res.json();

			translations = data.translations || {};
			availableLanguages = data.availableLanguages || {};
			loaded = true;

		} catch (err) {
			console.error('TranslationService: Failed to load', err);
		}

	}

	function getPhrase(key) {
		return translations[key] || key;
	}

	function getCurrentLang() {
		return currentLang;
	}

	function getAvailableLanguages() {
		return availableLanguages;
	}

	return {
		load,
		getPhrase,
		getCurrentLang,
		getAvailableLanguages
	};
})();

export default TranslationService;