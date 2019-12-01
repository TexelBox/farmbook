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

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    </head>
    <body>
        <header id="main-header">
            <div class="container">
                <h1>HEADER</h1>
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
                </ul>   
            </div>
        </nav>
<!-- END HEADER -->