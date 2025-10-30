export async function render(data) {

	const title = document.getElementById('title');
	const content = document.getElementById('content');

  if (title) title.innerHTML = data.title;
  if (content) content.innerHTML = data.content;

}