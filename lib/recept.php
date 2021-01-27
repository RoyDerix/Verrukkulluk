<?php

class recept {

    private $connectie;
    private $recept_info;
    private $ingredienten;
    private $favoriet;
    private $keuken_type;
    private $gebruiker;

    public function ophalenRecept($gebruiker_id = null, $id = null) {

        $receptTotaal = [];
        $sql = "SELECT * FROM recept";
        if($id != null) {
            $sql .= " WHERE id = $id";
        }
        $result = mysqli_query($this->connectie, $sql);

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $gem_score = $this->berekenenScore($row['id']);
            $ingredienten = $this->ophalenIngredienten($row['id']);
            $totale_prijs = $this->berekenenPrijs($ingredienten);
            $totale_calorieen = $this->berekenCalorieen($ingredienten);
            $mijnFavoriet = $this->vergelijkenFavoriet($row['id'], $gebruiker_id);
            $keuken = $this->ophalenKeuken($row['keuken_id']);
            $type = $this->ophalenType($row['type_id']);
            $gebruiker = $this->ophalenGebruiker($row['gebruiker_id']);
            $bereidingswijze = $this->ophalenBereidingswijze($row['id']);
            $opmerkingen = $this->ophalenOpmerkingen($row['id']);

            $ditRecept = [
                "id"=>$row['id'],
                "titel_recept"=>$row['titel_recept'],
                "keuken"=>$keuken['omschrijving'],
                "type"=>$type['omschrijving'],
                "auteur"=>$gebruiker['gebruiker_naam'],
                "receptbeschrijving"=>$row['receptbeschrijving'],
                "samenvatting_beschrijving"=>$row['samenvatting_beschrijving'],
                "receptfoto"=>$row['receptfoto'],
                "datum_toegevoegd"=>$row['datum_toegevoegd'],
                "score"=>$gem_score,
                "totale_prijs"=>$totale_prijs,
                "totale_calorieen"=>$totale_calorieen,
                "mijn_favoriet"=>$mijnFavoriet,
                "ingredienten"=>$ingredienten,
                "bereidingswijze"=>$bereidingswijze,
                "opmerkingen"=>$opmerkingen
            ];
            
            $receptenTotaal[] = $ditRecept;
        }

        return($receptenTotaal);
    }


    public function zoeken($keyword, $gebruiker_id = null) {

        $lijst = [];
        $alleRecepten = $this->ophalenRecept($gebruiker_id, null);

        foreach($alleRecepten as $recept) {

            $recept_encode = json_encode($recept, JSON_INVALID_UTF8_IGNORE);
            $recept_pos = stripos($recept_encode, $keyword);
            if ($recept_pos !== false) {
                $lijst[] = $recept;
            }
        }

        return($lijst);
    }
    
    private function ophalenGebruiker($gebruiker_id) {
        
        $gebruiker = $this->gebruiker->selecteerGebruiker($gebruiker_id);
        return($gebruiker);
    }

    private function ophalenType($type_id) {

        $type = $this->keuken_type->selecteerKeukenType($type_id);
        return($type);
    }

    private function ophalenKeuken($keuken_id) {

        $keuken = $this->keuken_type->selecteerKeukenType($keuken_id);
        return($keuken);
    }

    private function vergelijkenFavoriet($recept_id, $gebruiker_id) {
        
        $mijnFavoriet = FALSE;
        if($gebruiker_id != null) {
            $favorieten = $this->recept_info->selecteerReceptinfo($recept_id, "F");
            foreach($favorieten as $favoriet) {
                if ($favoriet['gebruiker_id'] == $gebruiker_id) {
                    $mijnFavoriet = TRUE;
                }
            }
        }

        return($mijnFavoriet);
    }

    private function berekenCalorieen($ingredienten) {

        $totale_calorieen = 0;

        foreach($ingredienten as $ingredient) {
            $aantal_verpakkingen = $ingredient['ingredienthoeveelheid'] / $ingredient['hoeveelheid'];
            $calorieen_per_ingredient = $aantal_verpakkingen * $ingredient['calorieen_per_artikel'];
            $totale_calorieen += $calorieen_per_ingredient;
        }

        return($totale_calorieen);
    }

    private function berekenenPrijs($ingredienten) {

        $totale_prijs = 0;

        foreach($ingredienten as $ingredient) {
            $aantal_verpakkingen = ceil($ingredient['ingredienthoeveelheid'] / $ingredient['hoeveelheid']);
            $prijs_ingredient = $aantal_verpakkingen * $ingredient['prijs_per_artikel'];
            $totale_prijs += $prijs_ingredient;
        }

        return($totale_prijs);
    }

    private function berekenenScore($recept_id) {

        $som_scores = 0;
        $aantal_scores = 0;
        $data_scores = $this->recept_info->selecteerReceptinfo($recept_id, "S");
        foreach($data_scores as $data_score) {
            $som_scores += $data_score['nummeriekveld'];
            $aantal_scores++;
        }
        $gem_score = round($som_scores / $aantal_scores);
        return($gem_score);
    }

    private function ophalenBereidingswijze($recept_id) {
        $bereidingswijze = $this->recept_info->selecteerReceptinfo($recept_id, "B");
        return($bereidingswijze);
    }

    private function ophalenOpmerkingen($recept_id) {
        $opmerkingen = $this->recept_info->selecteerReceptinfo($recept_id, "O");
        return($opmerkingen);
    }

    private function ophalenIngredienten($recept_id) {
        $data_ingredienten = $this->ingredienten->selecteerIngredient($recept_id);
        return($data_ingredienten);
    }

    public function __construct($connectie) {
        $this->connectie = $connectie;
        $this->recept_info = new recept_info($this->connectie);
        $this->ingredienten = new ingredient($this->connectie);
        $this->keuken_type = new keuken_type($this->connectie);
        $this->gebruiker = new gebruiker($this->connectie);
    }
}