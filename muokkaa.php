<?php
session_start();

if (isset($_SESSION['uid']) || ($_SESSION['id'])) { // tarkistetaan, että sessio on käynnissä ja joku on kirjautuneena
  if ($_SESSION['role'] == 'user') { // jos kirjautunut henkilö on user eli peruskäyttäjä, ohjataan tervetuloa sivulle
    header("Location:tervetuloa.php");
    exit;
  }
} else { // jos kukaan ei ole kirjautunut
  header("Location:keskustelu.php"); // ohjataan kirjautumissivulle
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

<div class="container-fluid padding">
  <div class="row welcome text-center">
    <div class="col-12">
    <h1 class="display-4">Muokkaa käyttäjän tietoja</h1>
    <hr>
    </div>
  </div>
</div>


<?php
if (isset($_GET["muokattava"])){
  $muokattava=$_GET["muokattava"];
}

if (!isset ($muokattava)){
  header("Location:admin.php");
  exit;
}//ellei muokattavalle ole tullut arvoa siirrytään admin.php:lle

$yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle

if(!$yhteys){
die("Yhteyden muodostaminen epäonnistui:".mysqli_connect_error());
}
$tietokanta=mysqli_select_db($yhteys,"dn_name");// Yhteys tietokantaan
if(!$tietokanta){
die("Tietokannan valinta epäonnistui: " .mysqli_connect_error());
}

$sql="SELECT * FROM dbt_name WHERE user_id=?";
	$stmt=mysqli_prepare($yhteys, $sql);//luodaan statement-olio, parametreina yhteys palvelimeen ja sql
	mysqli_stmt_bind_param($stmt, 'i', $muokattava);//liitetään poistettavan id:n arvo kokonaislukuna statementiin
	mysqli_stmt_execute($stmt);//Poisto tapahtuu tässä ja sen jälkeen luetaan ne käyttäjät, mitä on jäl
  $tulos=mysqli_stmt_get_result($stmt);//funktio hakee statement-oliosta tuloksen

  //Montako riviä tuloksesta saatiin? Joko 1 tai ei yhtään

  if($rivi=mysqli_fetch_object ($tulos)) {// if riittää, koska saadaan vain yksi tulos. Ei tarvita while
?>

<form action='paivita.php' method='POST'>
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
					<input type='submit' name='submit' class="btn btn-primary btn-md" value='Tallenna'>
				</div>
</form>

<?php
}
?>

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
