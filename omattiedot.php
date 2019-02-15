<?php
session_start();
?>
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
  Käyttäjäroolisi on: <?php print $rivi->user_role;?> <br><br>
  <input type='submit' name='submit' class="btn btn-primary btn-md" value='Tallenna'>
  </div>
</form>

<?php
}
$_SESSION['role']=$rivi->user_role;
?>
</p>
