<!Doctype html>
<html>
<head>
    <title>Formulário de cadastro de Alunos</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<?php

//Incluindo varaiveis para uso
require_once __DIR__ . '/PHP/config.php';

//INCLUIR A CONEXAO
require_once __DIR__ . '/conexao.php';

//INCLUIR FUNÇÕES úTEIS
require_once __DIR__ . '/PHP/funcoes.php';

//Juntando o array de dados do POST junto com o FILES
$dados = array_merge($_POST, $_FILES);

//Criando regras apra validação
$regras = [
    'nome'   => 'obrigatorio|max:100',
    'telefone'  => 'obrigatorio|max:14',
     'endereco'    => 'obrigatorio|max:15',
     'email'   => 'obrigatorio|email|max:100',
     'senha'  => 'obrigatorio|max:100',
     'repitsenha'  => 'obrigatorio|max:100',
     'uf' => 'obrigatorio',
     'cidade'  => 'obrigatorio|max:100',
     'cnpj'  => 'obrigatorio|max:11',
];

//VERIFICANDO SE A SENHA VEIO NO POST, SE SIM SERA ADICONADO A REGRA PARA VALIDAR ELA
if (!empty($_POST['senha'])) {
    $regras['senha'] = 'obrigatorio|max:100';
}

//VERIFICANDO SE A FOTO VEIO NO POST, SE SIM SERA ADICONADO A REGRA PARA VALIDAR ELA
if (!empty($_FILE['foto'])) {
    $regras['foto'] = 'obrigatorio|tipo:png,jpg,jpeg';
}

//Validando os campos que forma enviados pelo formulario com base nas regras passdas
if ($msgErro = validacaoCampos($dados, $regras)) {
    echo $msgErro;
    die;
}

   //VERIFICANDO SE A FOTO VEIO NO POST, SE SIM SERA SALVA
    if (!empty($_FILE['foto'])) {

        //Apagando foto antiga
        apagarArquivo($resultado['FOTO']);

        //Fazendo upload e tratamento do arquivo
        $retorno = uploadArquivo($_FILES['foto'], 'entidades');

        //Verificando se ocorreu algum erro
        if ($retorno['erro']) {
            var_dump($retorno['msg']);
            die;
        }

        $foto = $retorno['msg'];
    }

//RECEBENDO DADOS DO FORMULÁRIO
$nome = $_POST ['nome'];
$endereco = $_POST ['endereco'];
$telefone = $_POST ['telefone'];
$uf = $_POST ['uf'];
$cidade = $_POST ['cidade'];
$email = $_POST ['email'];
$senha = md5($_POST ['senha']);
$cnpj = $_POST ['cnpj'];

    if (!empty($_POST['senha'])) {
        $senha = md5($_POST['senha']);
    }

    //Montando campos e dados a serem colocados na Query com base nos dados enviados
    $campos      = 'NOME = :nome, ENDERECO = :endereco, TELEFONE = :telefone, UF = :uf, CIDADE = :cidade, EMAIL = :email, SENHA = :senha, CNPJ = :cnpj, FOTO = :foto';

    //VERIFICANDO SE A SENHA VEIO NO POST, SE SIM SERA ADICONADO A REGRA PARA VALIDAR ELA
    if (!empty($_POST['senha'])) {
        $campos      .= ', SENHA = :senha';
    }

    //VERIFICANDO SE A FOTO VEIO NO POST, SE SIM SERA ADICONADO A REGRA PARA VALIDAR ELA
    if (!empty($_FILE['foto'])) {
        $campos      .= ', FOTO = :foto';
    }

    //CRIANDO SQL QUE IRA INSERIR OS DADOS
    $stmt = $conexao->prepare('INSERT INTO (NOME, ENDERECO, TELEFONE, UF, CIDADE, EMAIL, SENHA, CNPJ, FOTO ) VALUE (:nome, :endereco, :telefone, :uf, :cidade, :email, :senha, :cnpj, :foto)');

    //PASSANDO OS VALORES PARA OS PARAMENTROS DA SQL
    $stmtEntidade->bindValue('nome', $nome);
    $stmtEntidade->bindValue('endereco', $endereco);
    $stmtEntidade->bindValue('telefone', $telefone);
    $stmtEntidade->bindValue('uf', $uf);
    $stmtEntidade->bindValue('cidade', $cidade);
    $stmtEntidade->bindValue('email', $email);
    $stmtEntidade->bindValue('senha', $senha);
    $stmtEntidade->bindValue('cnpj', $cnpj);

    if (!empty($_POST['senha'])) {
        $stmtEntidade->bindValue('senha', $senha);
    }
    if (!empty($_FILE['foto'])) {
        $stmtEntidade->bindValue('foto', $_FILE['foto']['name']);
    }
    $stmtEntidade->bindValue('cidade', $cidade);

    //EXECUTA A SQL E VERIFICA O RESULTAO PARA MOSTRAR UMA MENSAGEM DE SUCESSO OU ERRO
    if ($stmtEntidade->execute() == true) {
        echo 'Entidade atualizada com sucesso';


        //Apagando seu relacionamento em turma_tem_alunos
        // $stmtTurmaAluno = $conexao->prepare('DELETE FROM turma_tem_alunos WHERE ID_ALUNO = :id');
        // $stmtTurmaAluno->bindParam(':id', $resultado['ID']);
        // $stmtTurmaAluno->execute();

        //CRIANDO SQL QUE IRA INSERIR OS DADOS
       /* $stmtTurma = $conexao->prepare('INSERT INTO turma_tem_alunos (ID_TURMA, ID_ALUNO, DATA_MATRICULA) VALUE (:turma, :aluno, :datamatricula)');

        foreach ($turmas as $idTurma) {

            $stmtTurma->bindValue('turma', $idTurma);
            $stmtTurma->bindValue('aluno', $id);
            $stmtTurma->bindValue('datamatricula', date('Y-m-d'));

            if ($stmtTurma->execute() == true) {
                echo 'Aluno matriculado na turma ' . $idTurma . ' com sucesso</br/>';
            } else {
                echo 'Erro ao matricular o aluno</br/>';
            }

        }
        */
    } else {
        print_r($stmt->errorInfo());
        echo 'Erro ao inserir Entidade';
    }

?>

<a href="<?= __DIR_MODULO_ALUNO ?>/listar.php" class="mt-5 btn btn-primary">Voltar a listagem de aluno</a>

</body>
</html>