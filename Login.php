<?php

require_once("config.php");
global $config;

$servername = "mk-3012.mysql.database.azure.com";
$username = "kremser_admin";
$password = "Test.123";
$dbname = "website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$email = $_POST['email'];
$stmt = $conn->prepare("SELECT Email, Passwort FROM userdaten WHERE Email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$user = array();
if ($row = $result->fetch_assoc()) {
  $user["email"] = $row["Email"];
  $user["passwort"] = $row["Passwort"];
}

echo $user["passwort"];

$pepper = $config['pepper'];

$pwd1 = $_POST['password'];
$pwd_peppered1 = hash_hmac("sha256", $pwd1, $pepper);

echo "     TEST       ";


if(password_verify($pwd_peppered1, $user["passwort"])){
    session_start();
    $_SESSION['user'] = $username;
    header("location: index.html");
    exit();
}
else{
  echo '<sript>alert("Die Userdaten stimmen nicht")</sript>';
}

$conn->close();


?>
