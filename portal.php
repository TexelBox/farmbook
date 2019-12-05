<?php
    $pageTitle = "PORTAL";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "login.php";
    $navbarLink2Title = "LOGIN";
    $navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL";
    require_once("header.php");
    require_once("database.php");

    if (!isset($_SESSION["logged_in"])) header("Location: login.php");
?>

<!-- DYNAMIC PAGE CONTENT -->
<!-- EXAMPLE USAGE -->
<?php if (isset($_SESSION["admin"])) : ?>
    <div class="container">
        <a class="btn btn-danger btn-lg btn-block" href="damage_by_time.php">DAMAGE STUFF</a>
    </div>
<?php else : ?>
    <div class="container">
        <a class="btn btn-danger btn-lg btn-block disabled" href="#">DAMAGE STUFF</a>
    </div>
<?php endif; ?>


<?php
    require_once("footer.php");
?>