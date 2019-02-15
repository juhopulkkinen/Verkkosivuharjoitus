<?php
session_start();

if (isset($_SESSION['uid']) || ($_SESSION['id'])) { // Jos joku on kirjautuneena
  if ($_SESSION['role'] =='admin') { // tarkistetaan kirjautujan rooli, jos rooli on admin
    header("Location:admin.php"); // siirrytään adminin näkymään
    exit;
  } else { // jos rooli on user, siirrytään tervetuloa näkymään
    header("Location:tervetuloa.php"); // eli ei voi kirjautua uudelleen, jos edellinen sessio on käynnissä
    exit;
  }
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
        <a class="nav-link active" href="etusivu.html">Etusivu</a>
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
        <a class="nav-link active" href="keskustelu.php">Keskustelualue</a>
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
          <h1 class="display-4">Tervetuloa keskustelemaan!</h1>
          </div>
        <hr>
        </div>
      </div>

<!-- Lomake kirjaudu sisään -->

<div class="container-fluid padding">
  	<div class="row padding text-center">
    	<div class="col-12">

        <?php // kirjautumiskenttien virheilmoitukset
        $fullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // print $fullURL; // printataan ylempi muuttuja, jotta voidaan varmistaa toimivuus

        if (strpos($fullURL, "kirjaudu=empty") == true) { // tutkitaan onko ensimmäisessä muuttujassa eli kokonaisessa urlissa sisällä toinen muuttuja eli kirjaudu=empty
          // eli jos urlissa on sisällä kirjaudu=empty tehdään seuraavaa
          echo "<p class='error'>Täytäthän molemmat kentät</p>";
        } else if (strpos($fullURL, "kirjaudu=error") == true) { // tutkitaan onko ensimmäisessä muuttujassa eli kokonaisessa urlissa sisällä toinen muuttuja eli kirjaudu=error
          // eli jos urlissa on sisällä kirjaudu=error tehdään seuraavaa
          echo "<p class='error'>Käyttäjätunnus ja salasana eivät täsmää</p>";
        }
        ?>

			<form action= 'kirjaudu.php' method='POST'>
			     <div class="form-group">
				         <input type="text" name="user_uid" placeholder="Käyttäjätunnus"><br><br>
				         <input type="password" name="user_pwd" placeholder="Salasana"><br><br>
				         <input type="submit" name="submit" class="btn btn-primary btn-md" value="Kirjaudu sisään">
			     </div>
			</form>
      <button type="button" class="btn btn-md" onclick="window.location.href='rekisteroidy.php'">Ei vielä tunnuksia?</button>
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
