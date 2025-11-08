<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Base</title>

    <link rel="stylesheet" href="src/style/vars.css?v=<?= time() ?>">
    <link rel="stylesheet" href="src/style/reset.css?v=<?= time() ?>">
    <link rel="stylesheet" href="src/style/global-style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="src/style/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="src/style/responsiveness.css?v=<?= time() ?>">
    <link rel="stylesheet" href="src/style/animations.css?v=<?= time() ?>">

    <script
      src="https://kit.fontawesome.com/eb455bbf5b.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <?php
    require_once __dir__."/src/database/getDB.php";
    require_once __dir__."/src/server/account.php";

    session_start();

    $conn = getDB();
    $errorMessage = "";

    if ($conn->connect_error) {
        echo("<h1 class=\"alert\">Erro ao tentar se conectar</h1>");
        $conn->close();
        return;
    }

    $user = getUser($conn, $_SESSION["userid"]);
    echo $user["name"];

    $template = file_get_contents("src/pages/template.html");
    $content;
    
    if (count($_GET) === 0) {
      global $content;
      $content = file_get_contents("src/pages/home.html");
    } else {
      $search = $_GET["article"] ?? '';
       if ($search == "") {
        ob_start();
        $search = $_GET["search__query"] ?? '';
        include("./src/server/search.php");
        $content = ob_get_clean();
      } else {
        ob_start();
        include("./src/server/load-article.php");
        $content = ob_get_clean();
      }
    }

    $template = str_replace("{{main__container}}", $content, $template);
    
    echo $template;
    $conn->close();
    ?>
  </body>
</html>