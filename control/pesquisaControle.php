
<?php 
include_once '../control/OrdemServicoControle.php';
include_once '../control/ClienteControle.php';
include_once '../control/CarroControle.php';
include_once '../control/FuncionarioControle.php';
include_once '../model/OrdemServico.php';
include_once '../model/Cliente.php';
include_once '../model/Carro.php';
include_once '../model/Funcionario.php';





function ImprimirF($valor){ 
    $restultado_objeto = buscarCliente($valor,"buscar_todos_parametros");
     $i = 0;
    foreach ($restultado_objeto as $restultado_objeto) {
        $cliente = new Cliente();
        $cliente->setID($restultado_objeto->getId());
        $cliente->setNome($restultado_objeto->getNome());
        $cliente->setCpf($restultado_objeto->getCpf());
        $cliente->setTelefone($restultado_objeto->getTelefone());
        $vetor_clientes[$i] = $cliente;
        $i++;
    }
        

    $restultado_objeto = buscarFuncionario($valor,"buscar_todos_parametros");
  $i = 0;
    foreach ($restultado_objeto as $restultado_objeto) {
        $Funcionario = new Funcionario();
        $Funcionario->setID($restultado_objeto->getId());
        $Funcionario->setNome($restultado_objeto->getNome());
        $Funcionario->setCpf($restultado_objeto->getCpf());
        $Funcionario->setTelefone($restultado_objeto->getTelefone());
        $vetor_funcionarios[$i] = $Funcionario;
        $i++;
    }

 
}


?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa</title>
    <link rel="stylesheet" href="../estilo.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet""
</head>
<body>
    
<nav class="navbar navbar-light bg-light nav_bar">
  <div class="container-fluid justify-content-around">
    <a href="../view/index.php"><h1><img src="../images/logo.webp" alt="" style="width:50px;"></h1></a>
    <form class="d-flex" method="post" action="../control/pesquisaControle.php">
      <input name="pesquisar" class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-dark" name="bt_pesquisar" type="submit"><i class="material-icons">search</i></button>
    </form>
    <h1></h1>
  </div>
</nav>


<div class="container">
  <div class="row" style="margin-top:2%" >

     <?php
     if(isset($_POST['bt_pesquisar'])){
        ImprimirClientes ($_POST['pesquisar']);
       
    }
    
     function ImprimirClientes($valor){ 
        $restultado_objeto = buscarCliente($valor,"buscar_todos_parametros");
        $i = 0;
        $colunas =1;
        if(!empty($restultado_objeto[0])){
            foreach ($restultado_objeto as $restultado_objeto) {

            $cliente = new Cliente();
            $cliente->setID($restultado_objeto->getId());
            $cliente->setNome($restultado_objeto->getNome());
            $cliente->setCpf($restultado_objeto->getCpf());
            $cliente->setTelefone($restultado_objeto->getTelefone());

            echo '<div id="CARD'.$i .'" class="col centralizar"
" ><div class="card" style="width: 13rem; margin-left:18%;">
  <div class="card-body">
    <h5 class="card-title">Nome: '.$cliente->getNome().'</h5>
    <h6 class="card-subtitle mb-2 text-muted">CPF: '.$cliente->getCpf().'</h6>
    <h6 class="card-subtitle mb-2 text-muted">Telefone: '.$cliente->getTelefone().'</h6>
  </div>
</div></div>';
if($colunas>=3){
  echo " <div class=\"row\" style=\"text-align:center;\">
    <div class=\"row\"></div>
  <div class=\"row\" style=\"margin-top:2%\">
  <a href=\"../view/telaBuscaClientes.php?coluna=buscar_todos_parametros&valor=".$valor."\"><button class=\"btn btn-success\"><i class=\"material-icons\">add</i> Mostrar mais</button></a></div>";
  echo '<div class="row"></div>
  <br><hr/>';
  break;
  }
            $colunas++;
            $i++;
            }}else{
                echo "<br>não foram encontrados clientes.";
            }
            

     }?>

  </div>
</div>

<br>


<div class="container">
  <div class="row">

     <?php
     if(isset($_POST['bt_pesquisar'])){
        ImprimirFuncionarios ($_POST['pesquisar']);

    }
    
     function ImprimirFuncionarios($valor){ 
        $restultado_objeto = buscarFuncionario($valor,"buscar_todos_parametros");
        $i = 0;
        if(!empty($restultado_objeto[0])){
          $colunas =1;
            foreach ($restultado_objeto as $restultado_objeto) {
                $Funcionario = new Funcionario();
                $Funcionario->setID($restultado_objeto->getId());
                $Funcionario->setNome($restultado_objeto->getNome());
                $Funcionario->setCpf($restultado_objeto->getCpf());
                $Funcionario->setTelefone($restultado_objeto->getTelefone());
                echo '<div id="CARD'.$i .'" class="col centralizar"
                " ><div class="card" style="width: 13rem; margin-left:18%;">
                  <div class="card-body">
                    <h5 class="card-title">Nome: '.$Funcionario->getNome().'</h5>
                    <h6 class="card-subtitle mb-2 text-muted">CPF: '.$Funcionario->getCpf().'</h6>
                    <h6 class="card-subtitle mb-2 text-muted">Telefone: '.$Funcionario->getTelefone().'</h6>
                  </div>
                </div></div>';
                if($colunas>=3){
                  echo " <div class=\"row\" style=\"text-align:center;\">
                    <div class=\"row\"></div>
                  <div class=\"row\" style=\"margin-top:2%\">
                  <a href=\"../view/telaBuscaFuncionarios.php?coluna=buscar_todos_parametros&valor=".$valor."\"><button class=\"btn btn-success\"><i class=\"material-icons\">add</i> Mostrar mais</button></a></div>";
                  echo '<div class="row"></div>
                  <br><hr/>';
                  break;
                  }
                  $colunas++;
                $i++;
    }
        }else{
            echo "<br>não foram encontrados funcionários.";
        }
        

     }?>

  </div>
</div>
<br>
<div class="container">
  <div class="row">

     <?php
     if(isset($_POST['bt_pesquisar'])){
        echo 'Ordens de serviço<br>';
        ImprimirOS ($_POST['pesquisar']);
       
    }
    
     function ImprimirOS($valor){ 
        $restultado_objeto_os = buscarPorTodosParametros($valor,"buscar_todos_parametros");
        if(!empty($restultado_objeto[0])){
        foreach($restultado_objeto_os as $ob){
             echo '<br>';
            if(!empty(getNomeClienteViaID($ob->getId_cliente()))){
                $cliente = getNomeClienteViaID($ob->getId_cliente());
                echo "Cliente: ".$cliente->getNome();
            }
             echo '<br>Descrição: '.$ob->getDescricao();
             if(!empty(getNomeFuncionarioViaID($ob->getId_funcionario()))){
            $func = getNomeFuncionarioViaID($ob->getId_funcionario());
            echo '<br>Funcionário: '.$func->getNome();
            }  
            echo '<br>';
        }
    }else{
        echo "não foram encontradas ordens de serviço.";
    }
     }?>

  </div>
</div>

</body>
</html>
