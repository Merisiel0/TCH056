<?php
include 'config.php';

if (!isset($_SESSION['login'])) {
  header('Location: login.php');
  die();
}

$activities = getActivities();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projet-de-Session</title>
  <link rel="stylesheet" href="index.css">
  <script defer src="data.js"></script>
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
        <li><button class="burger_item btn-vers-liste">Activités</button></li>
        <li><button class="burger_item btn-vers-formulaire">Formulaire</button></li>
        <li><button class="burger_item btn-vers-login">Login</button></li>
        <li><button class="burger_item btn-vers-register">S'enregistrer</button></li>
      </ul>
    </div>
  </header>

  <!--MAIN SECTION-->
  <main>
    <h2>Bienvenu au centre sportif DynamiQ</h2><br>
    <p>
      Relevez vos défis et dépassez vos limites chez DynamiQ, votre centre
      sportif de référence <br> où l’énergie et la performance prennent vie!
      Découvrez votre plein potentiel dès aujourd’hui !
    </p><br><br>
    <h3>Nos activités populaires</h3>
    <div id="popular-activities">
      <?php
      for ($i = 0; $i < min(4, count($activities)); $i++) {
        $src = $activities[$i]['image'];
        $name = $activities[$i]['name'];
        $description = $activities[$i]['description'];
        echo "<script>console.log($src);</script>";
        echo "<div class='sport'>";
        echo "<img src='$src' alt='$name'>";
        echo "<div class='text-on-img'>";
        echo "<p>$description</p>";
        echo "</div>";
        echo "</div>";
      }
      ?>
    </div>
    <button class="flex-centered btn-vers-liste">Voir toutes nos activités</button>
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