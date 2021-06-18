
<!-- ----- debut ControllerCentre-->
<?php
require_once '../model/ModelCentre.php';
require_once '../model/ModelVaccin.php';


class ControllerCentre {

 public static function centreReadAll() {
  $results = ModelCentre::getAll();
  include 'config.php';
  $vue = $root . '/app/view/centre/viewAll.php';
  if (DEBUG)
   echo ("ControllerCentre : vinReadAll : vue = $vue");
  require ($vue);
 }

 public static function centreNbreRdv() {
  $results = ModelCentre::getRdvCentres();
  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/dashboard/viewNbreRdvCentre.php';
  if (DEBUG)
   echo ("ControllerCentre : vinReadAll : vue = $vue");
  require ($vue);
 }

 public static function centreCreate() {
  include 'config.php';
  $vue = $root . '/app/view/centre/viewInsert.php';
  require ($vue);
 }


 public static function centreCreated() {
  $results = ModelCentre::insert(
      htmlspecialchars($_GET['label']), htmlspecialchars($_GET['adresse'])
  );
  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/centre/viewInserted.php';
  require ($vue);
 }
 
  // Affiche un formulaire pour sélectionner un id qui existe
 public static function centreReadId() {
  $results = ModelCentre::getAllId();

  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/centre/viewId.php';
  require ($vue);
 }
 public static function centreReadOne() {
  $results = ModelVaccin::getAll();

  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/centre/viewUpdateStock.php';
  require ($vue);
 }
 
  public static function centreNbreVacciné() {
  $results = ModelCentre::getVaccinéParCentre();

  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/centre/viewNbreVacciné.php';
  require ($vue);
 }
 
  public static function centreUpdateStock() {
  $results = ModelCentre::verifStockVaccin($_GET['centre'], $_GET['vaccin']);
  if($results)
      if(!empty($_GET['nbreDose']))
        ModelCentre::updateStockVaccin($_GET['centre'], $_GET['vaccin'], $_GET['nbreDose']);
      else
         echo("Erreur");    
  else
      if(!empty($_GET['nbreDose']))
        ModelCentre::addStockVaccin($_GET['centre'], $_GET['vaccin'], $_GET['nbreDose']);
      else
         echo("Erreur");   
    ControllerCentre ::centreReadId();
 }
}
?>
<!-- ----- fin ControllerCentre -->


