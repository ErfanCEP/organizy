window.addEventListener('load', () => {
    // Obtener el ID del proyecto desde la URL
    const params = new URLSearchParams(window.location.search);
    const idProjecte = params.get('id_projecte');

    if (!idProjecte) {
        alert('No s\'ha proporcionat cap ID de projecte.');
        return;
    }

    // Contenedor donde se agregarán los botones
    const usuarisContainer = document.getElementById('usuaris-botons');

    // Obtener los usuarios del proyecto desde la API
    fetch(`api/obtenir_colaboradors.php?id_projecte=${idProjecte}`)
        .then(res => res.json())
        .then(usuaris => {
            if (usuaris.error) {
                alert(usuaris.error);
                return;
            }

            // Crear un botón para cada usuario
            usuaris.forEach(usuari => {
                const button = document.createElement('button');
                button.className = 'btn btn-primary m-2';
                button.textContent = usuari.nom;
                button.dataset.idUsuari = usuari.id_usuari;

                // Agregar el botón al contenedor
                usuarisContainer.appendChild(button);
            });
        })
        .catch(err => {
            console.error('Error al carregar els usuaris:', err);
        });
});