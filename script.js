let map;

function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map = L.map('map').setView([userLocation.lat, userLocation.lng], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            loadCompanies(userLocation.lat, userLocation.lng);
        });
    } else {
        alert("Geolocalização não é suportada neste navegador.");
    }
}

function loadCompanies(lat, lng) {
    fetch(`buscar_empresas.php?lat=${lat}&lng=${lng}`)
        .then(response => response.json())
        .then(data => {
            data.empresas.forEach(empresa => {
                const marker = L.marker([empresa.latitude, empresa.longitude]).addTo(map)
                    .bindPopup(`<b>${empresa.nome}</b><br>Preço: ${empresa.preco}`);
            });
        })
        .catch(error => console.error('Erro ao buscar empresas:', error));
}

window.onload = initMap;

function goBack() {
    // Função para voltar ao nível anterior no organograma
    alert('Voltando ao nível anterior!');
}

function exibirResultados() {
    // Função para exibir a lista de empresas encontradas
    alert('Exibindo resultados!');
}
