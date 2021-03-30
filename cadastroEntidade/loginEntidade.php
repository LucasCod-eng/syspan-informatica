<?php

// session_start();

// //Incluindo varaiveis para uso
// require_once __DIR__ . '/../../config/config.php';

// //INCLUIR A CONEXAO
// require_once __DIR__ . '/../../config/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

//CRIANDO SQL QUE IRA INSERIR OS DADOS
$stmt = $conexao->prepare("SELECT * FROM ENTIDADE WHERE EMAIL = :email AND SENHA = :senha");
$stmt = $conexao->prepare("SELECT * FROM VOLUNTARIO WHERE EMAIL = :email AND SENHA = :senha");


//PASSANDO OS VALORES PARA OS PARAMENTROS DA SQL
$stmt->bindValue('email', $email);
$stmt->bindValue('senha', md5($senha));

//EXECUTA A SQL E VERIFICA O RESULTAO PARA MOSTRAR UMA MENSAGEM DE SUCESSO OU ERRO
$stmt->execute();

if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $_SESSION['logado'] = true;
    $_SESSION['nome']   = $resultado['NOME'];
    $_SESSION['id']     = $resultado['ID'];

    // header('Location:' . __DIR_RAIZ . '/restrita.php');

} else {

//   header('Location: ' . __DIR_MODULO_ALUNO . '/loginAluno.php');
}