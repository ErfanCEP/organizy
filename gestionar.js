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

    // Crear el botón para borrar el proyecto
    const deleteButton = document.createElement('button');
    deleteButton.className = 'btn btn-danger m-2';
    deleteButton.textContent = 'Esborrar projecte';

    // Evento para manejar el clic en el botón de borrar proyecto
    deleteButton.addEventListener('click', () => {
        if (!confirm('Estàs segur que vols esborrar aquest projecte? Aquesta acció no es pot desfer.')) {
            return;
        }

        // Llamar a la API para borrar el proyecto
        fetch('api/esborrar_projecte.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_projecte=${idProjecte}`,
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    alert(response.message);
                    // Redirigir al usuario a la página principal o actualizar la página
                    window.location.href = 'index.php'; // Cambia esto según tu estructura de rutas
                } else {
                    alert(`Error: ${response.message}`);
                }
            })
            .catch(err => {
                console.error('Error al esborrar el projecte:', err);
            });
    });

    // Agregar el botón de borrar proyecto al contenedor
    usuarisContainer.appendChild(deleteButton);

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