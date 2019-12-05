<?php
    $pageTitle = "LOGOUT";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL"; 
    require_once("header.php");
    require_once("database.php");

    // if user is not logged in...
    if (!isset($_SESSION["logged_in"])) header("Location: login.php");

    session_destroy();
?>

<section id="showcase">
    <div class="container">
        <h1>YOU HAVE BEEN SUCCESSFULLY LOGGED-OUT!</h1>
    </div>
</section>

<?php
    require_once("footer.php");
?>