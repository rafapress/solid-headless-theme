export function render(data) {

	const fragment = document.createDocumentFragment();

	data.forEach(product => {
		const div = document.createElement('div');
		div.innerHTML = `
			<h3>${product.title}</h3>
		  ${product.short_description}<br>
		  <em>Marca:</em> ${product.brand} <br>
		  <em>Preço:</em> R$ ${product.price} <br>
		  <em>Estoque:</em> ${product.stock}
		`;
		fragment.appendChild(div);
	});

	return fragment;

}

// export function render(data) {

// 	const item = document.createElement('li');

// 	item.className = 'produto-item';
// 	item.innerHTML = `
// 		<strong>${data.title}</strong><br>
// 		${data.short_description}<br>
// 		<em>Marca:</em> ${data.brand} <br>
// 		<em>Preço:</em> R$ ${data.price} <br>
// 		<em>Estoque:</em> ${data.stock}
// 	`;

// 	return item;

// }

// export function renderProduct(product) {

// 	const item = document.createElement('li');

// 	item.className = 'produto-item';
// 	item.innerHTML = `
// 	  <strong>${product.title}</strong><br>
// 	  ${product.short_description}<br>
// 	  <em>Marca:</em> ${product.brand} <br>
// 	  <em>Preço:</em> R$ ${product.price} <br>
// 	  <em>Estoque:</em> ${product.stock}
// 	`;

// 	return item;

// }

// export async function fetchProducts(fetchFn, apiUrl, nonce) {

// 	const res = await fetchFn(apiUrl, {
// 		headers: { 'X-WP-Nonce': nonce }
// 	});

// 	if (!res.ok) {
// 		throw new Error(`Erro ao buscar produtos: ${res.status} ${res.statusText}`);
// 	}

// 	return res.json();

// }

// export async function init(fetchFn = fetch) {

// 	try {

// 		console.log('initProducts running...');

// 		const apiUrl		= `${window.HeadlessData.siteUrl}/wp-json/headless/v1/products`;
// 		const products	= await fetchProducts(fetchFn, apiUrl, window.HeadlessData.nonce);
// 		const list			= document.getElementById('products');

// 		if (!list) {
// 			console.warn('#products element not found');
// 			return;
// 		}

// 		list.innerHTML = '';

// 		products.forEach(product => {
// 			list.appendChild(renderProduct(product));
// 		});

// 	} catch (err) {
// 		console.error(err);
// 	}

// }