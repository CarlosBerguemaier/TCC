<?php
class Servico{
    private $id;
    private $descricao;


    public function getId() {return $this->id;}
    public function getDescricao() {return $this->descricao;}


    public function setId($id){$this->id = $id;}
    public function setDescricao($descricao){$this->descricao = $descricao;}

}

?>