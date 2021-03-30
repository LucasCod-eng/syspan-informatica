<?php 
                //inserir conexao
                require "conexao.php";

                //criando sql que iria inseiri os dados
                $stmt = $conexao->prepare('SELECT * FROM entidades');

                //executar sql
                $stmt->execute();

                if($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {

                
					do{

		
               
                }while($resultado = $stmt->fetch(PDO::FETCH_ASSOC));

                echo 'Cadastro efetuado com sucesso';
            } else {
                echo "Erro no casdastro";
      }
      
      ?>
			
			