function loadOrganograma(nivel = 1, codigo = null) {
    // Carregar os n�veis do organograma com base no n�vel atual e c�digo da sele��o anterior
    fetch(`buscar_organograma.php?nivel=${nivel}&codigo=${codigo}`)
        .then(response => response.json())
        .then(data => {
            const organogramaDiv = document.getElementById('organograma');
            organogramaDiv.innerHTML = ''; // Limpar op��es anteriores

            data.opcoes.forEach(opcao => {
                const button = document.createElement('button');
                button.textContent = opcao.nome;
                button.classList.add('button');
                button.onclick = () => {
                    if (opcao.nivelFinal) {
                        buscarEmpresas(opcao.codigo);
                    } else {
                        loadOrganograma(opcao.nivel + 1, opcao.codigo);
                    }
                };
                organogramaDiv.appendChild(button);
            });
        })
        .catch(error => console.error('Erro ao carregar organograma:', error));
}

window.onload = () => {
    loadOrganograma(); // Iniciar o organograma
};
