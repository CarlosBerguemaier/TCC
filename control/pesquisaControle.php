
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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 nav-lateral bg-light">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                    <a href="../view/index.php"><button class="btn btn-dark m-1 bt_opcoes"><i class="material-icons">home</i> Início</button></a>
 
                    </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Ordem de serviço
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroOrdemServico.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaOrdemServico.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>
                    </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Cliente
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroCliente.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaClientes.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>     
                  </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Veículos
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroCarro.php">   <button class="btn btn-outline-dark m-1 sub_bt_opcoes" ><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaCarros.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>
                    </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Funcionário
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroFuncionario.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaFuncionarios.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>
                    </li>
                    <li>
              <div class="btn-group dropend m-1">
                <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="material-icons">picture_as_pdf</i> Relatórios
                </button>
                <ul class="dropdown-menu ">
                  <a href="../view/telaRelatorio.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Personalizar</button></a>
                  <br>
                  <a href="../view/telaMeses.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Mensal</button></a>
                  <br>
                  <a href="../view/telaAnual.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Anual</button></a>
                </ul>
              </div>
            </li>
                </ul>
                <hr>
                </div>
                </div>

                <div class="container central" style="margin-top:4%;">
  <div class="row">

  <div class="col">
  </div>

    <div class="col-md-auto">
    <div class="container " style="text-align:center;">
  <div class="row" style="margin-top:2%" >

     <?php
     if(isset($_POST['bt_pesquisar']) and !empty($_POST['pesquisar'])){
        echo '<h2>Clientes</h2>';
        ImprimirClientes ($_POST['pesquisar']);
        echo '<div class="row"></div>
        <br><hr/>';
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
  break;
  }
            $colunas++;
            $i++;
            }}else{
              echo '<br>
              <div class="alert alert-warning" style="text-align:center; " role="alert">
    Não foram encontrados clientes.
  </div>';
            }
            

     }?>

  </div>
</div>

<br>


<div class="container">
  <div class="row">

     <?php
     if(isset($_POST['bt_pesquisar']) and !empty($_POST['pesquisar'])){
      echo '<h2>Funcionários</h2>';
        ImprimirFuncionarios ($_POST['pesquisar']);
        echo '<div class="row"></div>
        <br><hr/>';
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
                  break;
                  }
                  $colunas++;
                $i++;
    }
        }else{
            echo '<br>
            <div class="alert alert-warning" style="text-align:center; " role="alert">
  Não foram encontrados funcionários.
</div>';


        }
        

     }?>

  </div>
</div>
<br>
<div class="container">
  <div class="row">

     <?php
     if(isset($_POST['bt_pesquisar']) and !empty($_POST['pesquisar'])){
      echo '<h2>Ordens de serviço</h2>';
        ImprimirOS ($_POST['pesquisar']);
    }else{
      echo '<h2 style="text-align:center;">Não é possível pesquisar valores nulos</h2>';
    }
    
     function ImprimirOS($valor){ 
        $restultado_objeto_os = buscarPorTodosParametros($valor,"buscar_todos_parametros");
        if(!empty($restultado_objeto_os)){
          $i = 0;
          $colunas =1;
        foreach($restultado_objeto_os as $ob){
             echo '<br>';

             if(!empty($ob)){
              if(!empty(getNomeClienteViaID($ob->getId_cliente()))){
                $cliente = getNomeClienteViaID($ob->getId_cliente());
            }
             if(!empty(getNomeFuncionarioViaID($ob->getId_funcionario()))){
            $func = getNomeFuncionarioViaID($ob->getId_funcionario());
            }  
            
           

            echo '<div id="CARD'.$i .'" class="col centralizar"
            " ><div class="card" style="width: 13rem; margin-left:18%;">
              <div class="card-body">
                <h5 class="card-title">Cliente: '.$cliente->getNome().'</h5>
                <h6 class="card-subtitle mb-2 text-muted">Funcionário: '.$func->getNome().'</h6>
                <h6 class="card-subtitle mb-2 text-muted">Serviço: '.$ob->getDescricao().'</h6>
              </div>
            </div></div>';
            if($colunas>=3){
              echo " <div class=\"row\" style=\"text-align:center;\">
                <div class=\"row\"></div>
              <div class=\"row\" style=\"margin-top:2%\">
              <a href=\"../view/telaBuscaOrdemServico.php?coluna=todos&valor=".$valor."\"><button class=\"btn btn-success\"><i class=\"material-icons\">add</i> Mostrar mais</button></a></div>";
              break;
              }
            echo '<br>';
    
            $colunas++;
            $i++;
      
        }else{
          echo '<br>
                <div class="alert alert-warning" style="text-align:center; " role="alert">
    Não foram encontradas ordens de serviço.
    </div>';
        }
      }}
     }?>
</div></div>  </div> <div class="col"></div> </div>
  </div>

    </div></div></div></div>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
      <script src="../js.js"></script>
</body>
</html>
