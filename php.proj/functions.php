<?php

// Database connection
function db_connect() {

  $host = 'localhost';
  $dbname = 'myblog';
  $username = 'root';
  $password = 'password';

  try {
    return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  } catch (PDOException $e) {
    return false; 
  }

}

// Escape strings
function escape($string) {
  global $db;
  return $db->quote($string);
}

// Set session message
function set_message($msg) {
  if(!empty($msg)) {
    $_SESSION['message'] = $msg;
  } else {
    $msg = "";
  }
}

// Display session message
function display_message() {
  if(isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
  }
}

// Redirect
function redirect($location) {
  header("Location: ${location}");
}