<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Serviço</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../estilo.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-light bg-light nav_bar">
  <div class="container-fluid justify-content-around">
  <a href="index.php"><h1><img src="../images/logo.webp" alt="" style="width:50px;"></h1></a>
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-dark" type="submit"><i class="material-icons">search</i></button>
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

   <div class="tab-pane m-3">
        <div class="container" style="text-align:center;">
          <form action="../control/FuncionarioControle.php" method="post">
          <h1 class="">Cadastro de Funcionário</h1>
            <div class="form-floating mb-3">
              <input type="text" name="nome" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">Nome</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="cpf" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">CPF</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="telefone" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">Telefone</label>
            </div>


            <div class="container">
              <div class="row">
                <div class="col">
                <a href="index.php"><h6 class="btn btn-dark"><i class="material-icons">arrow_back</i> Voltar ao Início</h6>
                </a>
                </div>
                <div class="col-6">
                <button type="submit" class="btn btn-success" name="bt_cadastro_funcionario">
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

    <script src="../ajax/ajaxCadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="../js.js"></script>
    <script src="../cadastros.js"></script>
</body>

</html>