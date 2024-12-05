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
<div class="principal"><h1>Editar dados</h1></div>

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



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="../js.js"></script>
  </body>
  </html>