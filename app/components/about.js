export function render(data) {

	const d = document;
	const titleEl = d.getElementById('about-title');
	const contentEl = d.getElementById('about-content');
	const imageEl = d.getElementById('about-image');

	if (titleEl) titleEl.textContent = data.title;
	if (contentEl) contentEl.innerHTML = data.content;

	if (imageEl) {
		if (data.image) {
			imageEl.src = data.image;
			imageEl.alt = data.title;
			imageEl.style.display = 'block';
		} else {
			imageEl.style.display = 'none';
		}
	}

}