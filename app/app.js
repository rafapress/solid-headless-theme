const template = document.body.dataset.template || 'default';

async function init(fetchFn, moduleName, renderContent) {

	try {

		const apiUrl = `${window.HeadlessData.siteUrl}/wp-json/headless/v1/${moduleName}/`;
		const res = await fetchFn(apiUrl, {
			headers: { 'X-WP-Nonce': window.HeadlessData.nonce }
		});

		if (!res.ok) throw new Error(`Failed to fetch: ${res.status} ${res.statusText}`);

		const data = await res.json();
		const container = document.getElementById(`${moduleName}-container`);

		if (container) {
			container.innerHTML = '';
			const content = renderContent(data);
			if (content instanceof Node) {
				container.appendChild(content);
			}
			return;
		}

		renderContent(data);

	} catch (err) {
		console.error(err);
	}

}

(async () => {

	const components = window.HeadlessData?.components || [];

	if (components.includes(template)) {

		try {

			const module = await import(`./components/${template}.js`);

			if (module.render && typeof module.render === 'function') {

				if (template === 'contact') {

					const container = document.getElementById(`${template}-container`);
				  if (container) {

						container.innerHTML = '';
						const content = module.render();

						if (content instanceof Node) {
							container.appendChild(content);
						}

				  }

					console.log(`Renderizando componente especial: ${template}`);

				} else {
					await init(fetch, template, module.render);
					console.log(`Executando init() do componente: ${template}`);
				}

			} else {
				console.warn(`O componente ${template} não exporta uma função render()`);
			}

		} catch (error) {
			console.error(`Erro ao importar o componente ${template}:`, error);
		}

	} else {
		console.log(`Nenhum componente JS disponível para template: ${template}`);
	}

})();

export function apiFetch(endpoint = '', options = {}) {

	const baseUrl = `${window.HeadlessData.siteUrl}/wp-json/headless/v1/`;

	console.log(baseUrl);

	return fetch(baseUrl + endpoint, {
		headers: {
			'X-WP-Nonce': window.HeadlessData.nonce,
			'X-Site-Lang': getCookie('site_lang') || 'portuguese',
			...(options.headers || {}),
		},
		credentials: 'same-origin',
		...options,
	});

}