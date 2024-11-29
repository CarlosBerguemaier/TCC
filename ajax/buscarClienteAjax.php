<?php
// Verifica se existe a variável txtnome
if (isset($_GET["txtnome"])) {
    $nome = $_GET["txtnome"];

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
         "<td>". "<button class=\"btn btn-primary bt-select\" id=\"".$cliente->getCpf()."\" data-bs-dismiss=\"modal\" onclick=\"atualizarCpf_clientes(this.id)\">Selecionar</button>" ."</td>".
         " </tr>";
    }
    echo "</tbody> 
        </table>";
}}
?>