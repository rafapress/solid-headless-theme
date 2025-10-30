export function render(data) {

	const d = document;
	const title = d.getElementById('title');
	const content = d.getElementById('content');

	if (title) title.textContent = data.title;
	if (content) content.innerHTML = data.content;

}