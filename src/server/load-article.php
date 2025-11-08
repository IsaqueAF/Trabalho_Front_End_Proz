<?php
require_once __dir__."/../database/getDB.php";
require_once __dir__."/../database/utils.php";

$conn = getDB();
$query = htmlspecialchars($search);

if ($conn->connect_error) {
    echo("<h1 class=\"alert\">Erro ao tentar se conectar</h1>");
    $conn->close();
    return;
}

$sql = "SELECT articles.slug, articles.title, users.name, articles.created_at, articles.updated_at, articles.content 
        FROM articles 
        JOIN users ON articles.user_id = users.id 
        WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $query);
if (!$stmt->execute()) {
    echo("<h1 class=\"alert\">Erro ao tentar fazer requisiçãor</h1>");
    $conn->close();
    return;
}
$result = $stmt->get_result();

$articleTemplate = file_get_contents(__DIR__."/../pages/article-template.html");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    global $content;
    $currentTemplate = $GLOBALS["articleTemplate"];

    $currentTemplate = str_replace("{{slug}}", $row["slug"], $currentTemplate);
    $currentTemplate = str_replace("{{title}}", $row["title"], $currentTemplate);
    $currentTemplate = str_replace("{{user}}", $row["name"], $currentTemplate);
    $currentTemplate = str_replace("{{createDate}}", date("d/m/Y H:i", strtotime($row["created_at"])), $currentTemplate);
    $currentTemplate = str_replace("{{updateDate}}", date("d/m/Y H:i", strtotime($row["updated_at"])), $currentTemplate);
    $currentTemplate = str_replace("{{content}}", $row["content"], $currentTemplate);

    $content = $content.$currentTemplate;
    echo $content;
} else {
    echo("<h1 class=\"alert\">Artigo não encontrado</h1>");
    $conn->close();
    return;
}

$conn->close();
?>