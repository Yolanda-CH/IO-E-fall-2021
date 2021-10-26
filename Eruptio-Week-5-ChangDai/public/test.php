<?php

// Loading PHP Classes 
// Our code is organized into PHP Classes (see the "classes" folder)
// Here we tell PHP to auto-load these files as needed.
// This is easier than making a long list of includes. 
spl_autoload_register(function($class_name){
    include '../classes/'.$class_name . '.php';
});
// Read more about the Standard PHP Library (SPL) AutoLoader here
// https://www.php.net/manual/en/language.oop5.autoload.php


// ROUTING
// Pick an appropriate controller depending on the user's input

// If a single mountain is requested, use the singular controller.
if (Request::island()){
  include("../controllers/island.php"); 
}
// In every other case we are probably looking for a list. 
else{
  include("../controllers/islands.php"); 
}
// feel free to add your own routing logic here.


?>