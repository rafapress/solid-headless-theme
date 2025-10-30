export function render(data) {

  const fragment = document.createDocumentFragment();

  data.forEach(member => {

		const card = document.createElement('div');
    card.classList.add('team-member');

    const name = document.createElement('h3');
    name.textContent = member.name;

    const position = document.createElement('p');
    position.textContent = member.position;

    const description = document.createElement('p');
    description.textContent = member.description;

    card.appendChild(name);
    card.appendChild(position);
    card.appendChild(description);

    // Se tiver imagem:
    if (member.image) {
      const img = document.createElement('img');
      img.src = member.image;
      img.alt = member.name;
      card.appendChild(img);
    }

    fragment.appendChild(card);

  });

  return fragment;

}