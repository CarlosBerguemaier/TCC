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
      echo '<div class="alert alert-success" style="text-align:center" role="alert">
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
  </div>

  <form method="post" action="../control/OrdemServicoControle.php">

    <div class="tab-content" id="pills-tabContent">

      <div class="tab-pane fade show active m-3" id="pills-servicos" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="container " style="text-align:center;">
          <form action="../control/OrdemServicoControle.php" method="post">
             <h1 class="">Cadastro de Serviço</h1>
            <div class="form-floating mb-3 ">
              <input type="text" name="placa" class="form-control" id="exampleFormControlInput1" placeholder="ABC1D23">
              <label for="exampleFormControlInput1" class="form-label">Placa do veículo</label>
            </div>

            <div class=" input-group form-floating mb-3">
              <input type="text" name="cpf_cliente" class="form-control" id="cliente_cpf_input" placeholder="Digite o CPF do cliente">
              <label for="cliente_cpf_input input-group-text" class="form-label">Digite o CPF do cliente</label>

              <span class="input-group-text">ou</span>

              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCliente">
                <i class="material-icons">search</i></button>
            </div>
            <div class=" input-group form-floating mb-3">
            <a href="../view/telaCadastroCliente.php"><h6 class="btn btn-dark"><i class="material-icons">add</i> Cadastar Cliente</h6></a>
            </div>

            <div class=" input-group form-floating mb-3">
              <input type="text" name="cpf_funcionario" class="form-control" id="funcionario_cpf_input" placeholder="11122233345">
              <label for="funcionario_cpf_input" class="form-label">Digite o CPF do funcionário</label>

              <span class="input-group-text">ou</span>

              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFuncionario">
                <i class="material-icons">search</i></button>
            </div>
            <div class=" input-group form-floating mb-3">
            <a href="../view/telaCadastroCliente.php"><h6 class="btn btn-dark"><i class="material-icons">add</i> Cadastar Funcionário</h6></a>
            </div>
           

            <div class="form-floating mb-3">
              <textarea class="form-control" name="descricao" id="exampleFormControlTextarea1" rows="3" placeholder="descrição"></textarea>
              <label for="exampleFormControlTextarea1" class="form-label">Descrição do serviço</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="valor" class="form-control" id="exampleFormControlInput1" placeholder="150">
              <label for="exampleFormControlInput1" class="form-label">Valor</label>
            </div>

            <div class="form-item mb-3">
              <input type="date" name="data" class="form-control" id="" value="<?php echo date('Y-m-d');?>">
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="kminicial" class="form-control" id="exampleFormControlInput1" placeholder="15000">
              <label for="exampleFormControlInput1" class="form-label">Quilometragem Inicial</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="kmfinal" class="form-control" id="exampleFormControlInput1" placeholder="16000">
              <label for="exampleFormControlInput1" class="form-label">Quilometragem Final</label>
            </div>

            <div class="container">
              <div class="row">
                <div class="col">

             <a href="index.php"><h6 class="btn btn-dark"><i class="material-icons">arrow_back</i> Voltar ao Início</h6>
                </a>
                </div>
                <div class="col-6">
                <button type="submit" class="btn btn-success" name="bt_cadastro_ordemservico">
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