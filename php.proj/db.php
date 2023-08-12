<?php

// Get database configuration
require_once 'config.php';

// Database connection
function db_connect() {

  global $db_host, $db_name, $db_user, $db_pass;

  try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  } catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
  }

}

// Get db connection
$db = db_connect();

// Check connection
if(!$db) {
  die("Database connection failed");
}