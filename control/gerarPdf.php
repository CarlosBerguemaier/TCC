<?php
    use Dompdf\Dompdf;
    require '../control/vendor/autoload.php';
    function gerarPdf($texto){
        ob_clean();
    $dompdf = new Dompdf();
    $dompdf->loadHtml(html_entity_decode($texto));
    $dompdf->setPaper('A4' , 'portrait');
    $dompdf->render();
    $dompdf->stream();
    }
?>
