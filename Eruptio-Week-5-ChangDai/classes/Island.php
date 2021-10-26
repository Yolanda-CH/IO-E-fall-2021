<?php 

// The Mountain class includes:
// 1. Static methods for querying mountains in general
//   Mountain::findMany()
//   Mountain::findOne()
//   Mountain::highestPeak()

// 2. Logic pertaining to individual objects of the Mountain class
//   $mountain->range() 
//   $mountain->mapImage()
//   $mountain->card()
//   $mountain->profile()

class Island{

  // ========================
  // 1. Static methods for querying mountains in general
  // ========================
  
  // Mountain::findMany() is called by the controller, mountains.php
  static function findMany(){
    // The query has several clauses:
    // SELECT, JOIN, WHERE, GROUP BY, ORDER BY
    // Build each clause separately and then assemble (concatenate) them afterwards

    // It's a good idea to curate a specific list of columns 
    // rather than using the generic asterisk *
    $select = "
      SELECT
        Name, Islands, Area, 
        Type, Longitude, Latitude, 
        Continent, GROUP_CONCAT(Province) as Provinces
      FROM `island` 
      JOIN `geo_island` 
      ON `geo_island`.`Mountain` = `island`.`Name` 
      JOIN `encompasses` 
      ON `geo_island`.`Country` = `encompasses`.`Country` ";
      
    // Filter for volcanic mountains only
    $where = " WHERE `island`.`Type` LIKE 'volc%' ";
    // If the user asked for a specific continent add it to our filter
    if ( $continent = Request::continent() ){
      $where .= " AND `Continent` = '$continent' ";
    }
    // GROUP BY is often a repeat of SELECT 
    $groupBy = " GROUP BY 
        Name, Islands, Area, 
        Type, Longitude, Latitude, 
        Continent ";
    // by default there is no sorting applied.
    $orderBy = '';
    $direction = '';
    // If the user has requested sorting, add an ORDER BY clause
    if ( $sortColumn = Request::sort( ) ){
      $orderBy = " ORDER BY `$sortColumn` ";
      // If the user has requested a sort direction, add ASC or DESC
      if( Request::sortDirection() ){
        $direction = Request::sortDirection();
      }
    }

    // assemble the parts of the query 
    $sql = $select.$where.$groupBy.$orderBy.$direction;

    // uncomment the var_dump below to debug your assembled SQL query. 
    // var_dump($sql);

    $query = App::pdo()->prepare($sql);
    $query->execute();
    // PDO's FETCH_CLASS option allows for a classname (e.g. Mountain) 
    // Each row thus becomes a Mountain object (instance of Mountain class)
    return $query->fetchAll(PDO::FETCH_CLASS, 'Island'); 
  }

  // Mountain::findOne() is called by the controller, mountain.php
  static function findOne(){
    // Notice the question mark (?) in the WHERE clause below
    // It is a placeholder whose value is added later by PDO
    // This is a more secure way to prepare a query,
    // Especially when the input hasn't been verified.
    $sql =
      "
      SELECT
        Name, Islands, Area, 
        Type, Longitude, Latitude, 
        Continent, GROUP_CONCAT(Province) as Provinces
      FROM `island`
      JOIN `geo_island` 
      ON `geo_island`.`Island` = `island`.`Name` 
      JOIN `encompasses` 
      ON `geo_island`.`Country` = `encompasses`.`Country` 
      WHERE `island`.`Name` = ?
      GROUP BY 
        Name, Islands, Height, 
        Type, Longitude, Latitude, 
        Continent
      "
    ;
    // uncomment the var_dump below to debug your assembled SQL query.    
    //var_dump($sql);

    // Since the above query has a placeholder (?), 
    // The use of PDO's prepare() is important here
    $query = App::pdo()->prepare($sql);
    // To execute the prepared statement, 
    // Fill the placeholder (?) with whatever mountain the user requested.
    $query->execute([ Request::island() ]); 
    // To get a single result, use fetchObject() to return the first row only.
    // Note how we are telling PDO which class to use (Mountain)
    return $query->fetchObject('Island'); 
  }

