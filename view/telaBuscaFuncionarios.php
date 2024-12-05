  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Busca de Funcionários</title>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="../estilo.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body style="background-color:rgb(213, 232, 252);">

  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #6AA6F9;">   
      <ul class="navbar-nav">
        <li class="nav-item custom">
          <a class="nav-link navbar-link" href="<?php if(isset($_GET['coluna'])){
            echo "../view/telaBuscaFuncionarios.php";
          }else{
            echo "../view/index.php";
          }?>
          "><i class="material-icons" style="color:white;">arrow_back</i></a>
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
    <div class="tab-pane fade show active bg-white border" id="servico" role="tabpanel" aria-labelledby="servico-tab"> 
        <div class="card-body">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle select" type="button" id="dropdownMenuButtonFuncionarios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Escolha o parâmetro para buscar
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonFuncionarios">
            <a class="dropdown-item" href="../view/telaBuscaFuncionarios.php?f_busca=nome">Nome</a>
            <a class="dropdown-item" href="../view/telaBuscaFuncionarios.php?f_busca=cpf_f">CPF do Funcionário</a>
            <a class="dropdown-item" href="../view/telaBuscaFuncionarios.php?f_busca=telefone">Telefone</a>
          </div>
            </div>
        
          <?php
          
          if(isset($_GET["f_busca"])){
            if($_GET["f_busca"] == "nome"){
              $coluna = "nome";
              echo '<form id="meu_form" action="../control/FuncionarioControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite o Nome do funcionário:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_funcionario" name="bt_busca_funcionario">Buscar</button>';
            }
            if($_GET["f_busca"] == "cpf_f"){
              $coluna = "cpf_f";
              echo '<form id="meu_form" action="../control/FuncionarioControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite o CPF do Funcionário:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_funcionario" name="bt_busca_funcionario">Buscar</button>';

            }
            if($_GET["f_busca"] == "telefone"){
              $coluna = "telefone";
              echo '<form id="meu_form" action="../control/FuncionarioControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite o telefone do funcionário:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_funcionario" name="bt_busca_funcionario">Buscar</button>';
            }
          }
            ?>
      </form>
    </div></div>
    </div>
    </div>
  <div class="div-resultados">
  
  <?php 
      include_once '../control/FuncionarioControle.php';
      if(isset($_GET['valor']) and isset($_GET['coluna'])){
      $html = bt_buscar_funcionarios($_GET['valor'],$_GET['coluna']);
      if(isset($_GET['valor']) and isset($_GET['coluna'])){
      echo '<form method="post" action="telaBuscaFuncionarios.php?valor='.$_GET['valor'].'&coluna='.$_GET['coluna'].'"><button class="btn btn-success botao-enviar" type="submit" id="bt_gerar_pdf" name="bt_gerar_pdf"></a> <h6><i class="material-icons">picture_as_pdf</i> Gerar PDF</h6></button></form>';
      
      if(isset($_POST['bt_gerar_pdf'])){
        gerarPdfdosFuncionarios($html);
        }
      
      $resultado = imprimirResultadosFuncionarios($html);
      echo $resultado;
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