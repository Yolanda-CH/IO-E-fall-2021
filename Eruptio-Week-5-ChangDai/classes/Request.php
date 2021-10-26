<?php

// The Request class helps us deal with User Requests 
// Note that PHP records the requested URL in a special $_SERVER variable
// See also: https://www.php.net/manual/en/reserved.variables.server.php
// The functions in this class are all "static" functions.
// Unlike mountains, we'll only ever have one request rather than many instances. 

// The following methods are available:
// Request::url()             --get the url requested by the user
// Request::url_contains()    --check if the url contains a given string.
// Request::url_parts()       --split the url into an array of pieces
// Request::sortDirection()   --get the user-requested sort direction (ASC/DESC)
// Request::sort()            --get the user-requested sort column 
// Request::mountain()        --get the user-requested mountain 
// Request::continent()       --get the user-requested continent 

class Request{

  // get the URL requested by the user.
  // trim away any leading or trailing slashes for consistency.
  static function url(){
    return trim($_SERVER['REQUEST_URI'], '/');
  }

  // check whether the requested url contains a given string.
  static function url_contains($string){
    // Note that str_contains() is new in PHP 8
    // https://php.watch/versions/8.0/str_contains
    $url = urldecode(self::url());
    if (str_contains($url, $string)) return true;
    return false;
  }

  // split the url into an array of pieces 
  // the url string is separated at every slash. 
  // this can be helpful if you want to analyze the url
  static function url_parts(){ 
    return explode('/', self::url());
  }

  // Parse the URL to find out which sort direction the user requested.
  static function sortDirection(){
    foreach (["ASC", "DESC"] as $direction){
      if (self::url_contains($direction)) {
        return $direction;
      }
    }
    return "ASC"; // if the user did not specify a sort direction, use ASC by default 
  }

   static function strawberry(){
    foreach (["straw", "berry", "strawberry"] as $direction){
      if (self::url_contains($direction)) {
        return $direction;
      }
    }
    return false; // if the user did not specify a sort direction, use ASC by default 
  }



  // Parse the URL to find out what the user wants to sort by 
  static function sort(){
    foreach ( App::sorts() as $option){
      if (self::url_contains( $option)) {
        return $option;
      }
    }
    // if the user did not request a valid sort option, return false. 
    return false;  
  }

  // if a user requests a mountain, get the requested mountain name 
  // e.g. the url  "/mountain/Ampato" will return "Ampato"
  static function island(){
    if ( self::url_contains( "island") ){
      foreach(self::url_parts() as $string){
        if ($string != "island"){
          return urldecode($string);
        }
      }
    }
     // if the user did not ask for a mountain return false. 
    return false;  
  }

  // Parse the URL to look for valid continents
  static function continent(){
    foreach (App::continents() as $option){
      if ( self::url_contains( $option)) {
        return $option;
      }
    }
    // if the user did not request a valid continent, return false.  
    return false;  
  }

}
?>