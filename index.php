<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('dbsettings.php');
$block = '';
$text = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mortgage calculator</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <style>
        body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
        body {font-size:16px;}
        .w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
        .w3-half img:hover{opacity:1}
        .dropbtn {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #3e8e41;
        }

        #myInput {
            box-sizing: border-box;
            background-position: 14px 12px;
            background-repeat: no-repeat;
            font-size: 16px;
            padding: 14px 20px 12px 20px;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        #myInput:focus {outline: 3px solid #ddd;}

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f6f6f6;
            min-width: 230px;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {background-color: #ddd;}

        .show {display: block;}
    </style></head>
<body>

<?php
if ($_GET["page"]) {
    $page = $_GET["page"];
} else {
    $page='';
}

If ($page=='calcresult') {
    $title = 'Your mortgage plan';
    $subtitle = 'Thanks for using this calculator! Also you can step back and enter other data.';


    $startamount = floatval(str_replace(',', '.', str_replace('.', '', $_POST['full'])));
    $down = floatval(str_replace(',', '.', str_replace('.', '', $_POST['down'])));
    $bank = (int)$_POST['bank'];
    $amount = $startamount - $down;
    if ($bank != '') {
        $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
        $query = "SELECT * FROM `banks` WHERE nom = ".$bank;
        if ($result = mysqli_query($link, $query)) {
            /* fetch associative array */
            while ($row = mysqli_fetch_row($result)) {
                $bankname = $row[1];
                $rate = $row[2];
                $maxloan = $row[3];
                $mindown = $row[4];
                $mon = $row[5];

            }
            /* free result set */
            mysqli_free_result($result);
        }

        if($amount>$maxloan) {
            $text = '<h1 class="w3-large w3-text-red"><b>Error: your loan is bigger than bank offers.</b></h1>';
        }
        else
        {
            if($down<($startamount*$mindown/100)) {
                $text = '<h1 class="w3-large w3-text-red"><b>Error: your down payment is less than bank require.</b></h1>';
            }
            else
            {
                $monthly = ($amount*($rate/1200)*((1+($rate/1200))**$mon))/(((1+($rate/1200))**$mon)-1);
                $monthly = round($monthly, 2);
                $block .= '
                        <div class="w3-row-padding w3-center">
                            <div style="margin-top:75px" class="w3-col m6 w3-margin-bottom w3-padding-16">
                                <ul class="w3-ul w3-light-grey w3-center">
                                    <li class="w3-green w3-xlarge w3-padding-32">'.$bankname.'</li>
                                    <li class="w3-padding-16"><h3>$'.$startamount.'</h3>
                                        <span class="w3-opacity">you borrow</span></li>
                                    <li class="w3-padding-16"><h3>$'.$down.'</h3>
                                        <span class="w3-opacity">your first payment</span></li>
                                    <li class="w3-padding-16"><h3>'.$rate.' % </h3>
                                        <span class="w3-opacity">annual rate</span></li>
                                    <li class="w3-padding-16"><h3>'.$mon.' </h3>
                                        <span class="w3-opacity">months</span></li>
                                    <li class="w3-padding-16">
                                        <h2>$ '.$monthly.'</h2>
                                        <span class="w3-opacity">per month</span>
                                    </li>
                                    <!--<li class="w3-light-grey w3-padding-24">
                                        <button class="w3-button w3-green w3-padding-large w3-hover-black">Sign Up</button>
                                    </li>-->
                                </ul>
                            </div>
                        </div>   
	            	';
                $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
                $query = "INSERT INTO `requests` (`nom`, `initialloan`, `downpaym`, `banknom`) VALUES (NULL, '".$startamount."', '".$down."', '".$bank."'); ";
                mysqli_query($link, $query);
                }
            }

    } else { $text = '<h1 class="w3-xxxlarge w3-text-red"><b>Error: no bank found.</b></h1>'; }



}
elseIf ($page=='calc') {
    $title = 'Enter your data';
    $subtitle = 'Here you should provide your preferred options of mortgage.';
    $bankslist = '';


    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `banks` WHERE visib = 1;";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $bankslist .= '<a onclick="document.getElementById(\'searchbuttonname\').innerHTML=\''.$row[1].'\';document.getElementById(\'submitbutton\').removeAttribute(\'disabled\');document.getElementById(\'bank\').value = \''.$row[0].'\';document.getElementById(\'myDropdown\').classList.toggle(\'show\');">'.$row[1].'</a>';

        }
        /* free result set */
        mysqli_free_result($result);
    }

    $text = '    <form method="post" action="?page=calcresult" target="_self">
      <div class="w3-section">
        <label>Full amount of money:</label>
        <input class="w3-input w3-border" type="number" min="1" max="999999999.99" step="0.01" name="full" required autofocus placeholder="Use only numbers and dot. Ex.: 200000.50">
      </div>
      <div class="w3-section">
        <label>Down payment</label>
        <input class="w3-input w3-border" type="number" min="1" max="999999999.99" placeholder="Use only numbers and dot. Ex.: 10000.99" step="0.01" name="down" required>
      </div>
      <!--<div class="w3-section">
        <label>Number of months</label>
        <input class="w3-input w3-border" type="number" min="1" max="9999" placeholder="Use only numbers. Ex.: 240" step="1" name="mon" required>
      </div>-->
      <div class="w3-section">
        <label>Bank</label>
        <a href="?page=banks"><i>Don\'t see your bank?</i></a>
        <input class="w3-input w3-border" type="hidden"  id="bank" name="bank" required>
            <div class="w3-input w3-border dropdown">
              <div onclick="myFunction()" ><span id="searchbuttonname">Choose bank</span></div>
              <div id="myDropdown" class="dropdown-content">
                <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
                '.$bankslist.'
              </div>
            </div>
      </div>
      <button id="submitbutton" disabled type="submit" class="w3-button w3-block w3-padding-large w3-green w3-margin-bottom">Calculate now!</button>
    </form>  ';
}
elseIf ($page=='banks') {
    $title = 'Bank list management';
    $subtitle = 'Add, edit or delete your preferred banks.';
    $text = '<div class="w3-row-padding w3-center w3-green">
<div style="" class="w3-col m1 w3-margin-bottom w3-green w3-padding-16">No.</div>
<div style="" class="w3-col m2 w3-margin-bottom  w3-green w3-padding-16">Bank Name</div>
<div style="" class="w3-col m1 w3-margin-bottom w3-green  w3-padding-16">Annual Interest Rate</div>
<div style="" class="w3-col m2 w3-margin-bottom  w3-green w3-padding-16">Max loan amount</div>
<div style="" class="w3-col m1 w3-margin-bottom w3-green  w3-padding-16">Min Down amount</div>
<div style="" class="w3-col m2 w3-margin-bottom  w3-green w3-padding-16">Loan term</div>
<div style="" class="w3-col m3 w3-margin-bottom w3-green  w3-padding-16">Actions with bank</div>
</div>';
    $text .= '<div class="w3-row-padding w3-center ">
<div style="" class="w3-col m12 w3-margin-bottom w3-grey w3-padding-16">Active banks list</div>
</div>';

    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `banks` WHERE visib = 1;";
        if ($result = mysqli_query($link, $query)) {
            /* fetch associative array */
            while ($row = mysqli_fetch_row($result)) {
                $text .= '<div class="w3-row-padding w3-center">
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16">'.$row[0].'</div>
<div style="" class="w3-col m2 w3-margin-bottom w3-padding-16 ">'.$row[1].'</div>
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16">'.floatval($row[2]).' %</div>
<div style="" class="w3-col m2 w3-margin-bottom w3-padding-16">$ '.floatval($row[3]).'</div>
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16">'.floatval($row[4]).' %</div>
<div style="" class="w3-col m2 w3-margin-bottom w3-padding-16">'.floatval($row[5]).' months</div>
<div style="" class="w3-col m3 w3-margin-bottom w3-padding-16"><a href="?page=bc&nom='.$row[0].'">Change</a> - <a href="?page=bd&nom='.$row[0].'">Delete</a></div>
</div>';
                }
            /* free result set */
            mysqli_free_result($result);
        }

    $text .= '<div class="w3-row-padding w3-center ">
<div style="" class="w3-col m12 w3-margin-bottom w3-light-grey w3-padding-16"><a href="?page=ba">+ Add your bank</a></div>
</div>';
    $text .= '<div class="w3-row-padding w3-center ">
<div style="" class="w3-col m12 w3-margin-bottom w3-grey w3-padding-16">Deleted banks list</div>
</div>';

    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `banks` WHERE visib = 0;";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $text .= '<div class="w3-row-padding w3-center">
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16 w3-light-grey">'.$row[0].'</div>
<div style="" class="w3-col m2 w3-margin-bottom w3-padding-16 w3-light-grey">'.$row[1].'</div>
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16 w3-light-grey">'.floatval($row[2]).' %</div>
<div style="" class="w3-col m2 w3-margin-bottom w3-padding-16 w3-light-grey">$ '.floatval($row[3]).'</div>
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16 w3-light-grey">'.floatval($row[4]).' %</div>
<div style="" class="w3-col m2 w3-margin-bottom w3-padding-16 w3-light-grey">'.floatval($row[5]).' months</div>
<div style="" class="w3-col m3 w3-margin-bottom w3-padding-16 w3-light-grey"><a href="?page=br&nom='.$row[0].'">Restore</a></div>
</div>';
        }
        /* free result set */
        mysqli_free_result($result);
    }
}
elseIf ($page=='history') {
    $title = 'Customer request history';
    $subtitle = '';
    $text = '';
    $text .= '<div class="w3-row-padding w3-center w3-green">
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16 ">No.</div>
<div style="" class="w3-col m5 w3-margin-bottom w3-padding-16 ">Initial Amount</div>
<div style="" class="w3-col m6 w3-margin-bottom w3-padding-16 ">Down payment</div>
</div>';
    $nombank = (int)$_GET['nom'];
    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `banks` WHERE nom = ".$nombank.";";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $subtitle = $row[1];
        }
        /* free result set */
        mysqli_free_result($result);
    }
    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `requests` WHERE banknom = ".$nombank.";";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $text .= '<div class="w3-row-padding w3-center">
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16 w3-light-grey">'.$row[0].'</div>
<div style="" class="w3-col m5 w3-margin-bottom w3-padding-16 ">$ '.floatval($row[1]).'</div>
<div class="w3-col m6 w3-margin-bottom w3-padding-16 w3-light-grey">$ '.floatval($row[2]).'</div>
</div>';
        }
        /* free result set */
        mysqli_free_result($result);
    }
}
elseIf ($page=='historybanks') {
    $title = 'Customer request history';
    $subtitle = '';
    $text = '';
    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `banks`;";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $hash = md5($row[0] . 'morgage-H3rj8fehjh');
            $text .= '<div class="w3-row-padding w3-center">
<div style="" class="w3-col m1 w3-margin-bottom w3-padding-16">'.$row[0].'</div>
<div style="" class="w3-col m6 w3-margin-bottom w3-padding-16">'.$row[1].'</div>
<div style="" class="w3-col m5 w3-margin-bottom w3-padding-16"><a href="?page=history&nom='.$row[0].'">Lookup history</a><BR>
<a target="_blank" href="json.api.php?nom='.$row[0].'&hash='.$hash.'">JSON API</a></div>
</div>';
        }
        /* free result set */
        mysqli_free_result($result);
    }
}
elseIf ($page=='bc') {
    $title = 'Changing bank';
    $subtitle = '';
    $text = '';
    $nombank = (int)$_GET['nom'];
    $link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
    $query = "SELECT * FROM `banks` WHERE nom = ".$nombank.";";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $text .= '    <form method="post" action="?page=bcr" target="_self">
      <div class="w3-section">
        <label>Bank name:</label>
        <input class="w3-input w3-border" type="text" name="bankname" required autofocus placeholder="Ex.: Silver Spring Bank" value="'.$row[1].'">
      </div>
      <div class="w3-section">
        <label>Interest rate:</label> (in % )
        <input class="w3-input w3-border" type="number" min="1" max="999999999.9999" step="0.0001" name="interestrate" required placeholder="Use only numbers and dot. Ex.: 10.1574" value="'.floatval($row[2]).'">
      </div>
      <div class="w3-section">
        <label>Max loan amount:</label> (in US$)
        <input class="w3-input w3-border" type="number" min="1" max="999999999.99" placeholder="Use only numbers and dot. Ex.: 10000.99" step="0.01" name="maxloan" required value="'.floatval($row[3]).'">
      </div>
      <div class="w3-section">
        <label>Min down percent:</label> (in % )
        <input class="w3-input w3-border" type="number" min="1" max="999999999.99" placeholder="Use only numbers and dot. Ex.: 5.5" step="0.01" name="mindown" required value="'.floatval($row[4]).'">
      </div>
            <div class="w3-section">
        <label>Loan term:</label> (in months)
        <input class="w3-input w3-border" type="number" min="1" max="999999999" placeholder="Use only numbers and dot. Ex.: 240" step="1" name="loanterm" required value="'.floatval($row[5]).'">
        <input  type="hidden"  name="nom"  value="'.$row[0].'">
      </div>
      <!--<div class="w3-section">
        <label>Number of months</label>
        <input class="w3-input w3-border" type="number" min="1" max="9999" placeholder="Use only numbers. Ex.: 240" step="1" name="mon" required>
      </div>-->
      <button id="submitbutton"  type="submit" class="w3-button w3-block w3-padding-large w3-green w3-margin-bottom">Change bank info!</button>
    </form>  ';
        }
        /* free result set */
        mysqli_free_result($result);
    }
}
elseIf ($page=='ba') {
    $title = 'Adding bank';
    $subtitle = '';
    $text = '';

            $text .= '    <form method="post" action="?page=bar" target="_self">
      <div class="w3-section">
        <label>Bank name:</label>
        <input class="w3-input w3-border" type="text" name="bankname" required autofocus placeholder="Ex.: Silver Spring Bank" >
      </div>
      <div class="w3-section">
        <label>Interest rate:</label> (in % )
        <input class="w3-input w3-border" type="number" min="1" max="999999999.9999" step="0.0001" name="interestrate" required placeholder="Use only numbers and dot. Ex.: 10.1574">
      </div>
      <div class="w3-section">
        <label>Max loan amount:</label> (in US$)
        <input class="w3-input w3-border" type="number" min="1" max="999999999.99" placeholder="Use only numbers and dot. Ex.: 10000.99" step="0.01" name="maxloan" required >
      </div>
      <div class="w3-section">
        <label>Min down percent:</label> (in % )
        <input class="w3-input w3-border" type="number" min="1" max="999999999.99" placeholder="Use only numbers and dot. Ex.: 5.5" step="0.01" name="mindown" required>
      </div>
            <div class="w3-section">
        <label>Loan term:</label> (in months)
        <input class="w3-input w3-border" type="number" min="1" max="999999999" placeholder="Use only numbers and dot. Ex.: 240" step="1" name="loanterm" required >
      </div>
      <!--<div class="w3-section">
        <label>Number of months</label>
        <input class="w3-input w3-border" type="number" min="1" max="9999" placeholder="Use only numbers. Ex.: 240" step="1" name="mon" required>
      </div>-->
      <button id="submitbutton"  type="submit" class="w3-button w3-block w3-padding-large w3-green w3-margin-bottom">Add bank info!</button>
    </form>  ';

}
elseIf ($page=='bar') {
    $title = 'Adding bank...';
    $subtitle = '';
    $text = 'Wait for redirect...<meta http-equiv="refresh" content="0; url=?page=banks" />';
$link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
$query = "INSERT INTO `banks` (`nom`, `bankname`, `interestrate`, `maxloan`, `mindown`, `loanterm`, `visib`) VALUES (NULL, '".mysqli_real_escape_string($link, $_POST['bankname'])."', '".floatval($_POST['interestrate'])."', '".floatval($_POST['maxloan'])."', '".floatval($_POST['mindown'])."', '".(int)$_POST['loanterm']."', '1');";
mysqli_query($link, $query);
}
elseIf ($page=='bcr') {
    $title = 'Changing bank...';
    $subtitle = '';
    $text = 'Wait for redirect...<meta http-equiv="refresh" content="0; url=?page=banks" />';
$nombank = (int)$_POST['nom'];
$link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
$query = "UPDATE `banks` SET `bankname` = '".mysqli_real_escape_string($link, $_POST['bankname'])."', `interestrate` = '".floatval($_POST['interestrate'])."', `maxloan` = '".floatval($_POST['maxloan'])."', `mindown` = '".floatval($_POST['mindown'])."', `loanterm` = '".(int)$_POST['loanterm']."' WHERE `banks`.`nom` = ".$nombank.";";
mysqli_query($link, $query);
}
elseIf ($page=='bd') {
    $title = 'Deleting bank...';
    $subtitle = '';
    $text = 'Wait for redirect...<meta http-equiv="refresh" content="0; url=?page=banks" />';
$nombank = (int)$_GET['nom'];
$link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
$query = "UPDATE `banks` SET `visib` = '0' WHERE `banks`.`nom` = ".$nombank.";";
mysqli_query($link, $query);
}
elseIf ($page=='br') {
    $title = 'Restoring bank';
    $subtitle = '';
    $text = 'Wait for redirect...<meta http-equiv="refresh" content="0; url=?page=banks" />';
$nombank = (int)$_GET['nom'];
$link = mysqli_connect($db_location, $db_user, $db_password ,  $db_name);
$query = "UPDATE `banks` SET `visib` = '1' WHERE `banks`.`nom` = ".$nombank.";";
mysqli_query($link, $query);
}
else {
    $title = 'About this project';
    $subtitle = 'How to use this calculator?';
    $text = '
    <p>You can calculate the value of a mortgage, knowing only its initial cost and the first payment.</p>
    <p>If the proposed banks are not enough - you can add your own or edit an existing one.</p>
    <p>Banks have the ability to view all user calculations, as well as gain remote access to API data (JSON).</p>
    ';
}

