<?php

/**
 * @author Olberto
 * @copyright 2024
 */

    // Conexão banco de dados
    require "conect.php";

    
    // Receber os dados enviados pelo JavaScript
    $data = json_decode(file_get_contents('php://input'), true);
    $escolhas = $data['escolha'];
    
    // Criar a query com base nas escolhas
    $placeholders = rtrim(str_repeat('?,', count($escolhas)), ',');
    $sql = "SELECT * FROM sua_tabela WHERE sua_coluna IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($escolhas);
    
    // Exibir os resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($resultados) {
        foreach ($resultados as $resultado) {
            echo "<p>" . htmlspecialchars($resultado['sua_coluna']) . "</p>";
        }
    } else {
        echo "<p>Nenhum resultado encontrado.</p>";
    }
    


?>