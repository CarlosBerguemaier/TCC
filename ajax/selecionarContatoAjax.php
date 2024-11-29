<?php
// Verifica se existe a variável txtnome
if (isset($_GET["cpf"])) {
    $nome = $_GET["cpf"];

   include_once '../control/ClienteControle.php';


   $clientes = buscarCliente($nome,"nome");

   if (empty($clientes)) {
    echo "Não há dados para exibir.";
    return;
}
    $cliente = $clientes[0];
    if(empty($cliente)){
        echo "Nenhum dado foi encontrado!";
}else{
    echo "<table id=\"tabelabusca\"  border='1' width=\"100%\" cellspacing=\"10\">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
    </thead>
            <tbody>";
    foreach ($clientes as $cliente) {
        echo "<tr><td>" . $cliente->getNome() . "</td>".
         "<td>" . $cliente->getCpf() . "</td>" .
         "<td>" . $cliente->getTelefone() . "</td>".
         "<td>". "<button class=\"btn btn-primary bt-select\" name=\"select_cliente\" id=\"total\" value=\"".$cliente->getCpf()."\" onclick=\"alertar()\">Selecionar ".$cliente->getCpf()."</button>" ."</td>".
         " </tr>";
    }
    echo "</tbody> 
        </table>";
}}
?>