?>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-green w3-collapse w3-top w3-large w3-padding" style="z-index:3; width:300px; font-weight:bold;" id="mySidebar"><br>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
    <div class="w3-container">
        <h3 class="w3-padding-64"><b>Mortgage <BR> calculator</b></h3>
    </div>
    <div class="w3-bar-block">
        <a href="?page=" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">About</a>
        <a href="?page=calc" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Calculator</a>
        <a href="?page=banks" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Manage banks</a>
        <a href="?page=historybanks" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Bank loan history</a>
    </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-green w3-xlarge w3-padding">
    <a href="javascript:void(0)" class="w3-button w3-green w3-margin-right" onclick="w3_open()">☰</a>
    <span>Mortgage calculator</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

    <!-- Header -->
    <div class="w3-container" style="margin-top:80px" id="showcase">
        <h1 class="w3-jumbo"><b><?php echo $title; ?> </b></h1>
    </div>


    <!-- Services -->
    <div class="w3-container" id="services" style="margin-top:75px">
        <h1 class="w3-xxxlarge w3-text-green"><b><?php echo $subtitle; ?></b></h1>
        <p><?php echo $text; ?></p>
    </div>

    <!-- Packages / Pricing Tables -->

    <?php echo $block; ?>

    <!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px">
    <p class="w3-right">
        Designed by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a>
        <Br>
        Mykhailo Hrabynskyi for ElifTech IT School Test task
    </p>
</div>

<script>
    // Script to open and close sidebar
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
    }

    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
    }

    // Modal Image Gallery
    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
        var captionText = document.getElementById("caption");
        captionText.innerHTML = element.alt;
    }
    /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
</script>

</body>
</html>