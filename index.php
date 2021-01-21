<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/gebruiker.php");
require_once("lib/keuken_type.php");
require_once("lib/recept_info.php");
require_once("lib/ingredient.php");
require_once("lib/recept.php");

$db = new database();
$conn = $db->getConnectie();
$art = new artikel($conn);
$gebr = new gebruiker($conn);
$kt = new keuken_type($conn);
$ri = new recept_info($conn);
$ing = new ingredient($conn);
$recept = new recept($conn);

$artikel_id = 2;
$gebruiker_id = 4;
$keuken_type_id = [2, 6];
$recept_id = 3;

$data_recept = $recept->selecteerRecept($recept_id);
echo"Dit is het hele recept: <br><br><pre>";
var_dump($data_recept);

echo"<br><br></pre>";

$data_art = $art->selecteerArtikel($artikel_id);
$data_gebr = $gebr->selecteerGebruiker($gebruiker_id);

echo "Artikel: <pre>";
var_dump($data_art);

echo "</pre><br>Gebruiker: <pre>";
var_dump($data_gebr);


foreach($keuken_type_id as $id) {

    $data_keuken_type = $kt->selecteerKeukenType($id);


    if($data_keuken_type['record_type'] == 'K') {
        echo "</pre><br>Keuken: <pre>";
        var_dump($data_keuken_type);
    }

    elseif($data_keuken_type['record_type'] == 'T') {
        echo "</pre><br>Type: <pre>";
        var_dump($data_keuken_type);
    }

}

$recept_id = 1;
$record_type = "B";
$data_recept_info = $ri->selecteerReceptinfo($recept_id, $record_type);

echo"</pre><br>Bereidingswijze: <br>";
foreach($data_recept_info as $info) {
    echo $info['nummeriekveld'] .". " .$info['tekstveld'] ."<br>";
}

$recept_id = 2;
$record_type = "O";
$data_recept_info = $ri->selecteerReceptinfo($recept_id, $record_type);


echo"<br><pre>";
var_dump($data_recept_info);
echo"</pre>";

foreach($data_recept_info as $info) {
    echo"<br><br>Naam: ".$info['gebruiker_naam'];
    echo"<br>Datum toegevoegd: ".$info['datum'];
    echo"<br>Opmerking: ".$info['tekstveld'];
}

$data_ingredient = $ing->selecteerIngredient($recept_id);
echo"<br><br><pre>";
var_dump($data_ingredient);


$recept_id = 1;
$gebruiker_id = 2;
$ri->verwijderenFavoriet($recept_id, $gebruiker_id);

/* $recept_id = 3;
$score = 5;
$ri->gevenScore($recept_id, $score); */