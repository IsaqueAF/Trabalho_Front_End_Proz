<?php
session_start();

require_once __dir__."/../server/account.php";
require_once __dir__."/../database/getDB.php";

$conn = getDB();
$errorMessage = "";

if ($conn->connect_error) {
    echo("<h1 class=\"alert\">Erro ao tentar se conectar</h1>");
    $conn->close();
    return;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"] ?? "";
  $register__email = $_POST["register__email"] ?? "";
  $register__password = $_POST["register__password"] ?? "";
  $confirm__password = $_POST["confirm__password"] ?? "";

  $email = $_POST["email"] ?? "";
  $password = $_POST["password"] ?? "";

  $errorMessage = "";

  // LOGIN
  if (empty($name)) {
    $result = loginUser($conn, $email, $password);

    if ($result === -1) {
      $errorMessage = "Erro ao se conectar";
    } else if ($result === 0) {
      $errorMessage = "E-mail ou senha incorreto";
    } else {
      $_SESSION["userid"] = $result;
      $conn->close();
      header("Location: ../../index.php");
      exit;
    }

  // REGISTRO
  } else {
    if ($register__password !== $confirm__password) {
      $errorMessage = "A senha de confirmação está incorreta";
    } else if (strlen($register__password) < 8) {
      $errorMessage = "A senha deve ter 8 ou mais caracteres";
    }

    if (empty($errorMessage)) {
      $result = registerUser($conn, $name, $register__email, $register__password);
      if ($result === -1) {
        $errorMessage = "Erro ao se conectar";
      } else {
        $_SESSION["userid"] = $result;
        $conn->close();
        header("Location: ../../index.php");
        exit;
      }
    }
  }

  $GLOBALS["errorMessage"] = $errorMessage;
  $conn->close();
}


?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Template</title>
    <link rel="stylesheet" href="../style/vars.css?v=<?= time() ?>" />
    <link rel="stylesheet" href="../style/reset.css?v=<?= time() ?>" />
    <link rel="stylesheet" href="../style/global-style.css?v=<?= time() ?>" />
    <link rel="stylesheet" href="../style/account.css?v=<?= time() ?>" />
    <link rel="stylesheet" href="../style/animations.css?v=<?= time() ?>" />
    <link rel="stylesheet" href="../style/account-responsiveness.css?v=<?= time() ?>" />
    <script
      src="https://kit.fontawesome.com/eb455bbf5b.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="back">
      <a href="../../index.php" class="solid__button">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back</span>
      </a>
    </div>
    <div class="body__container">
      <main>
        <div class="main__container">
          <div class="register" id="register">
            <form method="post">
              <h1>REGISTER</h1>

              <div class="name input__box">
                <input type="text" name="name" id="name" placeholder=" " value="<?= isset($name) ? htmlspecialchars($name) : "" ?>" />
                <label for="name">Name</label>
                <i class="fa-solid fa-signature"></i>
              </div>

              <div class="email input__box">
                <input
                  type="email"
                  name="register__email"
                  id="register__email"
                  placeholder=" "
                  value="<?= isset($register__email) ? htmlspecialchars($register__email) : "" ?>"
                />
                <label for="register__email">E-mail</label>
                <i class="fa-solid fa-envelope"></i>
              </div>

              <div class="password input__box">
                <input
                  type="password"
                  name="register__password"
                  id="register__password"
                  placeholder=" "
                  value="<?= isset($register__password) ? htmlspecialchars($register__password) : "" ?>"
                />
                <label for="register__password">Password</label>
                <i class="fa-solid fa-unlock"></i>
              </div>

              <div class="confirm__password input__box">
                <input
                  type="password"
                  name="confirm__password"
                  id="confirm__password"
                  placeholder=" "
                  value="<?= isset($confirm__password) ? htmlspecialchars($confirm__password) : "" ?>"
                />
                <label for="confirm__password">Confirm password</label>
                <i class="fa-solid fa-lock"></i>
              </div>

              <div class="alert"><?= isset($errorMessage) ? htmlspecialchars($errorMessage) : "" ?></div>

              <div>
                <button type="submit" class="solid__button reverse">
                  <span>Register</span>
                  <i class="fa-solid fa-address-card"></i>
                </button>
              </div>

              <span
                >Already have an account?
                <a href="#login" class="button">Login!</a></span
              >
            </form>
          </div>
          <div class="login" id="login">
            <form method="post">
              <h1>LOGIN</h1>

              <div class="email input__box">
                <input type="email" name="email" id="email" placeholder=" " value="<?= isset($email) ? htmlspecialchars($email) : "" ?>"/>
                <label for="email">E-mail</label>
                <i class="fa-solid fa-envelope"></i>
              </div>

              <div class="password input__box">
                <input type="password" name="password" id="password" placeholder=" " value="<?= isset($password) ? htmlspecialchars($password) : "" ?>"/>
                <label for="password">Password</label>
                <i class="fa-solid fa-lock"></i>
              </div>

              <div class="alert"><?= isset($errorMessage) ? htmlspecialchars($errorMessage) : "" ?></div>

              <div>
                <button type="submit" class="solid__button reverse">
                  <span>Login</span>
                  <i class="fa-solid fa-right-to-bracket"></i>
                </button>
              </div>

              <span
                >Don't have an account?
                <a href="#register" class="button">Register!</a></span
              >
            </form>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>
