<?php
session_start();

$yhteys = mysqli_connect("localhost", "db_user_name", "db_password");//Yhteys palvelimelle

if (!$yhteys) {
  die("Yhteyden muodostaminen epäonnistui: " . mysqli_connect_error());
}

$tietokanta=mysqli_select_db($yhteys, "db_name");
if (!$tietokanta) {
  die("Tietokannan valinta epäonnistui: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) { // tutkitaan onko submit painettu eli ei päästetä suoralla urlilla
  if (isset($_POST["first"])){
    $first=mysqli_real_escape_string ($yhteys, $_POST['first']); //Suojataan tietokantaa ei-toivotuilta merkeiltä
  }
  else{
    header("Location:rekisteroidy.php");
    exit;
  }

  if (isset($_POST["last"])){
    $last=mysqli_real_escape_string ($yhteys, $_POST['last']);
  }
  else {
    header("Location:rekisteroidy.php");
    exit;
  }

  if (isset($_POST["email"])){
    $email=mysqli_real_escape_string ($yhteys, $_POST['email']);
  }
  else {
    header("Location:rekisteroidy.php");
    exit;
  }

  if (isset($_POST["city"])){
    $city=mysqli_real_escape_string ($yhteys, $_POST['city']);
  }
  else {
    header("Location:rekisteroidy.php");
    exit;
  }

  if (isset($_POST["uid"])){
    $uid=mysqli_real_escape_string ($yhteys, $_POST['uid']);

}
  
  else {
    header("Location:rekisteroidy.php");
    exit;
  }

  if (isset($_POST["pwd"])){
    $pwd=mysqli_real_escape_string ($yhteys, $_POST['pwd']);
  }
  else {
    header("Location:rekisteroidy.php");
    exit;
  }
  
   if (isset($_POST["cpwd"])){
    $cpwd=mysqli_real_escape_string ($yhteys, $_POST['cpwd']);
  }
  else {
    header("Location:rekisteroidy.php");
    exit;
  }

} else { // jos submit ei ole painettu, siirrytään rekisteröintisivulle, koska ei haluta pääsyä urlilla
  header("Location:rekisteroidy.html");
  exit;
}

$passwordmd5 = md5($pwd);//suojataan salasana, tallennetaan tietokantaan suojattuna
$cpasswordmd5 = md5($cpwd);
if ($pwd == $cpwd) {
		
$query = mysqli_query($yhteys, "SELECT user_uid FROM dbt_name WHERE user_uid='$uid'");
	
if (mysqli_num_rows($query) > 0 ){
	 echo 'Nimimerkki on jo käytössä';
    header("location:rekisteroidy.php?tunnuskaytossa");
    exit;
  } else {

$sql="INSERT INTO juho1806_register(user_first, user_last, user_city, user_email, user_uid, user_pwd) VALUES(?, ?, ?, ?, ?, ?)";
$stmt=mysqli_prepare($yhteys, $sql);
mysqli_stmt_bind_param($stmt, 'ssssss', $first, $last, $city, $email, $uid, $passwordmd5);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($yhteys);

$_SESSION['uid']=$uid;
$_SESSION['first']=$first;

header("Location:tervetuloa.php");
exit;
  }
}else{
	header("location:rekisteroidy.php?pwderror");
	exit;
}
?>
