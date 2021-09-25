<?php
$db_location = "db.tzk612.nic.ua";
$db_user = "mikehorg_mortgage";
$db_password = "975864";
$db_name = "mikehorg_mortgage";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli($db_location, $db_user, $db_password, $db_name);
/*
$db_cnx = @mysql_connect($db_location,$db_user,$db_password);
if (!$db_cnx) {
// if descriptor = 0 then not connected
    echo "<p>Виникли проблеми із під'єднуванням сервера бази даних.</p>";
    exit ();
}

if (!@mysql_select_db($db_name,$db_cnx)) {
    echo "<p>Виникли проблеми із під'єднуванням бази даних.</p>";
    exit ();
}
*/
?>

