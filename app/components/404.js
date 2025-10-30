	export function renderAbout(about) {

		const container = document.createElement('div');

		container.className = 'about';
		container.innerHTML = `Lorem Ipsum`;

		return container;

	}

	export async function fetchAbout(fetchFn, apiUrl, nonce) {

		const res = await fetchFn(apiUrl, {
			headers: { 'X-WP-Nonce': nonce }
		});

		if (!res.ok) {
			throw new Error(`Failed to fetch product: ${res.status} ${res.statusText}`);
		}

		return res.json();

	}

	export async function init(fetchFn = fetch) {

		try {

			console.log('initAbout running...');

			const apiUrl		= `${window.HeadlessData.siteUrl}/wp-json/headless/v1/about/`;
			const about			= await fetchAbout(fetchFn, apiUrl, window.HeadlessData.nonce);
			const container	= document.getElementById('about');

			if (!container) {
				console.warn('Element #about not found');
				return;
			}

			container.innerHTML = '';
			container.appendChild(renderAbout(about));

		} catch (err) {
			console.error(err);
		}

	}
