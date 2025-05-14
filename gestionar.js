window.addEventListener('load', () => {
    

    // Contenidor on s'afegiran els botons
    const usuarisContainer = document.getElementById('usuaris-botons');
    const id_projecte = usuarisContainer.dataset.projecte; // Obtenir l'ID del projecte des del data attribute

    if (!usuarisContainer) {
        console.error('El contenidor #usuaris-botons no existeix.');
        return;
    }

    // Obtenir l'ID del projecte des de la URL
    // const params = new URLSearchParams(window.location.search);
    // const idProjecte = params.get('id_projecte');

    if (!id_projecte) {
        alert('No s\'ha proporcionat cap ID de projecte.');
        return;
    }
    // Crear el botó per esborrar el projecte
    const deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-danger m-2';
    deleteButton.textContent = 'Esborrar projecte';

    // Esdeveniment per gestionar el clic al botó d'esborrar projecte
    deleteButton.addEventListener('click', () => {
        if (!confirm('Estàs segur que vols esborrar aquest projecte? Aquesta acció no es pot desfer.')) {
            return;
        }

        // Cridar a l'API per esborrar el projecte
        fetch('api/esborrar_projecte.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_projecte=${id_projecte}`,
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    alert(response.message);
                    // Redirigir a la pàgina principal
                    window.location.href = 'index.php'; // Canvia això segons la teva estructura de rutes
                } else {
                    alert(`Error: ${response.message}`);
                }
            })
            .catch(err => {
                console.error('Error al esborrar el projecte:', err);
            });
    });

    // Afegir el botó d'esborrar projecte al contenidor
    usuarisContainer.appendChild(deleteButton);

    // Obtenir els usuaris del projecte des de l'API
    fetch(`api/obtenir_colaboradors.php?id_projecte=${id_projecte}`)
        .then(res => res.json())
        .then(usuaris => {
            if (usuaris.error) {
                alert(usuaris.error);
                return;
            }

            // Crear un botó per a cada usuari
            usuaris.forEach(usuari => {
                const button = document.createElement('button');
                button.className = 'btn btn-primary m-2';
                button.textContent = usuari.nom;
                button.dataset.idUsuari = usuari.id_usuari;

                // Contenidor per a les tasques del col·laborador
                const tasquesContainer = document.createElement('div');
                tasquesContainer.className = 'tasques-container mt-2';

                // Esdeveniment per gestionar el clic al botó del col·laborador
                button.addEventListener('click', () => {
                    console.log(`Botó clicat: ${usuari.nom}`);
                    const nomTasca = prompt(`Introdueix el nom de la tasca per a ${usuari.nom}:`);
                    if (!nomTasca) {
                        alert('El nom de la tasca no pot estar buit.');
                        return;
                    }

                    const idEstat = 1; // Exemple: 1 = "Pendent"
                    const descripcio = prompt('Introdueix una descripció per a la tasca:');
                    const idTipus = prompt('Introdueix el tipus de tasca (1 -> Frontend o 2 -> Backend ):');
                    const dataInici = prompt('Introdueix la data d\'inici (YYYY-MM-DD, opcional):');
                    const dataFi = prompt('Introdueix la data de fi (YYYY-MM-DD, opcional):');

                    // Cridar a l'API per crear la tasca
                    fetch('api/crear_tasca.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id_projecte=${id_projecte}&id_usuari=${usuari.id_usuari}&nom_tasca=${encodeURIComponent(nomTasca)}&id_estat=${idEstat}&descripcio=${encodeURIComponent(descripcio)}&id_tipus=${idTipus}&data_inici=${dataInici}&data_fi=${dataFi}`,
                    })
                        .then(res => res.json())
                        .then(response => {
                            if (response.success) {
                                alert(response.message);
                                // Tornar a carregar les tasques després de crear-ne una
                                carregarTasques(usuari.id_usuari, tasquesContainer, id_projecte);
                            } else {
                                alert(`Error: ${response.message}`);
                            }
                        })
                        .catch(err => {
                            console.error('Error al crear la tasca:', err);
                        });
                });

                // Afegir el botó i el contenidor de tasques al contenidor principal
                usuarisContainer.appendChild(button);
                usuarisContainer.appendChild(tasquesContainer);

                // Carregar les tasques inicialment
                carregarTasques(usuari.id_usuari, tasquesContainer, id_projecte);
            });
        })
        .catch(err => {
            console.error('Error al carregar els usuaris:', err);
        });
});


 // Funció per carregar les tasques d'un col·laborador i mostrar-les en targetes

function carregarTasques(idUsuari, tasquesContainer, id_projecte) {

    // Cridar a l'API per obtenir les tasques del col·laborador
    fetch(`api/seleccionar_tasques.php?id_usuari=${idUsuari}&id_projecte=${id_projecte}`)
        .then(res => res.json())
        .then(tasques => {
            console.log(`Tasques de l'usuari ${idUsuari}:`, tasques);

            // Netejar el contenidor de tasques abans d'afegir-ne de noves
            tasquesContainer.innerHTML = '';

            if (tasques.length === 0) {
                const noTasques = document.createElement('p');
                noTasques.textContent = 'Aquest col·laborador no té tasques assignades.';
                tasquesContainer.appendChild(noTasques);
            } else {
              
                tasques.forEach(usuari => {
                 if (!usuari || !Array.isArray(usuari.tasques)) return;

                usuari.tasques.forEach(tasca => {
                    if (!tasca) return;

                    const tascaCard = document.createElement('div');
                    tascaCard.className = 'card mb-2';
                    tascaCard.style = 'border: 1px solid #ccc; padding: 10px;';
                    tascaCard.innerHTML = `
                        <h5>${tasca.nom_tasca}</h5>
                        <p><strong>Descripció:</strong> ${tasca.descripcio ? tasca.descripcio : "Sense descripció"}</p>
                        <p><strong>Data inici:</strong> ${tasca.data_inici || 'No especificada'}</p>
                        <p><strong>Data fi:</strong> ${tasca.data_fi || 'No especificada'}</p>
                        <p><strong>Estat:</strong> ${tasca.estat || 'No especificat'}</p>
                    `;
                    tasquesContainer.appendChild(tascaCard);
                });
            });

            }
        })
        .catch(err => {
            console.error('Error al carregar les tasques:', err);
        });
}