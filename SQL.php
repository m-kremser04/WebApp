<?php

class SQL
{


  public static function Writeshitsql($json, $pwd_hashed, $tmp_file)
  {
    $json = json_decode($json, true);


    $servername = "localhost";
    $database = "mydb";
    $username = "markus.kremser";
    $password = "Test.123";


    try {
      $conn = new mysqli($servername, $username, $password, $database);

// Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "shitty connecty";
      }

// prepare and bind
      $stmt = $conn->prepare("INSERT INTO userdaten (idUserDaten, Vorname, Nachname, Geburtsdatum, Email, Passwort, PLZ, Adressdaten_PLZ, Telnummer, Profilbildpfad) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?,?, ?)");
      $stmt->bind_param("sssssiiis", $json['fname'], $json['nname'], $json['Geburtsdatum'], $json['mail'], $pwd_hashed, $json['PLZ'], $json['PLZ'], $json['Telnummer'], $tmp_file);

      $tbl = $conn->prepare("INSERT INTO adressdaten (PLZ, Ort, Land, Adresse) VALUES (?,?,?,?)");
      $tbl->bind_param("isss", $json['PLZ'], $json['Ort'], $json['Bundesland'], $json['Adresse']);

      $tbl->execute();
      $stmt->execute();

// set parameters and execute



      $stmt->close();
      $conn->close();
    } catch (PDOException $e) {
      echo('Fehler: ' . $e->getMessage());
    }
  }
}
