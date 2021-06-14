
<!-- ----- début viewInsert -->
 
<?php 
require ($root . '/app/view/fragment/fragmentCaveHeader.html');
?>

<body>
  <div class="container">
    <?php
      include $root . '/app/view/fragment/fragmentCaveMenu.html';
      include $root . '/app/view/fragment/fragmentCaveJumbotron.html';
    ?> 
    <ul>
        <li>Correction Bug d'affichage des erreur :<br>Les erreurs pouvant survenir sur l'insertion s'affiche en dessous de la barre de navigation les rendants difficilement repérable. <br>La solution : Ajouter un margin top sur le container</li>
        <li>Amelioration code :<br>Il serait plus simple de créer des classes à par pour effectuer des operations plus pointilleuse comme le nombre de producteur par region ou des requetes qui font appel à deux tables où plus</li>
    </ul>
    <p/>
  </div>
  <?php include $root . '/app/view/fragment/fragmentCaveFooter.html'; ?>

<!-- ----- fin viewInsert -->



