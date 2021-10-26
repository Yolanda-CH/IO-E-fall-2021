<?php  
  // Don't Repeat Yourself (DRY).
  // To keep your code "DRY", define repetitive elements separately 
  // and then include them wherever they are needed.
  // e.g. a "partials" folder holds our header, footer, and navigation
  include 'partials/header.php'; 
?> 

<!-- This is the View for a Single Mountain.  -->

<style>
  /* Add a custom banner image for each individual mountain. 
  The 1280px resolution is as high as MapBox will go.  */
  #banner {
    background-image: url(<?= $island->mapImage("1280x400"); ?>)
  }
</style>
<div id="banner">
  <?php  
    require 'partials/navigation.php'; 
    // when listing a single mountain, display the name in the banner.
    echo "<h1>".$island->Name."</h1>"; 
  ?>
</div>
<div id="islands">
  <?php
  // See also: the profile() function in /classes/Mountain.php
   echo $island->profile();
  ?>
</div>

<?php  include 'partials/footer.php'; ?>