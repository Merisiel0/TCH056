<?php
include 'config.php';

$username = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $passwd = $_POST['mdp'];

  if ($username && $passwd) {
    $users = getUsers();

    for ($i = 0; $i < count($users); $i++) {
      if ($users[$i]['username'] == $username) {
        if ($users[$i]['password'] == $passwd) {
          $_SESSION['login'] = true;
          header('Location: index.php');
          die();
        } else {
          $errorMessage = "Mot de passe invalide.";
        }
      }
    }

    if($errorMessage == ""){
      $errorMessage = "Username n'existe pas.";
    }
  } else {
    $errorMessage = "Ne laissez pas des champs vide.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="login.css">
  <script defer src="main.js"></script>
</head>

<body>

  <!--HEADER-->
  <header>
    <h1>
      <img src="./assets/icon.png" alt="icon" width="25" class="logo">
      DynamiQ
    </h1>

    <div class="hamburger-menu">
      <input id="burger_toggle" type="checkbox" />
      <label class="burger_btn" for="burger_toggle">
        <span></span>
      </label>
      <ul class="burger_opened">
        <li><button class="burger_item btn-vers-main">Principale</button></li>
        <li><button class="burger_item btn-vers-liste">Activités</button></li>
        <li><button class="burger_item btn-vers-formulaire">Formulaire</button></li>
        <li><button class="burger_item btn-vers-register">S'enregistrer</button></li>
      </ul>
    </div>
  </header>

  <main>
    <div id="login-form">
      <h2>Login</h2>
      <form method="post">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" name="username" id="login-username"
          value="<?php echo htmlspecialchars($username); ?>"><br><br>
        <label for="mdp">Mot de passe:</label><br>
        <input type="password" name="mdp" id="login-password"></input><br>

        <p name="errorMessage"><?php echo htmlspecialchars($errorMessage); ?></p>

        <div>
          <button type="submit" name="submitBtn" id="login_button">Se connecter</button>
        </div>

        <h3>Vous n'avez pas de compte?</h3><br>
        <a href="register.php">S'enregistrer</em></a>
      </form>
    </div>
  </main>

  <!--FOOTER-->
  <footer>
    <table class="flex-centered">
      <thead>
        <tr>
          <th>Nous contacter</th>
          <th>Proposez un cours chez nous</th>
          <th>Suivez nous</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Adresse : 123 Rue du Sport, Montréal, QC</td>
          <td>
            Joignez notre équipe et contribuez à inspirer le bien-être à travers vos compétences sportives.
          </td>
          <td>
            <table>
              <tbody>
                <tr>
                  <td><img src="./assets/social-media-icons/tile000.png" alt="instagram" width="50"></td>
                  <td><img src="./assets/social-media-icons/tile001.png" alt="facebook" width="50"></td>
                  <td><img src="./assets/social-media-icons/tile007.png" alt="linkedin" width="50"></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="grey-text flex-centered">
      <small>&copy; 2025 Le centre sportif, tous droits réservés.</small>
    </p>
  </footer>

</body>

</html>