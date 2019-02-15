<?php
session_start();

if (!isset($_SESSION['uid'])) { // Jos kukaan ei ole kirjautunut, siirrytään kirjautumissivulle, ettei sivulle pääse ilman kirjautumista pelkällä urlilla
  header("Location:keskustelu.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
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

<?php
$q = intval($_GET['q']); //k�ytt�j�n id, joka valitaan lomakkeen alasvetovalikosta

$yhteys = mysqli_connect("localhost", "db_user_name", "db_password"); //Yhteys palvelimelle //luodaan yhteys tietokantaan
if (!$yhteys)
{
    die("Ei voitu yhdist�� tietokantaan " . mysqli_error($yhteys));
}

mysqli_select_db($yhteys, "db_name"); //valitaan tietokanta
$sql="SELECT * FROM dbt_name WHERE user_id = '".$q."'"; //luodaan kysely tietyst� tietokannan taulusta
$result = mysqli_query($yhteys, $sql);

//luodaan taulukko tuloksille
echo "<table>
<tr>
<th>Nimimerkki</th>
<th>Paikkakunta</th>
<th>Rekisteröitynyt</th>
</tr>";
//valitaan tiedot, jotka n�ytet��n tietokannasta taulukossa
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['user_uid'] . "</td>";
    echo "<td>" . $row['user_city'] . "</td>";
	echo "<td>" . $row['user_regdate'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($yhteys);
?>
</body>
</html>
