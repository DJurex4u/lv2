<?php
session_start();

if (!is_dir("uploads/")) {
    echo "<p>Nema dokumenata</p>";
    die();
}

$files = array_diff(scandir("uploads/"), array('..', '.'));

$txtFile = function ($value) {
    return (pathinfo($value, PATHINFO_EXTENSION) === 'txt');
};

$files = array_filter($files, $txtFile);

if (count($files) === 0) {
    echo "<p>Nema dokumenata</p>";
} else {
    echo "<ul>";
    foreach ($files as $file) {
        $nameWithoutExt = substr($file, 0, strlen($file) - 4);
        echo "<li> <a href=\"download.php?file=$nameWithoutExt\">$nameWithoutExt</a></li>";
    }
    echo "</ul>";
}
?>



