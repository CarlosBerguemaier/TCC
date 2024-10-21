<?php

class Carro{
    private $id;
    private $placa;
    private $marca;
    private $modelo;
    private $ano;

    public function getId() {return $this->id;}
    public function getPlaca() {return $this->placa;}
    public function getMarca() {return $this->marca;}
    public function getModelo() {return $this->modelo;}
    public function getAno() {return $this->ano;}

    public function setId($id){$this->id = $id;}
    public function setPlaca($placa){$this->placa = $placa;}
    public function setMarca($marca){$this->marca = $marca;}
    public function setModelo($modelo){$this->modelo = $modelo;}
    public function setAno($ano){$this->ano = $ano;}
}

?>