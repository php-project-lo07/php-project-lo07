
<!-- ----- début viewInsert -->
 
<?php 
require ($root . '/app/view/fragment/fragmentCovidHeader.html');
?>

<body>
  <div class="container">
    <?php
      include $root . '/app/view/fragment/fragmentCovidMenu.html';
      include $root . '/app/view/fragment/fragmentCovidJumbotron.html';
    ?> 

    <form role="form" method='get' action='router1.php'>
      <div class="form-group">
        <input type="hidden" name='action' value='patientCreated'>                                  
        <label for="id">nom : </label><input type="text" name='nom' value='Jean'>     
        <label for="id">prenom : </label><input type="text" name='prenom' value='Claude'>     
        <label for="id">adresse : </label><input type="text" name='adresse' value='troyes quelque part ailleur'>             
      </div>
      <p/>
      <button class="btn btn-primary" type="submit">Go</button>
    </form>
    <p/>
  </div>
  <?php include $root . '/app/view/fragment/fragmentCovidFooter.html'; ?>

<!-- ----- fin viewInsert -->



