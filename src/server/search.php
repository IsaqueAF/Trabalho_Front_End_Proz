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
if ($query === '') {
    echo("<h1 class=\"alert\">Digite algo para pesquisar</h1>");
    $conn->close();
    return;
}

$sql = "SELECT articles.slug, articles.title, users.name, articles.created_at, articles.updated_at
        FROM articles 
        JOIN users ON articles.user_id = users.id
        WHERE slug LIKE ?";
$stmt = $conn->prepare($sql);
$query = "%".$query."%";
$stmt->bind_param("s", $query);
if (!$stmt->execute()) {
    echo("<h1 class=\"alert\">Erro ao tentar fazer requisiçãor</h1>");
    $conn->close();
    return;
}
$result = $stmt->get_result();

$searchTemplate = file_get_contents(__DIR__."/../pages/template/search-template.html");
$content = "<ul>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        global $content;
        $currentTemplate = $GLOBALS["searchTemplate"];

        $currentTemplate = str_replace("{{slug}}", $row["slug"], $currentTemplate);
        $currentTemplate = str_replace("{{title}}", $row["title"], $currentTemplate);
        $currentTemplate = str_replace("{{user}}", $row["name"], $currentTemplate);
        $currentTemplate = str_replace("{{createDate}}", date("d/m/Y H:i", strtotime($row["created_at"])), $currentTemplate);
        $currentTemplate = str_replace("{{updateDate}}", date("d/m/Y H:i", strtotime($row["updated_at"])), $currentTemplate);

        $content = $content.$currentTemplate;
    }
    $content = $content."</ul>";
    echo $content;
} else {
    echo("<h1 class=\"alert\">Sem resultados</h1>");
    $conn->close();
    return;
}

$conn->close();
?>