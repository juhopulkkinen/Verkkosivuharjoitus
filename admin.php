<?php
session_start ();

if (isset($_SESSION['uid']) || ($_SESSION['id'])) { // tarkistetaan, että sessio on käynnissä ja joku on kirjautuneena
  if ($_SESSION['role'] == 'user') { // jos kirjautunut henkilö on user eli peruskäyttäjä, ohjataan tervetuloa sivulle
    header("Location:tervetuloa.php");
    exit;
  }
} else {
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

  <!-- AJAX -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $("#btn").click(function() {
      $("#omattiedot").load("omattiedot.php");
    });
  });
</script>

  <link href="tyyli.css" rel="stylesheet">
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
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
    <div id="omattiedot">
      <button id="btn" class="btn btn-md">Näytä omat tietosi</button><br>
    </div>
    <br>
    </div>
  </div>
</div>



<div class="container-fluid padding">
  <div class="row padding text-center">
    <div class="col-12">
        <h3>Hallinnoi rekisteröityneitä käyttäjiä</h3>

<?php
//Luetaan GET-metodilla poistettava tieto, koska se on linkissä
if (isset($_GET["poistettava"])){
  $poistettava=$_GET["poistettava"];//tähän saadaan talteen poistettavan tietueen ID
}

$yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle

if(!$yhteys){
die("Yhteyden muodostaminen epäonnistui:".mysqli_connect_error());
}
$tietokanta=mysqli_select_db($yhteys,"db_name");// Yhteys tietokantaan
if(!$tietokanta){
die("Tietokannan valinta epäonnistui: " .mysqli_connect_error());
}

if (isset($poistettava)){
  $sql="DELETE FROM dbt_name WHERE user_id=?";
	$stmt=mysqli_prepare($yhteys, $sql);//luodaan statement-olio, parametreina yhteys palvelimeen ja sql
	mysqli_stmt_bind_param($stmt, 'i', $poistettava);//liitetään poistettavan id:n arvo kokonaislukuna statementiin
	mysqli_stmt_execute($stmt);//Poisto tapahtuu tässä ja sen jälkeen luetaan ne käyttäjät, mitä on jäljellä tietokannassa
}

$tulos=mysqli_query($yhteys, "SELECT * FROM dbt_name");

echo "<table>
<tr>
<th> Etunimi </th>
<th> Sukunimi </th>
<th> Nimimerkki </th>
<th> Email </th>
<th> Paikkakunta </th>
<th> Rekisteröitynyt </th>
<th> Poista tiedot</th>
<th> Muokkaa tietoja</th>
</tr>";
while ($rivi = mysqli_fetch_array ($tulos)){
echo "<tr>";
echo "<td>" . $rivi['user_first'] . "</td>";
echo "<td>" . $rivi['user_last'] . "</td>";
echo "<td>" . $rivi['user_uid'] . "</td>";
echo "<td>" . $rivi['user_email'] . "</td>";
echo "<td>" . $rivi['user_city'] . "</td>";
echo "<td>" . $rivi['user_regdate'] . "</td>";
echo "<td> <a href ='admin.php?poistettava=".$rivi['user_id']."'>Poista</a></td>";
echo "<td> <a href ='muokkaa.php?muokattava=".$rivi['user_id']."'>Muokkaa</a></td>";
echo "<tr>";
}
echo "</table>";
mysqli_close($yhteys);

?>

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