  // The highestPeak is stored as a static variable.
  // It is set up this way because we only need to fetch it once. 
  public static $highestPeak = null ;
  static function highestPeak(){
    if ( self::$highestPeak ) {   return self::$highestPeak ;   }
    self::$highestPeak = 
      App::pdo()
        ->query("SELECT max(Height) FROM island")
        ->fetchColumn();
    return self::$highestPeak;
  }
 
  
  // =================================
  // 2. Code for individual objects of the Mountain class
  // ========================


  // Mountain constructor
  // Runs automatically on each new instance of the Mountain class. 
  // Generates some useful derivations/variations on the available data. 
  // Note that objects created by PDO will be populated prior to __construct()
  function __construct(){ 
    // use the relative height of the mountain to make an alpha value.
    // note the use here of the static function Mountain::highestPeak()
    $alpha = round( $this->Height / Island::highestPeak(), 2);
    $this->bgColor = "rgba(255,100,0,$alpha)";
    // Generate a map image using mapbox static image API.
    $this->mapImage = $this->mapImage();
    // Note that the Request::mountain() will recognize this url
    $this->link = "/island/".urlencode($this->Name);
    // Build an HTML snippet for mountain range where applicable.
    $this->range = $this->range();
  }
  
  function range(){
    // If this mountain is part of a range, 
    // it will have some data in the "Mountains" column
    // in that case we can build HTML markup, otherwise it will remain blank.
    if ($this->Islands){
    return <<<HTML
      <h3>
        <span class="material-icons">terrain</span>
        $this->Islands
      </h3>
    HTML;
    }
  }

  // Generate a map image based on this mountain's location (Latitude/Longitude)
  // Mapbox offers a generous free tier to make map images.
  // You are advised to get your own account and token 
  // Example:
  //  MAPBOX_TOKEN
  //  pk.eyJ1IjoibnNpdHUiLCJhIjoiOGFZRVYtayJ9.5S6MT1zMMsPcKcrIWw1zIA 
  // See also: https://docs.mapbox.com/playground/static/
  function mapImage($resolution = "800x200"){
    //  add MAPBOX_TOKEN to Replit's "Secrets" (Environment Variables)    
      $token = getenv('MAPBOX_TOKEN'); 
      return "https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/$this->Longitude,$this->Latitude,9,0/$resolution?access_token=$token";
  }

  // Build an HTML "card" template for each mountain 
  // It is called by the list view ( /views/mountains.php )
  function card(){    
    // We can use variables to show unique data  (e.g. $this->Name)
    // Variables correspond to columns from our SQL query
    return <<<HTML
        <div style="background: $this->bgColor;" class="island">
          <div class="map" style="background-image: url($this->mapImage)"></div> 
          <h2><a href="$this->link">$this->Name</a></h2>
          $this->range
          <h3>
            <span class="material-icons">place</span>
            $this->Latitude,$this->Longitude</h3>
          <h3>
            <span class="material-icons">public</span>
            $this->Continent
          </h3>
          <h3>
            <span class="material-icons">flag</span>
            $this->Provinces
          </h3>
          <h3>
            <span class="material-icons">area</span>
            $this->Area m
          </h3>
          <h3>
            <span class="material-icons">local_fire_department</span>
            $this->Type
          </h3> 
        </div>
    HTML;
  }

  // This profile function shows a mountain on its own page. 
  // It is called by the single view ( /views/mountain.php )
  function profile(){
    return <<<HTML
        <div style="background: $this->bgColor;" class="island">
          $this->range
          <h3>
            <span class="material-icons">place</span>
            $this->Latitude,$this->Longitude</h3>
          <h3>
            <span class="material-icons">public</span>
            <a href="/$this->Continent">$this->Continent</a>
          </h3>
          <h3>
            <span class="material-icons">flag</span>
            $this->Provinces
          </h3>
          <h3>
            <span class="material-icons">area</span>
            $this->Area m
          </h3>
          <h3>
            <span class="material-icons">local_fire_department</span>
            $this->Type
          </h3> 
        </div>
    HTML;

  }

  
}

?>