<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar Carros</title>

  <link rel="stylesheet" href="../estilo.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-light bg-light nav_bar">
    <div class="container-fluid justify-content-around">
      <a href="index.php">
        <h1><img src="../images/logo.webp" alt="" style="width:50px;"></h1>
      </a>
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
      echo '<div class="alert alert-success" style="text-align:center" role="alert">
        <h6 class="texto-alertas">Cadastro realizado com Sucesso!</h6>
      </div>';
    }
    if ($msg == "dadosinvalidos") {
      echo '<div class="alert alert-danger" style="text-align:center" role="alert">
        <h6 class="texto-alertas">Você inseriu dados inválidos! Por favor verifique!</h6>
      </div>';
    }
    if ($msg == "naoencontrado") {
      echo '<div class="alert alert-danger" style="text-align:center" role="alert">
        <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
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

<div class="col" style="text-align:center;">
      <div class="central">
  <div class="container text-center central" <?php if (!isset($_GET['sv_busca']) and isset($_GET['coluna'])) {
                                                echo " hidden ";
                                              } ?> style="margin-top: 2%;">

    <div class="row central">

      <div class="col">
        <div class="menulateral" id="">
          <h3>Selecione:</h3>
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "todos") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaCarros.php?c_busca=todos">Buscar Todos os Carros</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "placa") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaCarros.php?c_busca=placa">Placa</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "marca") {
                                                        echo " active ";
                                                      }
                                                    } ?> "><a class="dropdown-item" href="../view/telaBuscaCarros.php?c_busca=marca">Marca</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "modelo") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaCarros.php?c_busca=modelo">Modelo</a></li>

            </ul>
            </select>
          </div>
        </div>
      </div>
      <div class="col">

<?php if (isset($_GET["c_busca"])) {
  echo "<br>";
  if ($_GET["c_busca"] == "todos") {
    $coluna = "todos";
    echo '<form id="meu_form" action="../control/CarroControle.php?coluna=' . $coluna . '" method="post">
    <div class="form-floating mb-3 ">
        <input type="text" name="busca" hidden value="todos" class="form-control" id="exampleFormControlInput1" placeholder="">
      </div>';
  } else {
    if ($_GET["c_busca"] == "placa") {
      $coluna = "placa";
      echo '<form id="meu_form" action="../control/CarroControle.php?coluna=' . $coluna . '" method="post">
      <div class="form-floating mb-3 ">
          <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
          <label for="exampleFormControlInput1" class="form-label">Placa</label>
        </div>';
    }
    if ($_GET["c_busca"] == "marca") {
      $coluna = "marca";
      echo '<form id="meu_form" action="../control/CarroControle.php?coluna=' . $coluna . '" method="post">
      <div class="form-floating mb-3 ">
          <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
          <label for="exampleFormControlInput1" class="form-label">Marca</label>
        </div>';
    }
    if ($_GET["c_busca"] == "modelo") {
      $coluna = "modelo";
      echo '<form id="meu_form" action="../control/CarroControle.php?coluna=' . $coluna . '" method="post">
      <div class="form-floating mb-3 ">
          <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
          <label for="exampleFormControlInput1" class="form-label">Modelo</label>
        </div>';
    }
  }
  echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_carro" name="bt_busca_carro"><i class="material-icons">search</i> Buscar</button>
  </form>';
}
?>

</div>
<div class="col"></div>
    </div>
  </div>
  <div class="container text-center w-100" >
    <div id="row_resultados" class="row">
      <div class="col"></div>
      <div class="col-md-auto w-100">
        <div class="div-resultados text-center" style="align-self :center;">

          <?php
          include_once '../control/gerarPdf.php';
          include_once '../control/CarroControle.php';
          if (isset($_GET['valor']) and isset($_GET['coluna'])) {
            echo "<br>";

            echo "
       <div class=\"container text-center\">
<div class=\"row\">
 <div class=\"col\">
 </div>
 <div class=\"col\">
   <form method=\"post\" action=\"telaBuscaCarros.php\"><button class=\"btn btn-dark botao-enviar\" type=\"submit\" id=\"bt_voltar\" name=\"bt_voltar\"></a> <h6><i class=\"material-icons\">arrow_back</i> Voltar</h6></button></form>
 
 </div>
 <div class=\"col\">
   
 </div>
</div>
</div>
<br>";
            if (!empty($_GET['valor']) and !empty($_GET['coluna'])) {
              $html = bt_buscar_carros($_GET['valor'], $_GET['coluna']);
            }
            if (empty($html[0])) {
              header('Location: telaBuscaCarros.php?msg=naoencontrado');
            }

            $resultado = imprimirResultadosCarros($html);
            echo $resultado;
          }

          ?>
        </div></div>
</div>
</div></div></div>
  
  </div>
        <script src="../ajax/ajaxCadastro.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="../js.js"></script>

</body>

</html>