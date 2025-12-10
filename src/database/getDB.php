<?php
  function getDB (): mysqli {
    $conn = new mysqli(
      hostname: "localhost",
      username: "root",
      password: "",
      database: "company_data");

    if ($conn->connect_error) {
      die("Falha na conexão: " . $conn->connect_error);
    }

    return $conn;
  }
?>