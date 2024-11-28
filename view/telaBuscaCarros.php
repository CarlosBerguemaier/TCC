<!DOCTYPE html>
  <html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Busca de Carros</title>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="../estilo.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #6AA6F9;">   
      <ul class="navbar-nav">
        <li class="nav-item custom">
          <a class="nav-link navbar-link" href="<?php if(isset($_GET['coluna'])){
            echo "../view/telaBuscaCarros.php";
          }else{
            echo "../view/index.php";
          }?>
          "><i class="material-icons">arrow_back</i></a>
        </li>
      </ul>
  </nav>

  <?php 
    if(isset($_GET['msg'])){
      if($msg == "naoencontrado"){
        echo '<div class="alert alert-danger" role="alert">
        <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
      </div>';
      }
    } 
  ?>

  

  <div class="principal">
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active bg-white border" id="carro" role="tabpanel" aria-labelledby="carro-tab"> 
        <div class="card-body">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle select" type="button" id="dropdownMenuButtonCarros" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Escolha o parâmetro para buscar
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCarros">
            <a class="dropdown-item" href="../view/telaBuscaCarros.php?f_busca=placa">Placa</a>
            <a class="dropdown-item" href="../view/telaBuscaCarros.php?f_busca=marca">Marca</a>
            <a class="dropdown-item" href="../view/telaBuscaCarros.php?f_busca=modelo">Modelo</a>
            <a class="dropdown-item" href="../view/telaBuscaCarros.php?f_busca=ano">Ano</a>
          </div>
            </div>
        
          <?php
          
          if(isset($_GET["f_busca"])){
            if($_GET["f_busca"] == "placa"){
              $coluna = "placa";
              echo '<form id="meu_form" action="../control/CarroControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite a placa do veículo:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_carro" name="bt_busca_carro">Buscar</button>';
            }
            if($_GET["f_busca"] == "marca"){
              $coluna = "marca";
              echo '<form id="meu_form" action="../control/CarroControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite a Marca do veículo:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_carro" name="bt_busca_carro">Buscar</button>';

            }
            if($_GET["f_busca"] == "modelo"){
              $coluna = "modelo";
              echo '<form id="meu_form" action="../control/CarroControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite o Modelo do veículo:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_carro" name="bt_busca_carro">Buscar</button>';
            }
            if($_GET["f_busca"] == "ano"){
                $coluna = "ano";
                echo '<form id="meu_form" action="../control/CarroControle.php?coluna='.$coluna.'" method="post">';
                echo "<h3>Digite o ano do veículo:</h3><input type='text' name='busca'>";
                echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_carro" name="bt_busca_carro">Buscar</button>';
              }
          }
            ?>
      </form>
    </div></div>
    </div>
    </div>
  <div class="div-resultados">
  
  <?php 
      include_once '../control/CarroControle.php';
      if(isset($_GET['valor']) and isset($_GET['coluna'])){
      $html = bt_buscar_carros($_GET['valor'],$_GET['coluna']);
      if(isset($_GET['valor']) and isset($_GET['coluna'])){
        echo '<form method="post" action="telaBuscaCarros.php?valor='.$_GET['valor'].'&coluna='.$_GET['coluna'].'"><button class="btn btn-success botao-enviar" type="submit" id="bt_gerar_pdf" name="bt_gerar_pdf"></a> <h6><i class="material-icons">picture_as_pdf</i> Gerar PDF</h6></button></form>';
        
        if(isset($_POST['bt_gerar_pdf'])){
          gerarPdfdosCarros($html);
          }
        
        $resultado = imprimirResultadosCarros($html);
        echo $resultado;
        }
      }
      ?>
  </div>

  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="../js.js"></script>
  </html>