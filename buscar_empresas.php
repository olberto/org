<?php
    // Conexão do banco de dados
    require "conect.php";

    // Receber os dados enviados pelo JavaScript (latitude, longitude e código do serviço)
    $data = json_decode(file_get_contents('php://input'), true);
    $codigoServico = $data['codigoServico'];
    $latitudeUsuario = $data['latitude'];
    $longitudeUsuario = $data['longitude'];

    // Verifique se os dados foram recebidos corretamente
    if (empty($latitudeUsuario) || empty($longitudeUsuario) || empty($codigoServico)) {
        echo json_encode(['error' => 'Dados insuficientes para a busca.']);
        exit;
    }

    // Query para buscar as empresas próximas com base no serviço e localização
    $sql = "SELECT e.company, se.price, se.latitude, se.longitude,
            ( 6371 * acos( cos( radians(:latitude) ) * cos( radians( se.latitude ) ) 
            * cos( radians( se.longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) 
            * sin( radians( se.latitude ) ) ) ) AS distancia
            FROM services se 
            LEFT JOIN companies e ON se.company_id = e.id 
            WHERE se.service_id = :codigoServico 
            HAVING distancia < 100
            ORDER BY distancia";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':latitude' => $latitudeUsuario,
        ':longitude' => $longitudeUsuario,
        ':codigoServico' => $codigoServico
    ]);

    // Obter os resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        // Retornar os resultados em formato JSON
        echo json_encode($resultados);
    } else {
        echo json_encode(['message' => 'Nenhuma empresa encontrada.']);
    }
?>