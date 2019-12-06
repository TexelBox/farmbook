<?php
    $pageTitle = "HOME";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL"; 
    require_once("header.php");
    require_once("database.php");

    // EXAMPLE USAGE...
    //$db = new Database();
    //$result = $db->query("SELECT * FROM FARM");
    //$nbRows = $result->num_rows;
    //echo("TEST --- NUMBER OF ROWS: " . $nbRows);
?>

<section id="showcase">
    <div class="container">
        <img src="assets/images/home-wheat.jpg" alt="picture of wheat" height="512" />
    </div>
</section>

<div class="container">
    <section id="main">
        <h1>Welcome</h1>
        <p>Agricultural plights have existed as long as agriculture has. Subsequently, measures like pesticides and improved farming practices have been progressively advancing with science and technology. Creating a database and an accompanying program for a large scale of farms is our solution for consolidating data for farmers, researchers, suppliers, and insurers to work together to ensure food safety.</p>
    </section>
    <aside id="sidebar">
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus, repellat? Velit explicabo voluptatum cum earum totam laborum maiores illum veritatis facilis dolor delectus, quam, harum dignissimos voluptatibus nostrum amet assumenda. Voluptatem minima consectetur exercitationem distinctio quas excepturi nostrum, esse, delectus sint earum nesciunt debitis molestias mollitia, quam fuga dignissimos modi alias libero obcaecati. Perspiciatis ducimus, exercitationem delectus aliquid harum, quae suscipit enim nisi vitae explicabo magnam quas, beatae molestias. Vitae eius ullam officia! Reprehenderit rerum impedit, placeat, provident voluptatum quibusdam id pariatur quasi optio ea illo tenetur qui, soluta repellat velit eveniet nemo consequatur quis vel rem doloremque earum inventore?</p>
    </aside>
</div>

<!--form action="add.php" method="post">
    Name: <input type="text" name="name"><br>
    E-mail: <input type="text" name="email"><br>
    <input type="submit" value="add">
</form-->

<?php
    require_once("footer.php");
?>