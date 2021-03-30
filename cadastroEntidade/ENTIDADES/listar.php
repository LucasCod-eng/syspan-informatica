<?php
//Incluindo varaiveis para uso
require_once __DIR__ . '/../../config/config.php';
?>


<!Doctype html>
<html>
<head>
    <title>Listagem de Alunos</title>
    <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<div class="mt-2 mb-5">
    <a href="<?=__DIR_MODULO_ALUNO?>/cadastro.php" type="button" class="btn btn-success btn-rounded">Adicionar novo aluno</a>
</div>

<?php

//INCLUIR A CONEXAO
require_once __DIR__ . '/../../config/conexao.php';

//CRIANDO SQL QUE IRA PEGAR TODOS OS DADOS
$stmt = $conexao->prepare('SELECT * FROM ALUNOS');

//EXECUTAR SQL
$stmt->execute();

if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo "<table class=\"table table-striped\">
        <thead>
           <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <th>Cidade</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
          </thead>";

    do {
        echo '<tr>
                <td>'.$resultado['ID'].'</td>
                <td>'.$resultado['NOME'].'</td>
                <td>'.$resultado['EMAIL'].'</td>
                <td>'.$resultado['CPF'].'</td>
                <td>'.$resultado['CIDADE'].'</td>
                <td><a href="'.__DIR_MODULO_ALUNO.'/editar.php?id='.$resultado['ID'].'">Editar</a></td>
                <td><a href="'.__DIR_MODULO_ALUNO.'/excluir.php?id='.$resultado['ID'].'&nome='.$resultado['NOME'].'">Excluir</a></td>
            </tr>';

    }while($resultado = $stmt->fetch(PDO::FETCH_ASSOC));

} else {
    echo "Nenhum registro encontrado";
}


//http://10.67.22.216/guimasanto/Banco/excluirAlunos.php?id=100&nome=Guilherme&cpf=4545648798&

echo "</table>";

?>

</body>
</html>
    
    