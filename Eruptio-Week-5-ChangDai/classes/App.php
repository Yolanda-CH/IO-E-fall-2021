<?php 

// The App class contains static methods that are accessible anywhere
// App::pdo()           --provides a database connection
// App::continents()    --fetches a list of continent names
// App::sorts()         --a list of valid column names to sort by

class App{

  public static $connection = null ;
  public static $continents = null ;

  // A static function can be used without creating an instance of the class.
  // In a small app, we dont need more than one instance of the App class.
  // See also: https://www.w3schools.com/php/keyword_static.asp
  public static function pdo(){

    if ( self::$connection ) {
      return self::$connection ;
    }

    // In Replit, click "secrets" to add your environment variables:
    // USERNAME   (e.g. ixd0000)
    // PASSWORD   (e.g. ******)
    // HOST       (e.g. phoenix.sheridanc.on.ca)
    // DBNAME     (e.g. ixd0000_db)  
    $username = getenv('USERNAME');   
    $password = getenv('PASSWORD');   
    $host = getenv('HOST');           
    $dbname = getenv('DBNAME');

    // If any details are missing, show a notification. 
    if (!$username || !$password || !$host || !$dbname){
      die("Hi! Please double-check your environment variables.");
    }

    // Tell PDO to display errors if our SQL query ha issues 
    // I wouldn't do this in production, but it sure helps during development
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]; 

    // Connect to our database using PHP Data Objects (PDO) 
    // See also:  https://www.php.net/manual/en/intro.pdo.php
    self::$connection = new PDO(
      'mysql:host='.$host.';dbname='.$dbname, 
      $username, 
      $password, 
      $options
    );

    return self::$connection ;
  }
 

  // Get a list of continents. This is useful in many places in the app
  static function continents(){
    if ( self::$continents ) return self::$continents ;
    $rows = self::pdo()->query("SELECT `Name` FROM `continent`");
    self::$continents = $rows->fetchAll(PDO::FETCH_COLUMN); 
    return self::$continents ;
  }

  // Define a list of columns we want to sort by.
  // Feel free to change this but make sure your query agrees!
  static function sorts(){
    return ["Name", "Height", "Provinces"];
  }

}

?>