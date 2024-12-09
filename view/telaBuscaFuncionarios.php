  <!DOCTYPE html>
  <html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Listar Funcionários</title>
      <link rel="stylesheet" href="../estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

 </head>
  <body ">

  <nav class="navbar navbar-light bg-light nav_bar">
    <div class="container-fluid justify-content-around">
      <h1><a href="../view/index.php"><img src="../images/logo.webp" alt="logo da oficina" style="width:50px;"></h1></a>
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
        <h6 class="texto-alertas">Você inseriu dados inválidos! Por favor verifique!</h6>
      </div>';
      }
      if ($msg == "naoencontrado") {
        echo '<div class="alert alert-danger" style="text-align:center" role="alert">
        <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
      </div>';
      }
    }
    ?>

  
<div class="container text-center central" <?php if (!isset($_GET['sv_busca']) and isset($_GET['coluna'])) {
                                        echo " hidden ";
                                      } ?> style="margin-top: 2%;">

    <div class="row central" >
      <div class="col">
      <div class="menulateral" id="">
      <form method="post" action="index.php"><button class="btn btn-dark botao-enviar m-1" type="submit" id="bt_voltar" name="bt_voltar"></a>
              <h6><i class="material-icons">arrow_back</i> Voltar ao Início</h6>
            </button></form>
          <h3>Selecione:</h3>
          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item listgroup <?php if (isset($_GET['f_busca'])) {
                                                      if ($_GET['f_busca'] == "todos") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaFuncionarios.php?f_busca=todos">Buscar Todos os Funcionários</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['f_busca'])) {
                                                      if ($_GET['f_busca'] == "nome") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaFuncionarios.php?f_busca=nome">Nome</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['f_busca'])) {
                                                      if ($_GET['f_busca'] == "cpf_f") {
                                                        echo " active ";
                                                      }
                                                    } ?> "><a class="dropdown-item" href="../view/telaBuscaFuncionarios.php?f_busca=cpf_f">CPF</a></li>
              <li class="list-group-item listgroup <?php if (isset($_GET['f_busca'])) {
                                                      if ($_GET['f_busca'] == "telefone") {
                                                        echo " active ";
                                                      }
                                                    } ?>"><a class="dropdown-item" href="../view/telaBuscaFuncionarios.php?f_busca=telefone">Telefone</a></li>

            </ul>
            </select>
          </div>
        </div>
      </div>

      <div class="col-3">

      <?php if (isset($_GET["f_busca"])) {
          echo "<br>";
          if ($_GET["f_busca"] == "todos") {
            $coluna = "todos";
            echo '<form id="meu_form" action="../control/FuncionarioControle.php?coluna=' . $coluna . '" method="post">
           <input type="text" hidden name="busca" value="todos">';
          }

          if ($_GET["f_busca"] == "nome") {
            $coluna = "nome";

            echo '<form id="meu_form" action="../control/FuncionarioControle.php?coluna=' . $coluna . '" method="post">
          <div class="form-floating mb-3 ">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
              <label for="exampleFormControlInput1" class="form-label">Nome</label>
            </div>';
          }
          if ($_GET["f_busca"] == "cpf_f") {
            $coluna = "cpf_f";

            echo '<form id="meu_form" action="../control/FuncionarioControle.php?coluna=' . $coluna . '" method="post">
          <div class="form-floating mb-3 ">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
              <label for="exampleFormControlInput1" class="form-label">CPF</label>
            </div>';
          }
          if ($_GET["f_busca"] == "telefone") {
            $coluna = "telefone";


            echo '<form id="meu_form" action="../control/FuncionarioControle.php?coluna=' . $coluna . '" method="post">
          <div class="form-floating mb-3 ">
              <input type="text" name="busca" class="form-control" id="exampleFormControlInput1" placeholder="">
              <label for="exampleFormControlInput1" class="form-label">Telefone</label>
            </div>';
   }

        echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_funcionario" name="bt_busca_funcionario"><i class="material-icons">search</i> Buscar</button>
    </form>';

  }
        ?>

      </div>
      <div class="col">

      </div>
    </div>
  </div>
  <div class="container text-center w-100">
    <div class="row w-auto">
      <div class="col"></div>
      <div class="col-md-auto w-100 ">
        <div class="div-resultados text-center" style="align-self :center;">
  
  <?php 
       include_once '../control/gerarPdf.php';
       if (isset($_GET['valor']) and isset($_GET['coluna'])) {
         echo "<br>";

         echo "
       <div class=\"container text-center\">
<div class=\"row\">
 <div class=\"col\">
   <form method=\"post\" action=\"telaBuscaFuncionarios.php\"><button class=\"btn btn-dark botao-enviar\" type=\"submit\" id=\"bt_voltar\" name=\"bt_voltar\"></a> <h6><i class=\"material-icons\">arrow_back</i> Voltar</h6></button></form>
 </div>
 <div class=\"col\">
   <form method=\"post\" action=\"telaBuscaFuncionarios.php?valor=" . $_GET['valor'] . "&coluna=" . $_GET['coluna'] . "\"><button class=\"btn btn-danger botao-enviar\" type=\"submit\" id=\"bt_gerar_pdf\" name=\"bt_gerar_pdf\"></a> <h6><i class=\"material-icons\">picture_as_pdf</i> Gerar PDF</h6></button></form>
 </div>
 <div class=\"col\">
   
 </div>
</div>
</div>
<br>";

         include_once '../control/FuncionarioControle.php';
             if(!empty($_GET['valor']) and !empty($_GET['coluna'])){
            $html = bt_buscar_funcionarios($_GET['valor'], $_GET['coluna']);
           }
           if(empty($html[0])){
             header('Location: telaBuscaFuncionarios.php?msg=naoencontrado');
             }
             if (isset($_POST['bt_gerar_pdf'])) {
               gerarPdfdosFuncionarios($html);
             }

             $resultado = imprimirResultadosFuncionarios($html);
             echo $resultado;
           }


      ?>
        </div>
      </div>
      <div class="col"></div>
    </div>
  </div>
  <script src="../js.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
  
  </html>