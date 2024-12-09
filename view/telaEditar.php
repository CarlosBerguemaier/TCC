<!DOCTYPE html>
  <html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>tela de serviços</title>

  <link rel="stylesheet" href="../estilo.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #6AA6F9;">   
      <ul class="navbar-nav">
        <li class="nav-item custom">
          <a class="nav-link navbar-link" href="index.php"><i class="material-icons">arrow_back</i></a>
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
    if(isset($_GET['msg'])){
      $msg=$_GET['msg'];
      if($msg == "sucesso"){
        echo '<div class="alert alert-success" role="alert">
        <h6 class="texto-alertas">Cadastro realizado com Sucesso!</h6>
      </div>';
      }
      if($msg == "dadosinvalidos"){
        echo '<div class="alert alert-danger" role="alert">
        <h6 class="texto-alertas">Voce inseriu dados inválidos! Por favor verifique!</h6>
      </div>';
      }
      if($msg == "naoencontrado"){
        echo '<div class="alert alert-danger" role="alert">
        <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
      </div>';
      }
    } 
?>
<br>

<div class="container">
  <div class="row">
    <div class="col">
    </div>
    <div class="col-6">
    <div class="principal"><h1>Editar dados</h1></div>
    </div>
    <div class="col">
    </div>
  </div>
</div>


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



<script src="../ajax/ajaxCadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="../js.js"></script>
  </body>
  </html>