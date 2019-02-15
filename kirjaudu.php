<?php

  $yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle

  if (!$yhteys) {
    die("Yhteyden muodostaminen epäonnistui: " . mysqli_connect_error());
  }

  $tietokanta=mysqli_select_db($yhteys, "db_name");
  if (!$tietokanta) {
    die("Tietokannan valinta epäonnistui: " . mysqli_connect_error());
  }

if(isset($_POST['submit'])) { // Jos submit on painettu
  if(isset($_POST['user_uid']) && ($_POST['user_pwd'])) { // Jos lomakkeella on annettu Käyttäjätunnus ja salasana
    $user_uid=$_POST['user_uid']; //muutetaan phplle muuttujiksi lomakkeelta saadut arvot
    $user_pwd=md5($_POST['user_pwd']);

    $tulos=mysqli_query($yhteys, "SELECT * FROM dbt_name WHERE user_uid='$user_uid'"); // haetaan tietokannasta käyttäjätunnuksella kaikki tiedot

    while ($rivi=mysqli_fetch_object($tulos)) { // haetaan omiksi db-muuttujiksi tietokannasta käyttäjätunnus, salasana ja rooli vertailua varten
      $db_user_uid=$rivi->user_uid;
      $db_user_pwd=$rivi->user_pwd;
      $db_user_role=$rivi->user_role;
      $db_user_id=$rivi->user_id;
      $db_user_first=$rivi->user_first;

      if($db_user_uid == $user_uid && $db_user_pwd == $user_pwd) { // tutkitaan täsmääkö lomakkeelta tullut käyttäjätunnus ja salasana tietokantaan
        session_start (); // aloitetaan sessio

        $_SESSION['id']=$db_user_id; // sessiossa pidetään mukana yksilöivä id käyttäjästä, tässä kerrotaan sen tulevan tietokannasta äsken nimetystä muuttujasta
        $_SESSION['uid']=$db_user_uid;
        $_SESSION['first']=$db_user_first;
        $_SESSION['role']=$db_user_role;

        if($db_user_role == 'admin') { // kun tiedot täsmäävät tietokantaan, tarkistetaan rooli, jos admin, siirrytään adminin näkymään
          header("Location:admin.php");
          exit;
        } else if ($db_user_role == 'user')  { // jos rooli on user, siirrytään perus tervetuloa-näkymään
          header("Location:tervetuloa.php");
          exit;
          }
      } else { // jos käyttäjätunnus ja/tai salasana eivät täsmää tietokantaan
        header("Location:keskustelu.php?kirjaudu=error");
        exit;
        }
    } // while lause päättyy
  } else { // jos lomakkeella ei ole annettu käyttäjätunnusta ja/tai salasanaa
    header("Location:keskustelu.php?kirjaudu=empty");
    exit;
  }

} else { // jos submittia ei ole painettu
  header("Location:keskustelu.php");
  exit;
}

?>
