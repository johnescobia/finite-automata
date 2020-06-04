<?php
$type = 'nfa';
$stateObject = $nfa;
$totalFields = (count($stateObject) + 1) * count($_SESSION['alphaSorted']);
$columnsPerRow = count($_SESSION['alphaSorted']);
$totalObjects = count($stateObject);

echo "<h4>NFA Table</h4>";
include "src/table.php";
 ?>
