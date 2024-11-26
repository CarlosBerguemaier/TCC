  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>tela de serviços</title>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="../estilo.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
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
      imprimirResultadosClientes($html);
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