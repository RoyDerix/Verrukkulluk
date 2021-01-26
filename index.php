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
$art = new artikel($conn);
$gebr = new gebruiker($conn);
$kt = new keuken_type($conn);
$ri = new recept_info($conn);
$ing = new ingredient($conn);
$recept = new recept($conn);
$boodschappenlijst = new boodschappenlijst($conn);

$artikel_id = 2;
$gebruiker_id = 4;
$keuken_type_id = [2, 6];
$recept_id = 3;
$keyword = "courgette";

$boodschappenlijst->receptToevoegen(3, 2);

$recepten = $recept->zoeken($keyword);
echo "<pre>";
var_dump($recepten);
echo "<br><br></pre>";

$data_recept = $recept->ophalenRecept($gebruiker_id, null);
echo"---------------------------------------------------------------------------------------------------------------------------------<br>";
echo"Dit is het hele recept: <br><br><pre>";
var_dump($data_recept);

echo"<br></pre>---------------------------------------------------------------------------------------------------------------------------------<br>";