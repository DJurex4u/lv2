<?php
session_start();

$filename = $_FILES['file']['name'];

$location = "uploads/" . $filename;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION);
$content = file_get_contents($_FILES['file']['tmp_name']);

//Ključ za enkripciju, 256 bitni
$encryption_key = md5('jed4n j4k0 v3l1k1 kljuc');
//Odaber cipher metodu AES
$cipher = "AES-128-CTR";
//Stvori IV sa ispravnom dužinom
$iv_length = openssl_cipher_iv_length($cipher);
$options = 0;
// Non-NULL inicijalizacijski vektor za enkripciju
//Random dužine 16 byte
$encryption_iv = random_bytes($iv_length);
// Kriptiraj podatke sa openssl
$encrypted = openssl_encrypt($content, $cipher, $encryption_key, $options, $encryption_iv);
//Spremi podatke
$encryptedData = base64_encode($encrypted);
$_SESSION['iv'] = $encryption_iv;

$fileNameWithoutExt = substr($filename, 0, strpos($filename, "."));
$fileNameOnServer = "uploads/${fileNameWithoutExt}.$imageFileType.txt";

file_put_contents($fileNameOnServer, $encryptedData);

echo "Datoteka uploadana";

