
<!-- ----- debut ControllerVaccin -->
<?php
require_once '../model/ModelCentreVaccin.php';

class ControllerCentreVaccin {
 public static function centreVaccinReadAll() {
  $results = ModelCentreVaccin::getDosesCentre();
  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/dashboard/viewAllCentreVaccin.php';
  if (DEBUG)
   echo ("ControllerVaccin : vinReadAll : vue = $vue");
  require ($vue);
 }
 public static function centreVaccinDosesGlobal() {
    $results = ModelCentreVaccin::getDosesGlobal();
    // ----- Construction chemin de la vue
    include 'config.php';
    $vue = $root . '/app/view/dashboard/viewDosesGlobal.php';
    if (DEBUG)
     echo ("ControllerVaccin : vinReadAll : vue = $vue");
    require ($vue);
   }
}
?>
<!-- ----- fin ControllerVaccin -->


