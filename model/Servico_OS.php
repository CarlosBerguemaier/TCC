<?php
class ServicoOS{
    private $id_os;
    private $id_servico;


    public function getIdos() {return $this->id_os;}
    public function getIdservico() {return $this->id_servico;}
    
    public function setIdos($id_os){$this->id_os = $id_os;}
    public function setIdservico($id_servico){$this->id_servico = $id_servico;}
}

?>