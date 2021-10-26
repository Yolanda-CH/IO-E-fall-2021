<?php  
  // Don't Repeat Yourself (DRY).
  // To keep your code "DRY", define repetitive elements separately 
  // and then include them wherever they are needed.
  // e.g. a "partials" folder holds our header, footer, and navigation
  include 'partials/header.php'; 
?> 

<!-- This is the View for a list of Mountains.  -->

<div id="banner">
  <?php  
    require 'partials/navigation.php'; 
    // when listing many mountains we will display a count of the results.
    echo "<h1>".count($mountains)." Volcanoes</h1>"; 
  ?>
</div>
<div id="islands">
  <?php
    // this "foreach" loop iterates over our query results from MySQL
    // on each iteration, a new row of data is loaded into a mountain object.
    foreach ($islands as $island){
      // See also: the card() function in /classes/Mountain.php
      echo $island->card();
    }
  ?>
</div>

<?php require 'partials/footer.php'; ?>