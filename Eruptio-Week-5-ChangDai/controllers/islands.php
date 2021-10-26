<?php

// Mountains controller:
// 1. Recieves a request
// 2. Delegates data fetching
// 3. Returns a response to the view

// This controller is looking for data about mountains
// it delegates the task to the Mountain class.
$islands = Island::findMany();

// To render mountains visually, we have a separate "view" script
require '../views/islands.php';

?>