<?php

class gebruiker {

    private $connectie;

    public function __construct($connectie) {
        $this->connectie = $connectie;
    }

    public function selecteerGebruiker($gebruiker_id) {
        $sql = "SELECT * FROM gebruiker WHERE id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $row;
    }
}