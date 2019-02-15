<?php
session_start();

if (isset($_SESSION['uid'])) { // Jos joku on kirjautunut, ei päästetä rekisteröitymään uudelleen ennen uloskirjautumista
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
    </ul>
  </div>
</div>
</nav>


<!-- Otsikko -->

      <div class="container-fluid padding">
        <div class="row welcome text-center">
          <div class="col-12">
          <h1 class="display-4">Luo tunnukset täällä</h1>
          </div>
        <hr>
        </div>
      </div>

<!-- lomake -->

	<div class="container-fluid padding">
  	<div class="row padding text-center">
    	<div class="col-12">

          <?php // kenttien virheilmoitukset
          $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          // print $fullURL; // printataan ylempi muuttuja, jotta voidaan varmistaa toimivuus

          if (strpos($fullURL, "tunnuskaytossa") == true) { // tutkitaan onko ensimmäisessä muuttujassa eli kokonaisessa urlissa sisällä toinen muuttuja eli kirjaudu=empty
            // eli jos urlissa on sisällä kirjaudu=empty tehdään seuraavaa
            echo "<p class='error'>Valitsemasi käyttäjätunnus on jo käytössä</p>";
          } else if (strpos($fullURL, "pwderror") == true) { // tutkitaan onko ensimmäisessä muuttujassa eli kokonaisessa urlissa sisällä toinen muuttuja eli kirjaudu=error
            // eli jos urlissa on sisällä kirjaudu=error tehdään seuraavaa
            echo "<p class='error'>Salasanat eivät täsmää</p>";
          }
          ?>


			<form action='tallenna.php' method='POST'>
				<div class="form-group">
					<input type='text' name='first' placeholder='Etunimi' class="form-control" required>
					<br>
					<input type='text' name='last' placeholder='Sukunimi' class="form-control" required>
					<br>
					<input type='email' name='email' placeholder='Sähköpostiosoite' class="form-control" required>
					<br>
          <input type='text' name='city' placeholder='Paikkakunta' class="form-control" required>
					<br>
          <input type='text' name='uid' placeholder='Käyttäjätunnus' class="form-control" required>
					<br>
					<input type='password' name='pwd' placeholder='Salasana' class="form-control" required>
					<br>
					<input type='password' name='cpwd' placeholder='Vahvista salasana' class="form-control" required>
					<br>
					<button type='submit' name='submit' class="btn btn-primary btn-md">Rekisteröidy</button>
				</div>
			</form>
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
