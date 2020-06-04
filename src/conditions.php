<?php
function funcCondtions() {
  if ( isset($_POST['submitTransition'])
    || isset($_POST['test'])
    || isset($_POST['submitString'])
    || isset($_POST['nfa'])
    || isset($_POST['dfa'])
    || isset($_POST['min']) ) {
      return TRUE;
  } else {
    return FALSE;
  }
}
?>
