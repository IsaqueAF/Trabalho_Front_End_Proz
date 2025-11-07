<?php
  require __DIR__ . '/../../vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
  $dotenv->load();

  $host = $_ENV['DB_HOST'];
  $user = $_ENV['DB_USER'];
  $pass = $_ENV['DB_PASS'];
  $db   = $_ENV['DB_NAME'];

  function getDB (): mysqli {
    $conn = new mysqli(
      hostname: $GLOBALS["host"],
      username: $GLOBALS["user"],
      password: $GLOBALS["pass"],
      database: $GLOBALS["db"]);

    if ($conn->connect_error) {
      die("Falha na conexão: " . $conn->connect_error);
    }

    return $conn;
  }
?>