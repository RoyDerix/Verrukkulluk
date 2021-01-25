<?php

class boodschappenlijst {

    private $connectie;
    private $recept;

    public function receptToevoegen($recept_id, $gebruiker_id = null) {

        $recept = $this->recept->ophalenRecept($gebruiker_id, $recept_id);
        $ingredienten = $recept[0]['ingredienten'];
        foreach($ingredienten as $ingredient) {
            $artikel_id = $ingredient["artikel_id"];
            $ingredienthoeveelheid = $ingredient["ingredienthoeveelheid"];
            $sql = "SELECT * FROM boodschappen WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
            $result = mysqli_query($this->connectie, $sql);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $ingredienthoeveelheid = $row['ingredienthoeveelheid'] + $ingredient['ingredienthoeveelheid'];
                $aantal_verpakkingen = ceil($ingredienthoeveelheid / $ingredient['hoeveelheid']);
                $sql = "DELETE FROM boodschappen WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
                $result = mysqli_query($this->connectie, $sql);
            }

            else{
                $aantal_verpakkingen = ceil($ingredient['ingredienthoeveelheid'] / $ingredient['hoeveelheid']);
            }

            $sql = "INSERT INTO boodschappen (artikel_id, gebruiker_id, ingredienthoeveelheid, aantal_verpakkingen)
            VALUES ('$artikel_id', '$gebruiker_id', '$ingredienthoeveelheid', '$aantal_verpakkingen')";
            $result = mysqli_query($this->connectie, $sql);      
        }
    }

    public function __construct($connectie) {
        $this->connectie = $connectie;
        $this->recept = new recept($this->connectie);
    }
}