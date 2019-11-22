<?php
    $pageTitle = "HOME";
    require_once("header.php");
?>

<section id="showcase">
    <div class="container">
        <h1>[WIP]</h1>
    </div>
</section>

<div class="container">
    <section id="main">
        <h1>Welcome</h1>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint natus libero inventore, ullam aliquid nihil perspiciatis rerum voluptates? Magni, reprehenderit, asperiores quos sit sint voluptatibus porro beatae quis maiores, magnam esse corporis ullam quidem fugit sapiente cumque iste perspiciatis veritatis saepe amet ab ratione placeat explicabo. Assumenda voluptates consequuntur quia aperiam excepturi odit architecto iusto magnam voluptatem repellat amet quibusdam eligendi eaque quae molestias facere temporibus sunt distinctio in reiciendis deleniti, asperiores minus? Quae quas officiis quibusdam, debitis hic nisi in iste ad eligendi quam optio animi libero molestias accusantium minima facere sint dignissimos aspernatur ea veniam ratione, deleniti rerum.</p>
    </section>
    <aside id="sidebar">
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus, repellat? Velit explicabo voluptatum cum earum totam laborum maiores illum veritatis facilis dolor delectus, quam, harum dignissimos voluptatibus nostrum amet assumenda. Voluptatem minima consectetur exercitationem distinctio quas excepturi nostrum, esse, delectus sint earum nesciunt debitis molestias mollitia, quam fuga dignissimos modi alias libero obcaecati. Perspiciatis ducimus, exercitationem delectus aliquid harum, quae suscipit enim nisi vitae explicabo magnam quas, beatae molestias. Vitae eius ullam officia! Reprehenderit rerum impedit, placeat, provident voluptatum quibusdam id pariatur quasi optio ea illo tenetur qui, soluta repellat velit eveniet nemo consequatur quis vel rem doloremque earum inventore?</p>
    </aside>
</div>

<form action="add.php" method="post">
    Name: <input type="text" name="name"><br>
    E-mail: <input type="text" name="email"><br>
    <input type="submit" value="add">
</form>

<?php
    require_once("footer.php");
?>