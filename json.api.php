<?php
$nom = $_GET['nom'];
$hash =  $_GET['hash'];
$hashcheck = md5((int)$nom.'morgage-H3rj8fehjh');

if($hash==$hashcheck){
    include('dbsettings.php');

    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `requests` WHERE banknom = ".$nom.";";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $myArray[] = $row;
        }
        echo json_encode($myArray);
        /* free result set */
        mysqli_free_result($result);
    }

}
else {
    echo 'error: hash is invalid';
}