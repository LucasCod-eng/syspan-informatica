<?php

//Incluindo varaiveis para uso
require_once __DIR__ . '/../../config/config.php';

//INCLUIR A CONEXAO
require_once __DIR__ . '/../../config/conexao.php';

//INCLUIR FUNÇÕES úTEIS
require_once __DIR__ . '/../../config/funcoes.php';

?>

<!Doctype html>
<html>
<head>
    <title>Formulário de cadastro de Alunos</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<a href="<?= __DIR_MODULO_ALUNO ?>/listar.php" class="mt-5 btn btn-primary">Voltar a listagem de aluno</a>

<?php

//Pegando ID do registro
$id = $_GET['id'];

//CRIANDO SQL QUE IRA VERIFICAR SE EXISTE O REGISTRO
$stmt = $conexao->prepare('SELECT * FROM ALUNOS WHERE ID = :id LIMIT 1');
$stmt->bindValue('id', $id);

//EXECUTAR SQL
$stmt->execute();

//Processando a query criado para pegar o usuário
if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {

    //Apagando seu relacionamento em turma_tem_alunos
    $stmt = $conexao->prepare('DELETE FROM turma_tem_alunos WHERE ID_ALUNO = :id');
    $stmt->bindParam(':id', $resultado['ID']);
    $stmt->execute();

    //Deletando a foto que não será mais necessária
    apagarArquivo($resultado['FOTO']);

    //Apagando o registro
    $stmt = $conexao->prepare('DELETE FROM ALUNOS WHERE ID = :id');
    $stmt->bindParam(':id', $resultado['ID']);
    $stmt->execute();

    echo '<p class="mt-5 alert alert-success">Registro apagado com sucesso, junto com suas depências</p>';

    return true;
}

echo '<p class="mt-5 alert alert-warning">Registro não encontrado</p>';

?>

</body>
</html>

