
window.addEventListener('load', () => {
    fetch('api/seleccionar_projectes.php')
        .then(function (resposta) {
            return resposta.json()
        })
        .then(function (projectes) {
            const cardContainer = document.querySelector('#card');
            for (const projecte of projectes) {

                // createTd(tr, projecte.nom)
                // createTd(tr, projecte.descripcio)

                // Crear la tarjeta
                const card = document.createElement('div');
                card.className = 'card d-flex justify-content-center align-items-center text-center';
                card.style.width = '18rem';

                // Crear el cuerpo de la tarjeta
                const cardBody = document.createElement('div');
                cardBody.className = 'card-body';

                // Crear el título de la tarjeta
                const cardTitle = document.createElement('h5');
                cardTitle.className = 'card-title';
                cardTitle.textContent = projecte.nom; 

                // Crear el texto de la tarjeta
                const cardText = document.createElement('p');
                cardText.className = 'card-text';
                cardText.textContent = projecte.descripcio;

                // Crear el botón de la tarjeta
                const cardButton = document.createElement('a');
                cardButton.className = 'btn btn-warning';
                cardButton.href = '#';
                cardButton.textContent = 'Editar projecte';

                // Agregar los elementos al cuerpo de la tarjeta
                cardBody.appendChild(cardTitle);
                cardBody.appendChild(cardText);
                cardBody.appendChild(cardButton);

                // Agregar el cuerpo a la tarjeta
                card.appendChild(cardBody);

                // Agregar la tarjeta al contenedor principal
                cardContainer.appendChild(card);

            }

        })
        .catch((e) => {
            console.log("ERROR:" + e);
        });
});
