<?php  
  // Don't Repeat Yourself (DRY).
  // To keep your code "DRY", define repetitive elements separately 
  // and then include them wherever they are needed.
  // e.g. a "partials" folder holds our header, footer, and navigation
  include 'partials/header.php'; 
?> 
 
<div id="banner">
  <?php  
    require 'partials/navigation.php'; 
    // when listing a single mountain, display the name in the banner.
    echo "<h1>Strawberry</h1>"; 
  ?>
</div>
<div id="islands"> 
Strawberry
</div>

<?php  include 'partials/footer.php'; ?>