<?php

/**
 * @author Olberto
 * @copyright 2024
 */

require "conect.php";
//$pdo = new PDO('mysql:host=localhost;dbname=sua_base_de_dados', 'usuario', 'senha');

// Processamento do formulário de cadastro de opções
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastro_opcao'])) {
    $nome = $_POST['nome'];
    $codigo = $_POST['codigo'];
    $nivel = $_POST['nivel'];
    $parent_id = $_POST['parent_id'] ?? null;

    $stmt = $pdo->prepare("INSERT INTO organograma_opcoes (nome, codigo, nivel, parent_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $codigo, $nivel, $parent_id]);
    echo "Op&ccedil;&atilde;o cadastrada com sucesso!";
}

// Busca as opções para serem usadas como pai (sub-opções)
$opcoes = $pdo->query("SELECT id, nome, nivel FROM organograma_opcoes ORDER BY nivel ASC, nome ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Cadastro de Op&ccedil;&otilde;es e Sub-op&ccedil;&otilde;es</h2>
<form method="POST">
    <label>Nome da Op&ccedil;&atilde;o:</label>
    <input type="text" name="nome" required><br>
    
    <label>C&oacute;digo da Op&ccedil;&atilde;o:</label>
    <input type="text" name="codigo" required><br>
    
    <label>N&iacute;vel:</label>
    <input type="number" name="nivel" min="1" max="6" required><br>
    
    <label>Op&ccedil;&atilde;o Pai (se for sub-op&ccedil;&atilde;o):</label>
    <select name="parent_id">
        <option value="">Nenhum (op&ccedil;&atilde;o de n&iacute;vel 1)</option>
        <?php foreach ($opcoes as $opcao): ?>
            <option value="<?= $opcao['id'] ?>">N&iacute;vel <?= $opcao['nivel'] ?>: <?= $opcao['nome'] ?></option>
        <?php endforeach; ?>
    </select><br>
    
    <input type="submit" name="cadastro_opcao" value="Cadastrar Op&ccedil;&atilde;o">
</form>
