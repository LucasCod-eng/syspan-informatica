<?php 
 
//  require 'conexao.php'
$id = $_POST['id'];
$login = $_POST['login'];
$telefone = $_POST ['telefone'];
$endereco= $_POST ['endereco'];
$email = $_POST ['email'];
// $uf = $_POST ['uf'];
$cidade = $_POST ['cidade'];
$cnpj = ($_POST ['cnpj']);
$senha = MD5($_POST['senha']);
$connect = mysql_connect('10.67.22.216','tcc_infonet_2019_voluntario','vl5532');
$db = mysql_select_db('cadastro');
$query_select = "SELECT login FROM tcc_infonet_2019_voluntario WHERE login = '$login'";
$select = mysql_query($query_select,$connect);
$array = mysql_fetch_array($select);
$logarray = $array['login'];
 
// Valida os dados recebidos
$mensagem = '';
if ($login == 'editar' && $id == ''):
    $mensagem .= '<li>ID do registros desconhecido.</li>';
  endif;

  // Se for ação diferente de excluir valida os dados obrigatórios
  if ($login != 'excluir'):
  if ($login == '' || strlen($login) < 3):
    $mensagem .= '<li>Favor preencher o Nome.</li>';
    endif;

  if ($telefone == ''):
     $mensagem .= '<li>Favor preencher o Telefone.</li>';
    elseif(strlen($telefone) < 11):
      $mensagem .= '<li>Numero .</li>';
    endif;

  if ($endereco == ''):
    $mensagem .= '<li>Favor preencher o E-mail.</li>';
  elseif(!filter_var($endereco, FILTER_VALIDATE_EMAIL)):
      $mensagem .= '<li>Formato do E-mail inválido.</li>';
  endif;

  if ($email == ''):
    $mensagem .= '<li>Favor preencher o E-mail.</li>';
  elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)):
      $mensagem .= '<li>Formato do E-mail inválido.</li>';
  endif;
  

  if ($telefone == ''): 
    $mensagem .= '<li>Favor preencher o Telefone.</li>';
  elseif(strlen($telefone) < 10):
      $mensagem .= '<li>Formato do Telefone inválido.</li>';
    endif;


  if ($mensagem != ''):
    $mensagem = '<ul>' . $mensagem . '</ul>';
    echo "<div class='alert alert-danger' role='alert'>".$mensagem."</div> ";
    exit;
  endif;

  

// Verifica se foi solicitada a inclusão de dados
if ($login == 'incluir'):

  $nome_foto = 'padrao.jpg';
  if(isset($_FILES['foto']) && $_FILES['foto']['size'] > ):  

    $extensoes_aceitas = array('bmp' ,'png', 'svg', 'jpeg', 'jpg');
      $extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));

       // Validamos se a extensão do arquivo é aceita
      if (array_search($extensao, $extensoes_aceitas) === false):
         echo "<h1>Extensão Inválida!</h1>";
         exit;
      endif;

       // Verifica se o upload foi enviado via POST   
       if(is_uploaded_file($_FILES['foto']['tmp_name'])):  
               
            // Verifica se o diretório de destino existe, senão existir cria o diretório  
            if(!file_exists("fotos")):  
                 mkdir("fotos");  
            endif;  
    
            // Monta o caminho de destino com o nome do arquivo  
            $nome_foto = date('dmY') . '_' . $_FILES['foto']['name'];  
              
            // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_foto)):  
                 echo "Houve um erro ao gravar arquivo na pasta de destino!";  
            endif;  
       endif;  
  endif;

  $sql = 'INSERT INTO cadastro (login, telefone, endereco, email, cidade, cnpj, foto)
             VALUES(:login, :telefone, :endereco, :email, :cidade, :cnpj, :foto)';

  $stm = $conexao->prepare($sql);
  $stm->bindValue(':login', $login);
  $stm->bindValue(':telefone', $telefone);
  $stm->bindValue(':endereco', $endereco);
  $stm->bindValue(':email', $email);
  $stm->bindValue(':cidade', $cidade]);
  $stm->bindValue(':cnpj', $cnpj);
  $stm->bindValue(':foto', $nome_foto);
  $retorno = $stm->execute();

  if ($retorno):
    echo "<div class='alert alert-success' role='alert'>Registro inserido com sucesso, aguarde você está sendo redirecionado ...</div> ";
    else:
      echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div> ";
  endif;

  echo "<meta http-equiv=refresh content='3;URL=index.php'>";
endif;
?>

</div>
</body>
</html>
