
export function renderProductDetails(product) {

	const container = document.createElement('div');

	container.className = 'product-details';
	container.innerHTML = `
	  <h2>${product.title}</h2>
	  <p>${product.description}</p>
	  <p><strong>Brand:</strong> ${product.brand}</p>
	  <p><strong>Price:</strong> R$ ${product.price}</p>
	  <p><strong>Stock:</strong> ${product.stock}</p>
	  <p><strong>SKU:</strong> ${product.sku || 'N/A'}</p>
	`;

	return container;

}

export async function fetchProductDetails(fetchFn, apiUrl, nonce) {

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

		console.log('initProductDetails running...');

		const pathParts = window.location.pathname.split('/').filter(Boolean);
		const slug = pathParts[pathParts.length - 1];

		if (!slug) {
			console.warn('Slug not found in URL');
			return;
		}

		const apiUrl		= `${window.HeadlessData.siteUrl}/wp-json/headless/v1/products/${slug}`;
		const product		= await fetchProductDetails(fetchFn, apiUrl, window.HeadlessData.nonce);
		const container	= document.getElementById('product-details');

		if (!container) {
			console.warn('Element #product-details not found');
			return;
		}

		container.innerHTML = '';
		container.appendChild(renderProductDetails(product));

	} catch (err) {
		console.error(err);
	}

}
