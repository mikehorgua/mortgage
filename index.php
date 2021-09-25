<?php
include('mysql.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    </style></head>
<body>

<?php
if ($_GET["page"]) {
    $page = $_GET["page"];
}

If ($page=='calc') {
    $title = '';
    $subtitle = '';
    $text = '';
} elseIf ($page=='banks') {
    $title = '';
    $subtitle = '';
    $text = '';
} elseIf ($page=='history') {
    $title = '';
    $subtitle = '';
    $text = '';
} else {
    $title = 'About this project';
    $subtitle = 'How to use this calculator?';
    $text = '<p>We are a interior design service that focus on what\'s best for your home and what\'s best for you!</p>
        <p>Some text about our services - what we do and what we offer. We are lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </p>';
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
    <div class="w3-container" id="packages" style="margin-top:75px">
        <h1 class="w3-xxxlarge w3-text-green"><b>Packages.</b></h1>
        <p>Some text our prices. Lorem ipsum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure</p>
    </div>

    <div class="w3-row-padding">
        <div style="margin-top:75px" class="w3-col m3 w3-margin-bottom w3-padding-16">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-green w3-xlarge w3-padding-32">Basic</li>
                <li class="w3-padding-16">Floorplanning</li>
                <li class="w3-padding-16">10 hours support</li>
                <li class="w3-padding-16">Photography</li>
                <li class="w3-padding-16">20% furniture discount</li>
                <li class="w3-padding-16">Good deals</li>
                <li class="w3-padding-16">
                    <h2>$ 199</h2>
                    <span class="w3-opacity">per room</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-green w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>

        <div style="margin-top:75px" class="w3-col m3 w3-padding-16">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-green w3-xlarge w3-padding-32">Pro</li>
                <li class="w3-padding-16">Floorplanning</li>
                <li class="w3-padding-16">50 hours support</li>
                <li class="w3-padding-16">Photography</li>
                <li class="w3-padding-16">50% furniture discount</li>
                <li class="w3-padding-16">GREAT deals</li>
                <li class="w3-padding-16">
                    <h2>$ 249</h2>
                    <span class="w3-opacity">per room</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-green w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>

        <div style="margin-top:75px"  class="w3-col m3 w3-padding-16">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-green w3-xlarge w3-padding-32">Pro</li>
                <li class="w3-padding-16">Floorplanning</li>
                <li class="w3-padding-16">50 hours support</li>
                <li class="w3-padding-16">Photography</li>
                <li class="w3-padding-16">50% furniture discount</li>
                <li class="w3-padding-16">GREAT deals</li>
                <li class="w3-padding-16">
                    <h2>$ 249</h2>
                    <span class="w3-opacity">per room</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-green w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>

        <div style="margin-top:75px" class="w3-col m3 w3-padding-16">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-green w3-xlarge w3-padding-32">Pro</li>
                <li class="w3-padding-16">Floorplanning</li>
                <li class="w3-padding-16">50 hours support</li>
                <li class="w3-padding-16">Photography</li>
                <li class="w3-padding-16">50% furniture discount</li>
                <li class="w3-padding-16">GREAT deals</li>
                <li class="w3-padding-16">
                    <h2>$ 249</h2>
                    <span class="w3-opacity">per room</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-green w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>

        <div style="margin-top:75px" class="w3-col m3 w3-padding-16">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-green w3-xlarge w3-padding-32">Pro</li>
                <li class="w3-padding-16">Floorplanning</li>
                <li class="w3-padding-16">50 hours support</li>
                <li class="w3-padding-16">Photography</li>
                <li class="w3-padding-16">50% furniture discount</li>
                <li class="w3-padding-16">GREAT deals</li>
                <li class="w3-padding-16">
                    <h2>$ 249</h2>
                    <span class="w3-opacity">per room</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-green w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>

        <div style="margin-top:75px" class="w3-col m3 w3-padding-16">
            <ul class="w3-ul w3-light-grey w3-center">
                <li class="w3-green w3-xlarge w3-padding-32">Pro</li>
                <li class="w3-padding-16">Floorplanning</li>
                <li class="w3-padding-16">50 hours support</li>
                <li class="w3-padding-16">Photography</li>
                <li class="w3-padding-16">50% furniture discount</li>
                <li class="w3-padding-16">GREAT deals</li>
                <li class="w3-padding-16">
                    <h2>$ 249</h2>
                    <span class="w3-opacity">per room</span>
                </li>
                <li class="w3-light-grey w3-padding-24">
                    <button class="w3-button w3-green w3-padding-large w3-hover-black">Sign Up</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px">
    <p class="w3-right">
        Designed by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a>
    </p>
    <p class="w3-right">
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
</script>

</body>
</html>