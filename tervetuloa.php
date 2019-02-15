<?php
session_start();

if (!isset($_SESSION['uid'])) { // Jos kukaan ei ole kirjautunut, siirrytään kirjautumissivulle, ettei tervetuloa.php sivulle pääse ilman kirjautumista pelkällä urlilla
  header("Location:keskustelu.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tervetuloa pyropuotiin!</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
  <script>
  //AJAX Tarkistetaan onko henkilöä valittu lomakkeella ja luodaan XMLHttpRequest-objekti
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // selaimille IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // selaimille IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
//Luodaan funktio, joka toteutetaan kun palvelimelta saadaan vastaus, halutaan vastaus 200=ok
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        }
//Lähetetään pyyntö palvelimelle
        xmlhttp.open("GET","haenimi.php?q="+str,true);
        xmlhttp.send();
    }
}
  </script>
  <link href="tyyli.css" rel="stylesheet">
</head>
<body>

<!-- Navigaatio -->
<nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
<div class="container-fluid">
  <a class="navbar-brand"> <img src="logo.png"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse"id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="etusivu.html">Etusivu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tuotteet.html">Tuotteet</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="kampanjat.html">Kampanjat</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="hyodyllista.html">Hyödyllistä tietoa</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="keskustelu.php">Keskustelualue</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="raportti.html">Raportti</a>
      </li>
	    <li class="nav-item">
		    <a class="nav-link"><button type="button" name="logout" class="btn btn-primary btn-md" onclick="window.location.href='logout.php'">Kirjaudu ulos</button></a>
	    </li
    </ul>
  </div>
</div>
</nav>

<!-- Otsikko -->

      <div class="container-fluid padding">
        <div class="row welcome text-center">
          <div class="col-12">
          <h1 class="display-4">Tervetuloa <?php echo "{$_SESSION['first']}"; ?></h1>
          <hr>
          <h4>Omat tietosi</h4>
          <p>

            <?php
            $yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle

            if(!$yhteys){
            die("Yhteyden muodostaminen epäonnistui:".mysqli_connect_error());
            }
            $tietokanta=mysqli_select_db($yhteys,"db_name");// Yhteys tietokantaan
            if(!$tietokanta){
            die("Tietokannan valinta epäonnistui: " .mysqli_connect_error());
            }

            $sql="SELECT * FROM dbt_name WHERE user_uid=?";
            	$stmt=mysqli_prepare($yhteys, $sql);//luodaan statement-olio, parametreina yhteys palvelimeen ja sql
            	mysqli_stmt_bind_param($stmt, 's', $_SESSION['uid']);//liitetään poistettavan id:n arvo kokonaislukuna statementiin
            	mysqli_stmt_execute($stmt);//Poisto tapahtuu tässä ja sen jälkeen luetaan ne käyttäjät, mitä on jäl
              $tulos=mysqli_stmt_get_result($stmt);//funktio hakee statement-oliosta tuloksen

              //Montako riviä tuloksesta saatiin? Joko 1 tai ei yhtään

              if($rivi=mysqli_fetch_object ($tulos)) {// if riittää, koska saadaan vain yksi tulos. Ei tarvita while
            ?>

            <form action='paivitauser.php' method='POST'>
            				<div class="form-group">
                      <input type='hidden' name='id' value='<?php print $rivi->user_id;?>'>
            					<input type='text' name='first' placeholder='Etunimi' class="form-control" required value='<?php print $rivi->user_first;?>'>
            					<br>
            					<input type='text' name='last' placeholder='Sukunimi' class="form-control" required value='<?php print $rivi->user_last;?>'>
            					<br>
                      <input type='text' name='city' placeholder='Paikkakunta' class="form-control" required value='<?php print $rivi->user_city;?>'>
            					<br>
            					<input type='email' name='email' placeholder='Sähköpostiosoite' class="form-control" required value='<?php print $rivi->user_email;?>'>
            					<br>
                      <input type='text' name='uid' placeholder='Käyttäjätunnus' class="form-control" required value='<?php print $rivi->user_uid;?>'>
            					<br>
            					<input type='password' name='pwd' placeholder='Salasana' class="form-control" required value='<?php print $rivi->user_pwd;?>'>
            					<br>
                      Käyttäjäroolisi on: <?php print $rivi->user_role;?> <br><br>
            					<input type='submit' name='submit' class="btn btn-primary btn-md" value='Tallenna'>
            				</div>
            </form>

            <?php
            }

            $_SESSION['role']=$rivi->user_role;
            ?>


          </p>
          </div>
        <hr>
        </div>
      </div>

      <div class="container-fluid padding">
        <div class="row padding">
          <div class="col-6">
              <h3>Kenen kanssa keskustelet?</h3>
