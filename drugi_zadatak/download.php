<?php
session_start();
$file = $_GET['file'];
//Stvori ključ
$decryption_key = md5('jed4n j4k0 v3l1k1 kljuc');
//Odaber cipher metodu AES
$cipher = "AES-128-CTR";
$options = 0;
//Dohvati IV i kriptirane podatke
$decryption_iv = $_SESSION['iv'];
$contentEncrypted = file_get_contents("uploads/$file.txt");
// Dekriptiraj podatke:
$contentDecrypted = base64_decode($contentEncrypted);
$data = openssl_decrypt($contentDecrypted, $cipher, $decryption_key, $options, $decryption_iv);

$file = "uploads/$file";
file_put_contents($file, $data);
clearstatcache();

if(file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file, true);
    unlink($file);
    die();
}
