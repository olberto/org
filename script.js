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
        alert("Geolocaliza��o n�o � suportada neste navegador.");
    }
}

function loadCompanies(lat, lng) {
    fetch(`buscar_empresas.php?lat=${lat}&lng=${lng}`)
        .then(response => response.json())
        .then(data => {
            data.empresas.forEach(empresa => {
                const marker = L.marker([empresa.latitude, empresa.longitude]).addTo(map)
                    .bindPopup(`<b>${empresa.nome}</b><br>Pre�o: ${empresa.preco}`);
            });
        })
        .catch(error => console.error('Erro ao buscar empresas:', error));
}

window.onload = initMap;

function goBack() {
    // Fun��o para voltar ao n�vel anterior no organograma
    alert('Voltando ao n�vel anterior!');
}

function exibirResultados() {
    // Fun��o para exibir a lista de empresas encontradas
    alert('Exibindo resultados!');
}
