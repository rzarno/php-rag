<?php    

try {
  $conn = new PDO('pgsql:host=postgres;port=5432;dbname='.$_ENV["POSTGRES_DB"] .'',''.$_ENV["POSTGRES_USER"] .'',''.$_ENV["POSTGRES_PASSWORD"] .'');
  $conn->query("SET NAMES UTF8");
} catch (PDOException $e) {
  die('Connection failed: ' . $e->getMessage());
}
