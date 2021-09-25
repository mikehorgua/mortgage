<?php
// include('mysql.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$block = '';
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
            padding: 14px 20px 12px 45px;
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
    $subtitle = '...';

    $amount = $startamount - $down;
    //$monthly = ($amount*($rate/12)*((1+($rate/12))**$mon))/(((1+($rate/12))**$mon)-1);
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

    $text = '';
} elseIf ($page=='calc') {
    $title = 'Enter your data';
    $subtitle = 'Here you should provide your preferred options of mortgage.';
    $bankslist = '';

    $db_location = "db.tzk612.nic.ua";
    $db_user = "mikehorg_mortgage";
    $db_password = "975864";
    $db_name = "mikehorg_mortgage";
    $link = mysqli_connect("db.tzk612.nic.ua", "mikehorg_mortgage", "975864", "mikehorg_mortgage");
    echo mysqli_get_host_info($link);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $query = "SELECT * FROM `banks`";
    if ($result = mysqli_query($link, $query)) {
        /* fetch associative array */
        while ($row = mysqli_fetch_row($result)) {
            $bankslist .= '<a onclick="document.getElementById(\'searchbuttonname\').innerHtml=\''.$row[bankname].'\';document.getElementById(\'submitbutton\').removeAttribute(\'disabled\');document.getElementById(\'bank\').value = \''.$row[nom].'\';document.getElementById(\'myDropdown\').classList.toggle(\'show\');">'.$row[bankname].'</a>';

        }
        /* free result set */
        mysqli_free_result($result);
    }

    $text = '    <form method="post" action="?page=calcresult" target="_self">
      <div class="w3-section">
        <label>Full amount of money:</label>
        <input class="w3-input w3-border" type="text" name="full" required>
      </div>
      <div class="w3-section">
        <label>Down payment</label>
        <input class="w3-input w3-border" type="text" name="Down" required>
      </div>
      <div class="w3-section">
        <label>Bank</label>
        <input class="w3-input w3-border" type="hidden"  id="bank" name="Bank" required>
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
} elseIf ($page=='banks') {
    $title = 'Bank list management';
    $subtitle = 'Add, edit or delete your preferred banks.';
    $text = '';
} elseIf ($page=='history') {
    $title = 'Customer request history';
    $subtitle = '';
    $text = '';
} else {
    $title = 'About this project';
    $subtitle = 'How to use this calculator?';
    $text = '
    <p>We are a interior design service that focus on what\'s best for your home and what\'s best for you!</p>
    <p>We are a interior design service that focus on what\'s best for your home and what\'s best for you!</p>
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
        <a href="?page=banks" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Choose banks</a>
        <a href="?page=history" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Bank loan history</a>
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
        <?php echo $text; ?>
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