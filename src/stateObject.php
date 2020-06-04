<?php
class State {
  var $name = "";
  var $label = "";
  var $group = "";
  var $isStartState = 0;
  var $isFinalState = 0;
  var $transitions = array();

	function __construct( $name )	{
    $this->name = $name;
  }
}
?>
