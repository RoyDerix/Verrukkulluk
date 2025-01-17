<?php

class boodschappenlijst {

    private $connectie;
    private $ingredient;
    private $artikel;


    public function plusArtikel($artikel_id, $gebruiker_id) {
        $sql = "SELECT * FROM boodschappen WHERE artikel_id = $artikel_id
                                            AND gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $aantal_verpakkingen = $row['aantal_verpakkingen'];
        $aantal_verpakkingen += 1;
        $sql = "UPDATE boodschappen 
                SET aantal_verpakkingen = $aantal_verpakkingen
                WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
    }

    public function minArtikel($artikel_id, $gebruiker_id) {
        $sql = "SELECT * FROM boodschappen WHERE artikel_id = $artikel_id
                AND gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $aantal_verpakkingen = $row['aantal_verpakkingen'];
        $aantal_verpakkingen -= 1;
        $sql = "UPDATE boodschappen 
                SET aantal_verpakkingen = $aantal_verpakkingen
                WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
        return($aantal_verpakkingen);
    }

    public function verwijderenLijst($gebruiker_id) {
        $sql = "DELETE FROM boodschappen WHERE gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
    }

    public function verwijderenArtikel($artikel_id, $gebruiker_id) {

        $sql = "DELETE FROM boodschappen WHERE gebruiker_id = $gebruiker_id 
                                        AND artikel_id = $artikel_id";
        $result = mysqli_query($this->connectie, $sql);
    }

    public function ophalenLijst($gebruiker_id = null) {

        $mijn_lijst = [];

        $sql = "SELECT * FROM boodschappen WHERE gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $artikel_id = $row['artikel_id'];
            $art = $this->artikel->selecteerArtikel($artikel_id);
            $mijn_lijst[] = [
                "artikel_id"=>$art["id"],
                "titel_artikel"=>$art["titel_artikel"],
                "artikelbeschrijving"=>$art["artikelbeschrijving"],
                "artikelfoto"=>$art["artikelfoto"],
                "calorieen_per_artikel"=>$art["calorieen_per_artikel"],
                "prijs_per_artikel"=>$art["prijs_per_artikel"],
                "aantal_verpakkingen"=>$row["aantal_verpakkingen"],
            ];
        }

        return($mijn_lijst);
    }

    public function toevoegenRecept($recept_id, $gebruiker_id = null) {

        $ingredienten = $this->ingredient->selecteerIngredient($recept_id);
        foreach($ingredienten as $ingredient) {

            $artikel_id = $ingredient["artikel_id"];
            $row = $this->artikelOpLijst($artikel_id, $gebruiker_id);
            if($row) {
                $this->updateLijst($artikel_id, $gebruiker_id, $row, $ingredient);
            }

            else{
                $this->toevoegenLijst($artikel_id, $gebruiker_id, $ingredient);
            }
        }
    }

    private function updateLijst($artikel_id, $gebruiker_id, $row, $ingredient) {

        $ingredienthoeveelheid = $row['ingredienthoeveelheid'] + $ingredient['ingredienthoeveelheid'];
        $aantal_verpakkingen = ceil($ingredienthoeveelheid / $ingredient['hoeveelheid']);
        $sql = "UPDATE boodschappen 
                SET ingredienthoeveelheid = '$ingredienthoeveelheid', 
                    aantal_verpakkingen = '$aantal_verpakkingen'
                WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
    }

    private function toevoegenLijst($artikel_id, $gebruiker_id, $ingredient) {

        $ingredienthoeveelheid = $ingredient["ingredienthoeveelheid"];
        $aantal_verpakkingen = ceil($ingredienthoeveelheid / $ingredient['hoeveelheid']);
        $sql = "INSERT INTO boodschappen (artikel_id, gebruiker_id, ingredienthoeveelheid, aantal_verpakkingen)
                    VALUES ('$artikel_id', '$gebruiker_id', '$ingredienthoeveelheid', '$aantal_verpakkingen')";
        $result = mysqli_query($this->connectie, $sql);
    }

    private function artikelOpLijst($artikel_id, $gebruiker_id) {

        $sql = "SELECT * FROM boodschappen WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            return($row);
        }
    }

    public function __construct($connectie) {
        $this->connectie = $connectie;
        $this->ingredient = new ingredient($this->connectie);
        $this->artikel = new artikel($this->connectie);
    }
}