<?php

class ingredient {

    private $connectie;
    private $artikel;

    public function __construct($connectie) {

        $this->connectie = $connectie;
        $this->artikel = new artikel($this->connectie);
    }

    public function selecteerIngredient($recept_id) {

        $sql = "SELECT * FROM ingredient WHERE recept_id = $recept_id";
        $result = mysqli_query($this->connectie, $sql);
        $data = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $art = $this->selecteerArtikel($row['artikel_id']);
            $data[] = ["id"=>$row["id"],
                        "artikel_id"=>$art["id"],
                        "recept_id"=>$row["recept_id"],
                        "titel_artikel"=>$art["titel_artikel"],
                        "artikelbeschrijving"=>$art["artikelbeschrijving"],
                        "artikelfoto"=>$art["artikelfoto"],
                        "calorieen_per_artikel"=>$art["calorieen_per_artikel"],
                        "prijs_per_artikel"=>$art["prijs_per_artikel"],
                        "hoeveelheid"=>$art["hoeveelheid"],
                        "verpakking"=>$art["verpakking"],
                        "ingredienthoeveelheid"=>$row["ingredienthoeveelheid"]
                    ];
        }

        return($data);
    }

    private function selecteerArtikel($artikel_id){

        $artikel_info = $this->artikel->selecteerArtikel($artikel_id);
        return($artikel_info);
    }
}