
<!-- ----- debut ControllerCentre-->
<?php
require_once '../model/ModelCentre.php';

class ControllerCentre {

 public static function centreReadAll() {
  $results = ModelCentre::getAll();
  include 'config.php';
  $vue = $root . '/app/view/centre/viewAll.php';
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

}
?>
<!-- ----- fin ControllerCentre -->


