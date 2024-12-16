window.addEventListener('load', () => {
    fetch('api/seleccionar_projectes.php')
        .then(function (resposta) {
            return resposta.json()
        })

})








