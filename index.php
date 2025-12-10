<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Generic Company</title>
    <link rel="shortcut icon" href="src/assets/images/favicon.png" type="image/x-icon">

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
    // start session
    session_start();
    
    // require libraries
    require_once __dir__."/src/database/getDB.php";
    require_once __dir__."/src/server/account.php";

    // start DB
    $conn = getDB();

    if ($conn->connect_error) {
      die("<h1 class=\"alert\">Erro ao tentar se conectar</h1>");
    }

    // get user
    if (isset($_SESSION["userid"])) {
      $user = getUser($conn, $_SESSION["userid"]);
    }

    // preparate content
    $template = file_get_contents("src/pages/main-page.html");
    $accountContent;
    $navContent;
    $content;

    // get correct content
    if (!isset($user)) {
      $content = file_get_contents("src/pages/content/greeting-content.html");
      $accountContent = file_get_contents("src/pages/template/greeting-account-template.html");
      $navContent = file_get_contents("src/pages/template/greeting-nav-template.html");
    } else {
      $content = file_get_contents("src/pages/content/dashboard-content.html");
      $accountContent = file_get_contents("src/pages/template/dashboard-account-template.html");
      $navContent = file_get_contents("src/pages/template/dashboard-nav-template.html");
    }
    
    if (count($_GET) > 0) {
      $search = $_GET["article"] ?? "";
      if ($search == "") {
        ob_start();
        $search = $_GET["search__query"] ?? "";
        include("./src/server/search.php");
        $content = ob_get_clean();
      } else {
        ob_start();
        include("./src/server/load-article.php");
        $content = ob_get_clean();
      }
    }

    // join content
    $template = str_replace("{{main__container}}", $content, $template);
    $template = str_replace("{{account__container}}", $accountContent, $template);
    $template = str_replace("{{nav__container}}", $navContent, $template);
    
    // inject content
    echo $template;
    ?>
  </body>
</html>