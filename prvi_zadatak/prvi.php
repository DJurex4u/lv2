<?php

$dbName = "radovi";

$dir = "backupBazeRadova/$dbName";
if (!is_dir($dir)) {
    // mkdir($dir, 0777, 1);
    mkdir($dir);
}

$db = mysqli_connect("localhost", "root", "", $dbName);

$textFiles = [];
$r = mysqli_query($db, "SHOW TABLES");
    echo "<p>Početak</p>";

while (list($table) = mysqli_fetch_array($r, MYSQLI_NUM)) {
    $query = "SELECT * FROM $table";
    $col = array_map('columnName', $db->query($query)->fetch_fields());
    $r2 = mysqli_query($db, $query);

    if (mysqli_num_rows($r2) > 0) {
        $fileName = "{$table}";
        if ($fp = fopen("$dir/$fileName.txt", "w9")) {
            array_push($textFiles, $fileName);
            while ($row = mysqli_fetch_array($r2, MYSQLI_NUM)) {
                $rowText = "INSERT INTO $table (";

                for ($i = 0; $i < count($col); $i++) {
                    $rowText .= "$col[$i]";
                    if ($i + 1 != count($col)) {
                        $rowText .= ", ";
                    } 
                }

                $rowText .= ") VALUES (";
                for ($i = 0; $i < count($row); $i++) {
                    $rowText .= "'$row[$i]'";
                    if ($i + 1 != count($row)) {
                        $rowText .= ", ";
                    } 
                }
                $rowText .= ");\n";
                fwrite($fp, $rowText);
            }
            fclose($fp);

            echo "<p>Pohrana: Dovršeno</p>";

            if ($fp = gzopen ("$dir/" . $fileName . ".sql.gz", 'w9')) {
                $content = file_get_contents("backupBazeRadova/radovi/$fileName.txt");
                gzwrite($fp, $content);
                unlink("backupBazeRadova/radovi/$fileName.txt");
                gzclose($fp);

                echo "<p>Sažimanje: Dovršeno</p>";
            } 
        } 
    }
}

function columnName($value) {
    return $value->name;
};
