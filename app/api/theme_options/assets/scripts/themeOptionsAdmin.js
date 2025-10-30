document.addEventListener('DOMContentLoaded', function() {

	const form = document.getElementById('theme-options-form');
	const uploadInput = document.getElementById('upload_fullbanner_input');
	const fullbannerUrlField = document.getElementById('fullbanner_url');
	const fullbannerPreview = document.getElementById('fullbanner_preview');

  // Lida com o envio do formulário
	if (form) {

		form.addEventListener('submit', function(e) {

			e.preventDefault();
            
			const formData = new FormData(form);
			const dataToSave = Object.fromEntries(formData.entries());

			fetch(`${appData.apiRoot}theme_options/save`, {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-WP-Nonce': appData.nonce
				},
				body: JSON.stringify(dataToSave)
			})
			.then(response => response.json())
			.then(result => {
				alert(result.message);
			})
			.catch(error => console.error('Erro ao salvar as opções:', error));
		});
	}

  // Lida com o upload do arquivo
	if (uploadInput) {

		uploadInput.addEventListener('change', function(e) {

			const file = e.target.files[0];
			if (!file) return;

			const formData = new FormData();
			formData.append('file', file);
			formData.append('_wpnonce', appData.nonce); // Adiciona o nonce

			fetch(`${appData.apiRoot}media/upload`, {
				method: 'POST',
				body: formData
			})
			.then(response => {
				if (!response.ok) {
					throw new Error('Erro na resposta da API.');
				}
				return response.json();
			})
			.then(result => {
				if (result.url) {
					// Atualiza o campo escondido com a URL e a pré-visualização
					fullbannerUrlField.value = result.url;
					fullbannerPreview.innerHTML = `<img src="${result.url}" style="max-width: 200px;">`;
				}
			})
			.catch(error => {
				console.error('Erro ao fazer upload:', error);
				alert('Erro ao fazer upload da imagem.');
			});
		});
	}
});