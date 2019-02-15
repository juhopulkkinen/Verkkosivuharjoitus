<?php
session_start();

if (isset($_SESSION['uid']) || ($_SESSION['id'])) { // tarkistetaan, että sessio on käynnissä ja joku on kirjautuneena
  if ($_SESSION['role'] == 'user') { // jos kirjautunut henkilö on user eli peruskäyttäjä, ohjataan tervetuloa sivulle
    header("Location:tervetuloa.php");
    exit;
  } // jos rooli on muuta kuin user eli admin, suoritetaan
} else { // jos ei ole kirjautunut ollenkaan
  header("Location:keskustelu.php"); // ohjataan kirjautumissivulle
  exit;
}

if ($_SESSION['role'] == 'admin') { // jos rooli on admin, muokataan

  if (isset($_POST["submit"])) { // tutkitaan onko submit painettu eli ei päästetä suoralla urlilla
    if (isset($_POST["first"])){
      $first=$_POST["first"];
    }

    if (isset($_POST["last"])){
      $last=$_POST["last"];
    }

    if (isset($_POST["email"])){
      $email=$_POST["email"];
    }

    if (isset($_POST["uid"])){
      $uid=$_POST["uid"];
    }

    if (isset($_POST["city"])){
      $city=$_POST["city"];
    }

    if (isset($_POST["pwd"])){
      $pwd=$_POST["pwd"];
    }

    if (isset($_POST["id"])){
      $id=$_POST["id"];
    }

    if (!(isset($first) || isset($last) || isset($city) || isset($email) || isset($uid) || isset($pwd) || isset($id) )) {
      header("Location:admin.php");
      exit;//Jos tietoja ei ole annettu, palataan edelliselle sivulle
    }

  } else { // jos submit ei ole painettu, siirrytään kirjautumissivulle, koska ei haluta pääsyä urlilla
    header("Location:keskustelu.php");
    exit;
  }


  $yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle

  if (!$yhteys) {
    die("Yhteyden muodostaminen epäonnistui: " . mysqli_connect_error());
  }

  $tietokanta=mysqli_select_db($yhteys, "db_name");
  if (!$tietokanta) {
    die("Tietokannan valinta epäonnistui: " . mysqli_connect_error());
  }

  $passwordmd5 = md5($pwd);

  $sql="UPDATE dbt_name SET user_first=?, user_last=?, user_city=?, user_email=?, user_uid=?, user_pwd=? WHERE user_id=?";//Where kertoo mitä tietuetta päivitetäänote
  $stmt=mysqli_prepare($yhteys, $sql);
  mysqli_stmt_bind_param($stmt, 'ssssssi', $first, $last, $city, $email, $uid, $passwordmd5, $id);
  mysqli_stmt_execute($stmt);

  mysqli_stmt_close($stmt);
  mysqli_close($yhteys);

  header("Location:admin.php");
  exit;


} else {
  header("Location:tervetuloa.php");
  exit;
}
?>