<?php
     $yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle

      if (!$yhteys) {
        die("Yhteyden muodostaminen epäonnistui: " . mysqli_connect_error());
      }

      $tietokanta=mysqli_select_db($yhteys, "db_name");
      if (!$tietokanta) {
        die("Tietokannan valinta epäonnistui: " . mysqli_connect_error());
      }

      $tulos=mysqli_query($yhteys, "SELECT * FROM dbt_name");

      while ($rivi=mysqli_fetch_object($tulos)) {
        print "$rivi->user_first $rivi->user_last käyttäjätunnuksella $rivi->user_uid<br>";
      }

      mysqli_close($yhteys);
?>
          </div>
        </div>
      </div>
<hr class="my-4">
<!-- Käyttäjälistaus // AJAX -->
<div class="container-fluid padding">
  <div class="row padding">
    <div class="col-6">

<?php

//luodaan yhteys tietokantaan ja tauluun
$yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle
if (!$yhteys)
{
    die("Ei voitu yhdistää tietokantaan " . mysqli_error($yhteys));
}
mysqli_select_db($yhteys, "db_name");

//Määritellään tiedot, jota haetaan tietokannasta
$sql ="SELECT * FROM dbt_name";
$result = mysqli_query($yhteys, $sql);
?>
<div class="col-md-4">
<b>Selaa nimimerkkejä:</b>
<br>

<?php

//näytetään selaimessa alasvetovalikko
echo "<form>";

//Kun valitaan käyttäjä, siirrytään toteuttamaan showUser-funktio
echo "<select name='id' onchange='showUser(this.value)'>";
//Näytetään listaus nimimerkeistä, jotka on haettu tietokannasta
while ($row = mysqli_fetch_array($result)) {
    echo "<option value='" . $row['user_id'] . "'>" . $row['user_uid'] ."</option>";
}
echo "</select>";


echo "</form>";
//toteutetaan ajax-elementti getElementByID id="txtHint" myötä
?>

<br>

<div id="txtHint"></div>
</div>

</div>
</div>
</div>



<!-- Footer -->

<footer>
<div class="container-fluid padding">
  <div class="row text-center">
    <div class="col-md-4">
      <hr class="light">
      <h5> Pyropuoti</h5>
      <hr class="light">
      <p>puh. 013 - 111 222</p>
      <p>asiakaspalvelu@pyropuoti.fi</p>
      <p>Pyrokatu 1</p>
      <p>00100 PYROMAA</p>
    </div>
    <div class="col-md-4">
      <hr class="light">
      <h5> Aukioloajat:</h5>
      <hr class="light">
      <p> Maanantaista perjantaihin klo 8-16 </p>
      <p> Lauantaisin klo 10-16 </p>
      <p> Sunnuntaisin suljettu </p>
    </div>
    <div class="col-md-4">
      <hr class="light">
      <h5> Myymälät</h5>
      <hr class="light">
      <p> Jyväskylä </p>
      <p> Kuopio </p>
      <p> Imatra </p>
      <p> Muurame </p>
    </div>
  </div>
</div>
</footer>

</body>
</html>
