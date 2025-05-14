// Función para manejar el evento de añadir colaborador
function afegirColaborador(cardBody, idProjecte) {
    // Verificar si el select ya existe
    if (cardBody.querySelector('.select-container')) {
        console.log('El select ya existe.');
        return; // Salir si ya existe
    }

    // Crear el contenedor del select
    const selectContainer = document.createElement('div');
    selectContainer.className = 'select-container mt-2'; // Clase única para identificar el contenedor

    // Crear el select
    const select = document.createElement('select');
    select.className = 'form-select';
    select.innerHTML = '<option value="">Selecciona un col·laborador</option>';

    // Crear el botón para añadir colaborador (inicialmente oculto)
    const addButton = document.createElement('button');
    addButton.className = 'btn btn-primary mt-2';
    addButton.textContent = 'Afegir al projecte';
    addButton.style.display = 'none'; // Ocultar el botón inicialmente

    // Evento para mostrar el botón cuando se selecciona un colaborador
    select.addEventListener('change', () => {
        if (select.value) {
            addButton.style.display = 'block'; // Mostrar el botón si se selecciona un colaborador
        } else {
            addButton.style.display = 'none'; // Ocultar el botón si no hay selección
        }
    });

    // Obtener colaboradores desde la API
    fetch('api/seleccionar_colaboradors.php')
        .then(res => res.json())
        .then(data => {
            const { current_user_id, colaboradors } = data;

            // Filtrar colaboradores para excluir al usuario actual
            const filteredColaboradors = colaboradors.filter(col => col.id_usuari !== current_user_id);

            // Agregar las opciones al select
            for (const col of filteredColaboradors) {
                const option = document.createElement('option');
                option.value = col.id_usuari;
                option.textContent = col.nom;
                select.appendChild(option);
            }
        })
        .catch(err => {
            console.error('Error al cargar colaboradores:', err);
        });

    // Agregar el select y el botón al contenedor
    selectContainer.appendChild(select);
    selectContainer.appendChild(addButton);

    // Agregar el contenedor al cuerpo de la tarjeta
    cardBody.appendChild(selectContainer);

    // Evento para manejar el clic en el botón "Afegir al projecte"
    addButton.addEventListener('click', () => {
        const idColaborador = select.value;
        const idRol = 2; // Puedes cambiar este valor según la lógica de tu aplicación

        if (!idColaborador) {
            alert('Selecciona un col·laborador abans d’afegir-lo.');
            return;
        }

        // Enviar los datos a la API
        fetch('api/afegir_colaborador.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id_projecte=${idProjecte}&id_usuari=${idColaborador}&id_rol=${idRol}`,
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    alert(response.message);
                    console.log(`Col·laborador afegit al projecte: ${idColaborador}`);
                } else {
                    alert(`Error: ${response.message}`);
                }
            })
            .catch(err => {
                console.error('Error al afegir el col·laborador:', err);
            });
    });
}

