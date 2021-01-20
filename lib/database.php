<?php

class database {

    private $connectie;

    public function __construct() {

        $this->connectie = mysqli_connect('127.0.0.1',
                                          'root', 
                                          '', 
                                          'verrukkulluk');

    }

    public function getConnectie() {

        return($this->connectie);
    }

}