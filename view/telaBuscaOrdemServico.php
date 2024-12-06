<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>tela de serviços</title>


  <link rel="stylesheet" href="../estilo.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body style="background-color:rgb(213, 232, 252);">

  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #6AA6F9;">
    <ul class="navbar-nav">
      <li class="nav-item custom">
        <a class="nav-link navbar-link" href="<?php    ob_start(); if (isset($_GET['coluna'])) {
                                                echo "../view/telaBuscaOrdemServico.php";
                                              } else {
                                                echo "../view/index.php";
                                              } ?>
          "><i class="material-icons" style="color:white;">arrow_back</i></a>
      </li>
    </ul>
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
          <div id="Resultado_clientes"></div>
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

  <?php
  if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg == "sucesso") {
      echo '<div class="alert alert-success" role="alert">
        <h6 class="texto-alertas">Cadastro realizado com Sucesso!</h6>
      </div>';
    }
    if ($msg == "naoencontrado") {
      echo '<div class="alert alert-danger" role="alert">
        <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
      </div>';
    }
  }
  ?>

  <div class="container text-center" <?php if (!isset($_GET['sv_busca']) and isset($_GET['coluna'])) {
                                        echo " hidden ";
                                      } ?> style="margin-top: 2%;">

    <div class="row">
      <div class="col">
        <h3>Selecione:</h3>
        <div class="principal" id="">
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item listgroup <?php if (isset($_GET['sv_busca'])) {
                                                      if ($_GET['sv_busca'] == "todos") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=todos">Buscar Todos os Serviços</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['sv_busca'])) {
                                                      if ($_GET['sv_busca'] == "placa") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=placa">Placa do Veículo</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['sv_busca'])) {
                                                      if ($_GET['sv_busca'] == "cpf_c") {
                                                        echo " active ";
                                                      }
                                                    } ?> "><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=cpf_c">CPF do cliente</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['sv_busca'])) {
                                                      if ($_GET['sv_busca'] == "cpf_f") {
                                                        echo " active ";
                                                      }
                                                    } ?> "><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=cpf_f">CPF do Funcionário</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['sv_busca'])) {
                                                      if ($_GET['sv_busca'] == "descricao") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=descricao">Descrição</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['sv_busca'])) {
                                                      if ($_GET['sv_busca'] == "valor") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=valor">Valor</a></li>
            </ul>
            </select>
          </div>
        </div>
      </div>

      <div class="col-3">


        <?php

        if (isset($_GET["sv_busca"])) {
          if ($_GET["sv_busca"] == "todos") {
            $coluna = "todos";
            echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna=' . $coluna . '" method="post">';
            echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico"> <i class="material-icons">search</i> Buscar</button>';
          }
          if ($_GET["sv_busca"] == "cpf_c") {
            $coluna = "cpf_c";

            echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna=' . $coluna . '" method="post">
              <div class=" input-group form-floating mb-3">
        
              <input type="text" name="busca" class="form-control" id="cliente_cpf_input" placeholder="Digite o CPF do cliente">
              <label for="cliente_cpf_input input-group-text" class="form-label">Digite o CPF do cliente</label>

              <span class="input-group-text">ou</span>

              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCliente">
                <i class="material-icons">search</i></button>
            </div>
              <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico"><i class="material-icons">search</i>Buscar</button>';
          }
          if ($_GET["sv_busca"] == "cpf_f") {
            $coluna = "cpf_f";

          echo ' <form id="meu_form" action="../control/OrdemServicoControle.php?coluna=' . $coluna . '" method="post">
          <div class=" input-group form-floating mb-3">
              <input type="text" name="busca" class="form-control" id="funcionario_cpf_input" placeholder="11122233345">
              <label for="funcionario_cpf_input" class="form-label">Digite o CPF do funcionário</label>

              <span class="input-group-text">ou</span>

              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFuncionario">
                <i class="material-icons">search</i></button>
            </div>
            <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico"><i class="material-icons">search</i>Buscar</button>';

          }
          if ($_GET["sv_busca"] == "placa") {
            $coluna = "placa";

          echo ' <form id="meu_form" action="../control/OrdemServicoControle.php?coluna=' . $coluna . '" method="post">
          <div class="form-floating mb-3 ">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="ABC1D23">
              <label for="exampleFormControlInput1" class="form-label">Placa do Carro</label>
            </div>
            <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico"><i class="material-icons">search</i>Buscar</button>';
          }
          if ($_GET["sv_busca"] == "valor") {
            $coluna = "valor";

           echo '  <form id="meu_form" action="../control/OrdemServicoControle.php?coluna=' . $coluna . '" method="post">
           <div class="form-floating mb-3">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="150">
              <label for="exampleFormControlInput1" class="form-label">Valor</label>
            </div>
            <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico"><i class="material-icons">search</i>Buscar</button>';

      
          }
          if ($_GET["sv_busca"] == "descricao") {
            $coluna = "descricao";

            echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna=' . $coluna . '" method="post">
            <div class="form-floating mb-3">
              <textarea class="form-control" name="busca" id="exampleFormControlTextarea1" rows="3" placeholder="descrição"></textarea>
              <label for="exampleFormControlTextarea1" class="form-label">Descrição do serviço</label>
            </div>
           <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico"><i class="material-icons">search</i>Buscar</button>';
          }
        }
        ?>
        </form>




      </div>
      <div class="col">

      </div>
    </div>
  </div>
  </div>
  </div>

  <div class="container text-center">
    <div class="row">
      <div class="col"></div>
      <div class="col-md-auto ">
        <div class="div-resultados ">
          <?php
          include_once '../control/OrdemServicoControle.php';
          include_once '../control/gerarPdf.php';
          if (isset($_GET['valor']) and isset($_GET['coluna'])) {
            echo "<br>";

            echo "
          <div class=\"container text-center\">
  <div class=\"row\">
    <div class=\"col\">
      <form method=\"post\" action=\"telaBuscaOrdemServico.php\"><button class=\"btn btn-success botao-enviar\" type=\"submit\" id=\"bt_voltar\" name=\"bt_voltar\"></a> <h6><i class=\"material-icons\">arrow_back</i> Voltar</h6></button></form>
    </div>
    <div class=\"col\">
      <form method=\"post\" action=\"telaBuscaOrdemServico.php?valor=" . $_GET['valor'] . "&coluna=" . $_GET['coluna'] . "\">
      <button class=\"btn btn-success botao-enviar\" type=\"submit\" id=\"bt_gerar_pdf\" name=\"bt_gerar_pdf\"></a> <h6><i class=\"material-icons\">picture_as_pdf</i> Gerar PDF</h6></button></form>
    </div>
    <div class=\"col\">
      
    </div>
  </div>
</div>";

            $html = bt_buscar_os($_GET['valor'], $_GET['coluna']);
            if (isset($_POST['bt_gerar_pdf'])) {
              gerarPdfdasOS($html);
            }
            echo "<br>";
            $resultado = imprimirResultadosOrdemServicos($html);
            echo $resultado;
          }
          ?>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>



  <script src="../ajax/ajaxCadastro.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="../js.js"></script>
</body>

</html>