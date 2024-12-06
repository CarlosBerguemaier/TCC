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
          <a class="nav-link navbar-link" href="<?php if(isset($_GET['coluna'])){
            echo "../view/telaBuscaClientes.php";
          }else{
            echo "../view/index.php";
          }?>
          "><i class="material-icons" style="color:white;">arrow_back</i></a>
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
        <h6 class="texto-alertas">Você inseriu dados inválidos! Por favor verifique!</h6>
      </div>';
      }
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
          <button class="btn btn-primary dropdown-toggle select" type="button" id="dropdownMenuButtonClientes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Escolha o parâmetro para buscar
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonClientes">
            <a class="dropdown-item" href="../view/telaBuscaClientes.php?c_busca=nome">Nome</a>
            <a class="dropdown-item" href="../view/telaBuscaClientes.php?c_busca=cpf_c">CPF do cliente</a>
            <a class="dropdown-item" href="../view/telaBuscaClientes.php?c_busca=telefone">Telefone</a>
          </div>
            </div>
        
          <?php
          
          if(isset($_GET["c_busca"])){
            if($_GET["c_busca"] == "nome"){
              $coluna = "nome";
              echo '<form id="meu_form" action="../control/ClienteControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite o Nome cliente:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_cliente" name="bt_busca_cliente">Buscar</button>';
            }
            if($_GET["c_busca"] == "cpf_c"){
              $coluna = "cpf_c";
              echo '<form id="meu_form" action="../control/ClienteControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite o CPF do Cliente:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_cliente" name="bt_busca_cliente">Buscar</button>';

            }
            if($_GET["c_busca"] == "telefone"){
              $coluna = "telefone";
              echo '<form id="meu_form" action="../control/ClienteControle.php?coluna='.$coluna.'" method="post">';
              echo "<h3>Digite o telefone do cliente:</h3><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_cliente" name="bt_busca_cliente">Buscar</button>';
            }
          }
            ?>
      </form>
    </div></div>
    </div>
    </div>
  <div class="div-resultados">
  
  <?php 
      include_once '../control/ClienteControle.php';
      if(isset($_GET['valor']) and isset($_GET['coluna'])){
      $html = bt_buscar_cliente($_GET['valor'],$_GET['coluna']);

      if(isset($_GET['valor']) and isset($_GET['coluna'])){
        echo '<form method="post" action="telaBuscaClientes.php?valor='.$_GET['valor'].'&coluna='.$_GET['coluna'].'"><button class="btn btn-success botao-enviar" type="submit" id="bt_gerar_pdf" name="bt_gerar_pdf"></a> <h6><i class="material-icons">picture_as_pdf</i> Gerar PDF</h6></button></form>';
        
        if(isset($_POST['bt_gerar_pdf'])){
          gerarPdfdosClientes($html);
          }
        
        $resultado = imprimirResultadosClientes($html);
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