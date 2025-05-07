window.addEventListener('load', () => {
    // Cargar proyectos
    fetch('api/seleccionar_projectes.php')
        .then(function (resposta) {
            return resposta.json();
        })
        .then(function (projectes) {
            console.log('Projectes carregats:', projectes);
            // Aquí puedes procesar los proyectos
        })
        .catch(function (error) {
            console.error('Error al carregar projectes:', error);
        });

    // Cargar colaboradores
    fetch('api/seleccionar_colaboradors.php')
        .then(function (resposta) {
            return resposta.json();
        })
        .then(function (colaboradors) {
            console.log('Col·laboradors carregats:', colaboradors);
            // Aquí puedes procesar los colaboradores
        })
        .catch(function (error) {
            console.error('Error al carregar col·laboradors:', error);
        });
});