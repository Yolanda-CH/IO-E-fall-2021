<?php

// The NavItem class builds a link for the navigation bar. 
// It uses HTML snippets from Bootstrap.
// It has logic for making a url and marking a link as active. 
// It assumes three types of links: filter, sort, and sortDirection

// $navitem->render()   -- Generate HTML markup for a navigation link.
// $navitem->getType()  -- Discover what type of link this is based on the name
// $navitem->url()      -- Build a URL based on the name and type. 
// $navitemisActive()   -- check whether this item is currently selected.

class NavItem{

  // Each nav item is constructed based on a provided name and optional icon
  function __construct($name, $icon = ''){
    $this->name = $name;
    $this->icon = $icon; 
    $this->type = $this->getType(); // e.g. filter, sort, direction
    $this->href = $this->url();     
    $this->style = ($this->isActive()) ? "active" : "";
  }

  // HTML snippets here are based on the Bootstrap NavBar dropdown
  // https://getbootstrap.com/docs/5.1/components/navbar/
  // if "dropdown" mode is specified, add Bootstrap's dropdown css classes.
  function render($mode="normal"){
    if ($mode == "dropdown"){
      return <<<HTML
        <li>
          <a class="dropdown-item $this->style" href="$this->href">
            $this->icon<span class="$this->type">$this->name</span>
          </a>
        </li>
      HTML;
    }
    else{
      return <<<HTML
        <li class="nav-item">
          <a class="nav-link $this->style" href="$this->href">
            $this->icon<span class="$this->type">$this->name</span></a>
        </li>
      HTML;
    }
  }

  // Infer what type of link this is based on the name
  // (e.g. filter, sort, or direction)
  // This will influence how the url is generated.
  function getType(){
    if ( in_array( $this->name,  App::continents()  ) ) return "filter";
    if ( in_array( $this->name,  App::sorts() ) ) return "sort";
    if ( in_array( $this->name,  ["ASC", "DESC"] ) ) return "direction";
  }

  // Generate a link url 
  // Infer what is needed based on the name and context. 
  function url(){
    $urlParts=[]; // start with an empty array
    // when toggling (ASC/DESC), persist existing filter and sort
    if ($this->type=="direction"){
      $urlParts[] = Request::continent();
      $urlParts[] = Request::sort();
      $urlParts[] = (Request::sortDirection() == "ASC")? "DESC" : "ASC";
    }
    // when linking to a filter, persist existing sort and direction
    elseif ( $this->type =="filter" ){
      $urlParts[] = $this->name;
      $urlParts[] = Request::sort();
      $urlParts[] = Request::sortDirection();
    }
    // when linking to a sort, persist existing filter and direction
    elseif ( $this->type =="sort" ){
      $urlParts[] = Request::continent();
      $urlParts[] = $this->name;
      $urlParts[] = Request::sortDirection();         
    }  
    // if any of the above elements are missing, remove them from the array
    $urlParts = array_filter($urlParts); 
    // encode all the url parts to be url-friendly
    // https://www.php.net/manual/en/function.urlencode.php
    $urlParts = array_filter($urlParts, "urlencode"); 
    // convert array to url string 
    // e.g. ["Asia","Area","ASC"]  becomes /Asia/Area/ASC
    return '/'.implode('/',$urlParts);  
  }
  
  // If the requested url matches this link, mark it as active. 
  function isActive(){
    if ( Request::url_contains($this->name) ) return true;
    return false;
  }

}

?>