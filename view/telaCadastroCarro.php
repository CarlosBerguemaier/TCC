<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Carro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../estilo.css">
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
  }
  date_default_timezone_set('UTC');
  $data = date("d.m.y");
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
   <a href="../view/telaBuscaFuncionarios.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Mensal</button></a>
   <br>
   <a href="../view/telaBuscaFuncionarios.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Anual</button></a>
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
    <div class="col-md-auto">
    <div class="container " style="text-align:center;">





<div class="tab-pane mb-3">
        <div class="container" style="text-align:center;">
        <h1 class="">Cadastro de Veículo</h1>
          <form action="../control/CarroControle.php" method="post">
            <div class="form-floating mb-3">
              <input type="text" name="placa" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">Placa</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="marca" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">Marca</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="modelo" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">Modelo</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="ano" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">Ano</label>
            </div>


            <div class="container">
              <div class="row">
                <div class="col">
                </div>
                <div class="col-6">
                <button type="submit" class="btn btn-success" name="bt_cadastro_carro">
              <h2>Cadastrar</h2>
            </button>
                </div>
                <div class="col">
                </div>
              </div>
            </div>

        
          </form>
        </div>

      </div>
      </div></div><div class="col"></div></div></div></div></div>
    <script src="../ajax/ajaxCadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../js.js"></script>
    <script src="../cadastros.js"></script>
</body>

</html>