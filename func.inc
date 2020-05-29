<?php
function check_let_num_dot_under ($in) {
  return (preg_match('/[^a-zA-Z\d\._]/', $in)) ? FALSE : TRUE;
}

function check_let_num_dot_under_dash ($in) {
  return (preg_match('/[^a-zA-Z\d\._-]/', $in)) ? FALSE : TRUE;
}

function check_let ($in) {
  return (preg_match('/[^a-zA-Z]/', $in)) ? FALSE : TRUE;
}

function check_let_num ($in) {
  return (preg_match('/[^a-zA-Z\d]/', $in)) ? FALSE : TRUE;
}

function clean_string ($in) {
  return preg_replace('/["\\\]/', '', $in);
}

?>
