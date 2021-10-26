<nav class="navbar navbar-expand-sm navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">erupt.io</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php
        
        // Make a Dropdown to filter by continents. 
        // $filterIcon = '<span class="material-icons">search</span>';
        // $filterName = Request::continent() ?  Request::continent() : 'Continents';  
        // $filterMenu = new NavDropdown( $filterName, $filterIcon);
        // foreach ( App::continents() as $item ) {
        //   $filterMenu->addItem($item); // pass along the $app for context
        // }
        // echo $filterMenu->render();
      
        // Build the Sorting Dropdown
        $sortIcon = '<span class="material-icons">sort</span>';
        $sortName = Request::sort() ?  Request::sort() : "Sort";  
        $sortMenu = new NavDropdown( $sortName, $sortIcon );
        foreach ( App::sorts() as $item ) {
          $sortMenu->addItem($item); // pass along the $app for context
        }
        echo $sortMenu->render();

        // Toggle the sort direction. 
        $toggleName = Request::sortDirection();
        $toggleIcon = ( Request::sortDirection() == "ASC") ?
          '<span class="material-icons">arrow_upward</span>':
          '<span class="material-icons">arrow_downward</span>';
        $toggleDirection = new NavItem( $toggleName, $toggleIcon );
        echo $toggleDirection->render();

        ?>
      </ul>
    </div>
  </div>
</nav>