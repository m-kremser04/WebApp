
<?php

require_once('SQL.php');

require_once("config.php");
global $config;

$result = array(
  "status" => true
);



$pepper = $config['pepper'];
$pwd = $_POST['password1'];
$pwd_peppered = hash_hmac("sha256", $pwd, $pepper);
$pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);



echo json_encode($result);

$tmp_file = $_FILES["file"]['tmp_name'];
move_uploaded_file($tmp_file, "C:/Users/markus.kremser/Desktop/".$_FILES['file']['name']);

$fp = fopen('daten.csv', 'w');

$content = file_get_contents("daten.csv");
if(empty($content)){
  $content = "Vorname;Nachname;Geburtsdatum;mail;passwort;adresse;wohnort;plz;bundesland;Telnummer;Profilbild\n";
}
$content.= "\"".$_POST['fname']."\";\"".$_POST['nname']."\";\"".$_POST['Geburtsdatum']."\";\"".$_POST['mail']."\";\"".$pwd_hashed."\";\"".$_POST['Adresse']."\";\"".$_POST['Ort']."\";\"".$_POST['PLZ']."\";\"".$_POST['Bundesland']."\";\"".$_POST['Telnummer']."\";\"".$tmp_file."\"\n";

fwrite($fp, $content);
fclose($fp);

$json = json_encode($_POST);

SQL::Writeshitsql($json, $pwd_hashed, $tmp_file);



?>



