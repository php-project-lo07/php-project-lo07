
<!-- ----- debut Router1 -->
<?php
require ('../controller/ControllerCovid.php');
require ('../controller/ControllerVaccin.php');
require ('../controller/ControllerCentre.php');
require ('../controller/ControllerPatient.php');
require ('../controller/ControllerCentreVaccin.php');
// --- récupération de l'action passée dans l'URL
$query_string = $_SERVER['QUERY_STRING'];

// fonction parse_str permet de construire 
// une table de hachage (clé + valeur)
parse_str($query_string, $param);

// --- $action contient le nom de la méthode statique recherchée
$action = htmlspecialchars($param["action"]);

// --- Liste des méthodes autorisées
switch ($action) {
 case "vaccinReadAll" :
 case "vaccinReadOne" :
 case "vaccinReadId" :
 case "vaccinCreate" :
 case "vaccinCreated" :
 case "vaccinUpdate" :
 case "vaccinUpdated" :
  ControllerVaccin::$action();
  break;
 case "centreReadAll" :
 case "centreCreate" :
 case "centreCreated" :
  ControllerCentre::$action();
  break;
  case "patientReadAll" :
  case "patientCreate" :
  case "patientCreated" :
  ControllerPatient::$action();
  break;
  case "centreVaccinReadAll" :
  case "centreVaccinDosesGlobal" :
  ControllerCentreVaccin::$action();
  break;
 default:
  $action = "covidAccueil";
  ControllerCovid::$action();
}
?>
<!-- ----- Fin Router1 -->

