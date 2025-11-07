<?php
require_once "../database/getDB.php";

$conn = getDB();

if ($conn) {
    echo "Conectado com sucesso!!";
};

?>