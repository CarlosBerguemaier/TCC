<!DOCTYPE html>
  <html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Tela de Edição</title>

  <link rel="stylesheet" href="../estilo.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>

  <nav class="navbar navbar-light bg-light nav_bar">
  <div class="container-fluid justify-content-around">
    <a href="index.php"><h1><img src="../images/logo.webp" alt="" style="width:50px;"></h1></a>
    <form class="d-flex" method="post" action="../control/pesquisaControle.php">
      <input name="pesquisar" class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-dark" name="bt_pesquisar" type="submit"><i class="material-icons">search</i></button>
    </form>
    <h1></h1>
  </div>
</nav>
  
  <div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="ExemploModalCliente" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ExemploModalCliente">Buscar Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="resultado_ajax_clientes">


          <div id="Pesquisar">
            <div class="input-group mb-3">
              <input onkeyup="getDadosCliente();" type="text" id="txtnome_clientes" name="txtnome_clientes" class="form-control" placeholder="Infome o nome:" aria-label="Infome o nome:" aria-describedby="basic-addon2">
            </div>

          </div>
          <hr />

          <div id="Resultado_clientes">

         

          </div>

        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="modalFuncionario" tabindex="-1" aria-lablledby="exemploModalFuncionario" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exemploModalFuncionario">Buscar Funcionário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="resultado_ajax_funcionarios">


        <div id="Pesquisar">
            <div class="input-group mb-3">
              <input onkeyup="getDadosFuncionarios();" type="text" id="txtnome_funcionario" name="txtnome_funcionario" class="form-control" placeholder="Infome o nome:" aria-label="Infome o nome:" aria-describedby="basic-addon2">
            </div>

          </div>
          <hr />

          <div id="Resultado_funcionarios">

         

          </div>

        </div>

        </div>
      </div>
    </div>

    <?php
  if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg == "sucesso") {
      echo '<div class="alert alert-success " style="text-align:center" role="alert">
      <h6 class="texto-alertas">Cadastro realizado com Sucesso!</h6>
    </div>';
    }
    if ($msg == "dadosinvalidos") {
      echo '<div class="alert alert-danger" style="text-align:center" role="alert">
      <h6 class="texto-alertas">Existe algum dado inválido e/ou faltando!</h6>
    </div>';
    }
    if ($msg == "naoencontrado") {
      echo '<div class="alert alert-danger" style="text-align:center" role="alert">
      <h6 class="texto-alertas">Essa infromação não foi encontrada na base de dados!</h6>
    </div>';
    }
  }
  ?>
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
</div> </li>
                </ul>
                <hr>
            </div>
        </div>

<div class="container central" style="margin-top:4%;">
  <div class="row">
  <div class="col">
  </div>
    <div class="container " style="text-align:center;">
    <div class="principal" style="text-align:center;"><h1>Editar dados</h1></div>


<?php
    if(empty($_GET['id'])){
    header('Location: index.php');
    }else{
        $tipo = $_GET['tipo'];
        $id = $_GET['id'];
        if($tipo == "ordemservico"){
            include_once '../control/OrdemServicoControle.php';
         
          $resultados = buscarOrdemServico($id,"id");
          ?>

<div class="div-resultados">
          <?php
          imprimirEditarOrdemServico($resultados[0]);
        }
        
        if($tipo == "cliente"){
          include_once '../control/ClienteControle.php';

        $resultados = buscarCliente($id,"id");
        ?>

<div class="div-resultados">
        <?php
        imprimirEditarCliente($resultados[0]);
      }

      if($tipo == "funcionario"){
        include_once '../control/FuncionarioControle.php';

      $resultados = buscarFuncionario($id,"id");
      ?>
      
<div class="div-resultados">
      <?php
      imprimirEditarFuncionario($resultados[0]);
    }
    if($tipo == "carro"){
      include_once '../control/CarroControle.php';

    $resultados = buscarCarro($id,"id");
    ?>
    
<div class="div-resultados">
    <?php
    imprimirEditarCarro($resultados[0]);
  }

    }
  ?>

</div>

</div></div><div class="col"></div></div></div></div></div>


<script src="../ajax/ajaxCadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="../js.js"></script>
  </body>
  </html>