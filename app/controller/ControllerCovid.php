<!-- ----- debut ControllerPCOVID -->
<?php

class ControllerCovid{
 public static function covidAccueil() {
    include 'config.php';
    $vue = $root . '/app/view/viewCovidAccueil.php';
    if (DEBUG)
     echo ("ControllerVaccin : covidAccueil : vue = $vue");
    require ($vue);
   }
}
?>
<!-- ----- fin ControllerCOVID -->


