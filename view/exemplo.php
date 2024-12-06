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