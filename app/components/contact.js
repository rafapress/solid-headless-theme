import { apiFetch } from '../app.js';

export function render() {
  const form = document.createElement('form');
  form.id = 'contact-form';

  form.innerHTML = `
    <input type="text" name="name" placeholder="Seu nome" required />
    <input type="email" name="email" placeholder="Seu e-mail" required />
    <textarea name="message" placeholder="Mensagem" required></textarea>
    <button type="submit">Enviar</button>
    <div class="response-message"></div>
  `;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(form));

    try {
      const res = await apiFetch('contact', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });

      if (!res.ok) throw new Error('Erro ao enviar formulário');

      alert('Mensagem enviada com sucesso!');
      form.reset();
    } catch (error) {
      console.error(error);
      alert('Erro ao enviar mensagem.');
    }
  });

  return form;
}
