<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title><?= isset($pageTitle) ? $pageTitle : "TITLE"?></title>

        <!-- TODO: set these later -->
        <meta name="description" content="description" />
        <meta name="keywords" content="keywords" />
        <meta name="author" content="author" />

        <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>            
        <script src="js/jquery.tabledit.min.js"></script>
        <script src="js/custom_table_edit.js"></script>
        <script src="js/custom_table_edit2.js"></script>
        <script src="js/custom_table_edit3.js"></script>
    </head>
    <body>
        <header id="main-header">
            <div class="container">
                <h1>FARMBOOK</h1>
            </div>
        </header>

        <nav id="navbar">
            <div class="container">
                <ul class="page-links">
                    <li>
                        <a class="github-link" href="https://github.com/TexelBox/farmbook" target="_blank">
                            <i class="fab fa-github"> GitHub</i>
                        </a>
                    </li>
                    <?php if(isset($navbarLink1) && isset($navbarLink1Title)) echo "<li><a href=$navbarLink1>$navbarLink1Title</a></li>" ?>
					<?php if(isset($navbarLink2) && isset($navbarLink2Title)) echo "<li><a href=$navbarLink2>$navbarLink2Title</a></li>" ?>
					<?php if(isset($navbarLink3) && isset($navbarLink3Title)) echo "<li><a href=$navbarLink3>$navbarLink3Title</a></li>" ?>
                </ul>   
            </div>
        </nav>
<!-- END HEADER -->