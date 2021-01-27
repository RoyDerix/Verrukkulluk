<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/gebruiker.php");
require_once("lib/keuken_type.php");
require_once("lib/recept_info.php");
require_once("lib/ingredient.php");
require_once("lib/recept.php");
require_once("lib/boodschappenlijst.php");

$db = new database();
$conn = $db->getConnectie();
$recept_info = new recept_info($conn);
$recept = new recept($conn);
$boodschappenlijst = new boodschappenlijst($conn);

$recept_id = isset($_GET['recept_id']) ? $_GET['recept_id'] : "";
$gebruiker_id = isset($_GET['gebruiker_id']) ? $_GET['gebruiker_id'] : "";
$action = isset($_GET['action']) ? $_GET['action'] : "homepage";

switch($action) {
    
    //homepage
    case ("homepage"):
        $data = $recept->ophalenRecept($gebruiker_id);
        break;
    
    //detailpagina 
    case ("detailpagina"):
        $data = $recept->ophalenRecept($gebruiker_id, $recept_id);
        break;

    //boodschappen toevoegen
    case("boodschappen_toevoegen"):
        $boodschappenlijst->toevoegenRecept($recept_id, $gebruiker_id);
        $data = $recept->ophalenRecept($gebruiker_id, $recept_id);
        break;

    //favoriet toevoegen
    case("favoriet_toevoegen"):
        $recept_info->toevoegenFavoriet($recept_id, $gebruiker_id);
        $data = $recept->ophalenRecept($gebruiker_id, $recept_id);
        break;

    //favoriet verwijderen
    case("favoriet_verwijderen"):
        $recept_info->verwijderenFavoriet($recept_id, $gebruiker_id);
        $data = $recept->ophalenRecept($gebruiker_id, $recept_id);
        break;

    //score geven
    case('score_geven'):
        $score = $_POST['score'];
        $recept_info->gevenScore($recept_id, $score);
        $data = $recept->ophalenRecept($gebruiker_id, $recept_id);
        break;

    //zoeken 
    case("zoeken"):
        $keyword = $_POST['keyword'];
        $data = $recept->zoeken($keyword);
        break;

    default:
        echo"Oops, something went wrong here!";
}

echo"<pre>";
var_dump($data);