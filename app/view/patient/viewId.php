
<!-- ----- début viewId -->
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
          <input type="hidden" name='action' value="patientCentreDispo" >
        <label for="id">Patient : </label> <select class="form-control" id='id' name='id' style="width: 200px">
            <?php
            foreach ($results as $element) {
            // echo ("<option value='$elt->getId()'>$elt->getLabel()</option>");
             printf("<option value='%d' >%s</option>", $element->getId(), 
             $element->getNom().":".$element->getPrenom());
            }
            ?>
        </select>
      </div>
      <p/>
      <button class="btn btn-primary" type="submit">Submit form</button>
    </form>
    <p/>
  </div>

  <?php include $root . '/app/view/fragment/fragmentCovidFooter.html'; ?>