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
          <a class="nav-link navbar-link" href="<?php if (isset($_GET['coluna'])) {
                                                  echo "../view/telaBuscaClientes.php";
                                                } else {
                                                  echo "../view/index.php";
                                                } ?>
          "><i class="material-icons" style="color:white;">arrow_back</i></a>
        </li>
      </ul>
    </nav>

    <?php
    if (isset($_GET['msg'])) {
      $msg = $_GET['msg'];
      if ($msg == "sucesso") {
        echo '<div class="alert alert-success" role="alert">
        <h6 class="texto-alertas">Cadastro realizado com Sucesso!</h6>
      </div>';
      }
      if ($msg == "dadosinvalidos") {
        echo '<div class="alert alert-danger" role="alert">
        <h6 class="texto-alertas">Você inseriu dados inválidos! Por favor verifique!</h6>
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
      <div class="principal" id="">
          <h3>Selecione:</h3>
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "todos") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaClientes.php?c_busca=todos">Buscar Todos os Cliente</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "nome") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaClientes.php?c_busca=nome">Nome</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "cpf_c") {
                                                        echo " active ";
                                                      }
                                                    } ?> "><a class="dropdown-item" href="../view/telaBuscaClientes.php?c_busca=cpf_c">CPF</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['c_busca'])) {
                                                      if ($_GET['c_busca'] == "telefone") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaClientes.php?c_busca=telefone">Telefone</a></li>

            </ul>
            </select>
          </div>
        </div>
      </div>

      <div class="col-3">

      <?php if (isset($_GET["c_busca"])) {
          echo "<br>";
          if ($_GET["c_busca"] == "todos") {
            $coluna = "todos";
            echo '<form id="meu_form" action="../control/ClienteControle.php?coluna=' . $coluna . '" method="post">
           <input type="text" hidden name="busca" value="todos">
        <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_cliente" name="bt_busca_cliente">  <i class="material-icons">search</i> Buscar</button>
              ';
          }

          if ($_GET["c_busca"] == "nome") {
            $coluna = "nome";

            echo '<form id="meu_form" action="../control/ClienteControle.php?coluna=' . $coluna . '" method="post">
          <div class="form-floating mb-3 ">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
              <label for="exampleFormControlInput1" class="form-label">Nome</label>
            </div>
            <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_cliente" name="bt_busca_cliente">  <i class="material-icons">search</i> Buscar</button>';
          }
          if ($_GET["c_busca"] == "cpf_c") {
            $coluna = "cpf_c";
echo '<form id="meu_form" action="../control/ClienteControle.php?coluna=' . $coluna . '" method="post">
          <div class="form-floating mb-3 ">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
              <label for="exampleFormControlInput1" class="form-label">CPF</label>
            </div>
            <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_cliente" name="bt_busca_cliente">  <i class="material-icons">search</i> Buscar</button>';
          }
          if ($_GET["c_busca"] == "telefone") {
            $coluna = "telefone";

            echo '<form id="meu_form" action="../control/ClienteControle.php?coluna=' . $coluna . '" method="post">
          <div class="form-floating mb-3 ">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
              <label for="exampleFormControlInput1" class="form-label">Telefone</label>
            </div>
            <button class="btn btn-success botao-enviar" type="submit" id="bt_busca_cliente" name="bt_busca_cliente">  <i class="material-icons">search</i> Buscar</button>'; }
        }
        ?>

      </div>
      <div class="col">

      </div>
    </div>
  </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="container text-center">
      <div class="row">
        <div class="col">

        </div>
        <div class="col">
          <div class="div-resultados">

            <?php
            include_once '../control/ClienteControle.php';
            if (isset($_GET['valor']) and isset($_GET['coluna'])) {
              $html = bt_buscar_cliente($_GET['valor'], $_GET['coluna']);

              if (isset($_GET['valor']) and isset($_GET['coluna'])) {
                if(!empty($html[0])){
                  echo '<br> <form method="post" action="telaBuscaClientes.php?valor=' . $_GET['valor'] . '&coluna=' . $_GET['coluna'] . '"><button class="btn btn-success botao-enviar" type="submit" id="bt_gerar_pdf" name="bt_gerar_pdf"></a> <h6><i class="material-icons">picture_as_pdf</i> Gerar PDF</h6></button></form>';

                }
              
                if (isset($_POST['bt_gerar_pdf'])) {
                  gerarPdfdosClientes($html);
                }

                $resultado = imprimirResultadosClientes($html);
                echo $resultado;
              }
            }
            ?>
          </div>
        </div>
        <div class="col">

        </div>
      </div>
    </div>

    <script src="../ajax/ajaxCadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../js.js"></script>

  </body>

  </html>