<?php

/**
 * @author Olberto
 * @copyright 2024
 */

require "conect.php";

// Processamento do formulário de cadastro de serviços
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastro_servico'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $codigo_servico = $_POST['codigo_servico'];
    $opcao_id = $_POST['opcao_id'];

    $stmt = $pdo->prepare("INSERT INTO servicos (nome, descricao, codigo_servico, opcao_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $codigo_servico, $opcao_id]);
    echo "Serviço cadastrado com sucesso!";
}

// Busca as opções para associar aos serviços
$opcoes = $pdo->query("SELECT id, nome, codigo FROM organograma_opcoes ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Cadastro de Serviços</h2>
<form method="POST">
    <label>Nome do Servi&ccedil;o:</label>
    <input type="text" name="nome" required><br>
    
    <label>Descri&ccedil;&atilde;o do Serviço:</label>
    <textarea name="descricao"></textarea><br>
    
    <label>C&oacute;digo do Servi&ccedil;o:</label>
    <input type="text" name="codigo_servico" required><br>
    
    <label>Op&ccedil;&atilde;o Relacionada:</label>
    <select name="opcao_id" required>
        <?php foreach ($opcoes as $opcao): ?>
            <option value="<?= $opcao['id'] ?>"><?= $opcao['nome'] ?> (Código: <?= $opcao['codigo'] ?>)</option>
        <?php endforeach; ?>
    </select><br>
    
    <input type="submit" name="cadastro_servico" value="Cadastrar Servi&ccedil;o">
</form>
