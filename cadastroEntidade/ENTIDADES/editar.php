<?php

//Incluindo varaiveis para uso
require_once __DIR__ . '/../../config/config.php';

//INCLUIR A CONEXAO
require_once __DIR__ . '/../../config/conexao.php';

//INCLUIR FUNÇÕES úTEIS
require_once __DIR__ . '/../../config/funcoes.php';

//Pegando ID do registro
$id = $_GET['id'];

//CRIANDO SQL QUE IRA VERIFICAR SE EXISTE O REGISTRO
$stmt = $conexao->prepare('SELECT * FROM ALUNOS WHERE ID = :id LIMIT 1');
$stmt->bindValue('id', $id);

//EXECUTAR SQL
$stmt->execute();

//Processando a query para pegar o registro
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

//Caso o registro estiver vazio exibe mensagem de erro avisando
if (empty($resultado)) {
    echo 'Registro não encontrado';
    die;
}

//CRIANDO SQL QUE IRA VERIFICAR SE EXISTE O REGISTRO
$stmt = $conexao->prepare('SELECT ID_TURMA FROM turma_tem_alunos WHERE ID_ALUNO = :id');
$stmt->bindValue('id', $id);

//EXECUTAR SQL
$stmt->execute();

//Processando a query para pegar o registro
$turmasAluno = $stmt->fetchAll(PDO::FETCH_COLUMN );
?>


<html>
<head>
    <title> </title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style>
        label{
            display:block;
        }

        .semBlock{
            display: inline;
        }

    </style>

</head>
<body>

<div class="container">
    <form action="<?=__DIR_MODULO_ALUNO?>/atualiza.php" method="post" enctype="multipart/form-data">
        <h1>Dados Pessoais</h1>

        <input type="hidden" name="id" value="<?=$_GET['id']?>">

        <label class="form-group">Nome
            <input class="form-control" type="text" value="<?=$resultado['NOME']?>" name="nome" id="nome" autofocus="autofocus" placeholder="Digite seu nome" required />
        </label>

        <label class="form-group">E-mail
            <input class="form-control" type="text" id="email" value="<?=$resultado['EMAIL']?>" name="email" placeholder="Digite seu e-mail" required />
        </label>

        <label class="form-group">Senha
            <input class="form-control" type="password" name="senha" placeholder="Digite seu senha" />
            <span class="text-muted">Preencha a senha caso queira mudá-la</span>
        </label>

        <label class="form-group">CPF
            <input class="form-control" type="tel" id="cpf" value="<?=$resultado['CPF']?>" name="cpf" placeholder="Digite seu CPF" required />
        </label>

        <label class="form-group">Cidade
            <input class="form-control" type="text" id="cidade" value="<?=$resultado['CIDADE']?>" name="cidade" placeholder="Digite sua cidade" required />
        </label>

        <?php
            //Usando Função para pegar a foot
            $foto = exibirArquivo($resultado['FOTO']);

            //Verificando se o existe uma foto, se SIM ela será exibida
            if ($foto) {
                ?>

                <div class="form-group mt-3">
                    <img src="<?=$foto?>" alt="" style="max-height: 150px">
                </div>

                <?php
            }
        ?>

        <div class="form-group mt-3">
            <input type="file" class="form-control" id="foto" name="foto">
        </div>

        <div class="mb-5"></div>

        <label for="turmas">Turmas</label>
        <style>
            .custom-size{
                min-width: 100px;
            }
        </style>

        <div class="d-flex flex-wrap">
            <?php

            //CRIANDO SQL QUe IRA BUSCAR AS TURMAS
            $stmt = $conexao->prepare('SELECT * FROM TURMAS');

            //EXECUTAR SQL
            $stmt->execute();

            if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {

                do {

                    echo '
                        <div class="custom-control custom-checkbox mr-5 mb-2 custom-size">
                          <input 
                          value="'.$resultado['ID_TURMA'].'" 
                          type="checkbox" 
                          class="custom-control-input"
                          id="checkbox-'.$resultado['ID_TURMA'].'" 
                          name="turmas[]"
                          '.(in_array($resultado['ID_TURMA'], $turmasAluno) ? 'checked' : '') .'
                          >
                          <label class="custom-control-label" for="checkbox-'.$resultado['ID_TURMA'].'">'.$resultado['NOME'].'</label>
                        </div>
								';

                }while($resultado = $stmt->fetch(PDO::FETCH_ASSOC));

            } else {
                echo "Nenhum registro encontrado";
            }

            ?>
        </div>

        <button type="submit" class="btn btn-success mt-3" name="cadastrar">Confirmar Edição</button>

    </form>
</div>

</body>
</html>
