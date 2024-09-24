<?php

/**
 * @author Olberto
 * @copyright 2024
 */

// Conexуo ao banco de dados
require "conect.php";

//$pdo = new PDO('mysql:host=199.;dbname=sua_base_de_dados', 'usuario', 'senha');

// Recebe os dados da requisiчуo
$data = json_decode(file_get_contents('php://input'), true);
$nivel = $data['nivel'];
$parent_id = $data['parent_id'];

// Prepara a consulta SQL para buscar as opчѕes com base no nэvel e no ID do pai
$query = $pdo->prepare("SELECT id, nome, codigo FROM organograma_opcoes WHERE nivel = ? AND (parent_id IS NULL OR parent_id = ?) order by nome");
$query->execute([$nivel, $parent_id]);

// Busca os resultados
$options = $query->fetchAll(PDO::FETCH_ASSOC);

// Retorna os resultados em formato JSON
echo json_encode($options);

?>