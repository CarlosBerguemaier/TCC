
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
            echo "../view/telaBuscaOrdemServico.php";
          }else{
            echo "../view/index.php";
          }?>
          "><i class="material-icons"style="color:white;">arrow_back</i></a>
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
      if($msg == "naoencontrado"){
        echo '<div class="alert alert-danger" role="alert">
        <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
      </div>';
      }
    } 
  ?>

<div class="container text-center" <?php if(!isset($_GET['sv_busca']) and isset($_GET['coluna'])){ echo " hidden ";}?> style="margin-top: 2%;">

  <div class="row">
    <div class="col">
    <h3>Selecione o campo a buscar</h3>
    <div class="principal" id="">
        <div class="card-body">
  <ul class="list-group">
  <li class="list-group-item listgroup <?php if(isset($_GET['sv_busca'])){  if($_GET['sv_busca'] == "todos"){echo " active ";}}?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=todos">Buscar Todos os Serviços</a></li>
  <li class="list-group-item listgroup <?php if(isset($_GET['sv_busca'])){  if($_GET['sv_busca'] == "placa"){echo " active ";}}?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=placa">Placa do Veículo</a></li>
  <li class="list-group-item listgroup <?php if(isset($_GET['sv_busca'])){  if($_GET['sv_busca'] == "cpf_c"){echo " active ";}}?> "><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=cpf_c">CPF do cliente</a></li>
  <li class="list-group-item listgroup <?php if(isset($_GET['sv_busca'])){  if($_GET['sv_busca'] == "cpf_f"){echo " active ";}}?> "><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=cpf_f">CPF do Funcionário</a></li>
  <li class="list-group-item listgroup <?php if(isset($_GET['sv_busca'])){  if($_GET['sv_busca'] == "descricao"){echo " active ";}}?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=descricao">Descrição</a></li>
  <li class="list-group-item listgroup <?php if(isset($_GET['sv_busca'])){  if($_GET['sv_busca'] == "valor"){echo " active ";}}?>"><a class="dropdown-item" href="../view/telaBuscaOrdemServico.php?sv_busca=valor">Valor</a></li>
</ul>
</select> </div>
            </div>
    </div>
    
    <div class="col-3">

        
    <?php
          
          if(isset($_GET["sv_busca"])){
            if($_GET["sv_busca"] == "todos"){
              $coluna = "todos";
              echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';
            }
            if($_GET["sv_busca"] == "cpf_c"){
              $coluna = "cpf_c";
              echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
              echo "<h4>Digite o CPF do cliente:</h4><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';
            }
            if($_GET["sv_busca"] == "cpf_f"){
              $coluna = "cpf_f";
              echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
              echo "<h4>Digite o CPF do Funcionário:</h4><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

            }
            if($_GET["sv_busca"] == "placa"){
              $coluna = "placa";
              echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
              echo "<h4>Digite a placa do veículo:</h4><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

            }
            if($_GET["sv_busca"] == "valor"){
              $coluna = "valor";
              echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
              echo "<h4>Digite o valor do serviço:</h4><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

            }
            if($_GET["sv_busca"] == "descricao"){
              $coluna = "descricao";
              echo '<form id="meu_form" action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
              echo "<h4>Digite a descrição do serviço:</h4><input type='text' name='busca'>";
              echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

            }
          }
            ?>
      </form>

 


    </div>
    <div class="col">
      
    </div>
  </div>
</div>
    </div></div>

    <div class="container text-center">
  <div class="row">
  <div class="col"></div>
    <div class="col-md-auto ">
    <div class="div-resultados ">
  <?php    
         include_once '../control/OrdemServicoControle.php';
         include_once '../control/gerarPdf.php';
         if(isset($_GET['valor']) and isset($_GET['coluna'])){
          echo "<br>";

          echo "
          <div class=\"container text-center\">
  <div class=\"row\">
    <div class=\"col\">
      <form method=\"post\" action=\"telaBuscaOrdemServico.php\"><button class=\"btn btn-success botao-enviar\" type=\"submit\" id=\"bt_voltar\" name=\"bt_voltar\"></a> <h6><i class=\"material-icons\">arrow_back</i> Voltar</h6></button></form>
    </div>
    <div class=\"col\">
      <form method=\"post\" action=\"telaBuscaOrdemServico.php?valor=" . $_GET['valor'] . "&coluna=" . $_GET['coluna'] . "\"><button class=\"btn btn-success botao-enviar\" type=\"submit\" id=\"bt_gerar_pdf\" name=\"bt_gerar_pdf\"></a> <h6><i class=\"material-icons\">picture_as_pdf</i> Gerar PDF</h6></button></form>
    </div>
    <div class=\"col\">
      
    </div>
  </div>
</div>";

         $html = bt_buscar_os($_GET['valor'],$_GET['coluna']);
         if(isset($_POST['bt_gerar_pdf'])){
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

    

 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="../js.js"></script>
  </body>
  </html>