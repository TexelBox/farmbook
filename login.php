<?php
    $pageTitle = "LOGIN";
    $navbarLink1 = "index.php";
    $navbarLink1Title = "HOME";
    $navbarLink2 = "auth.php";
    $navbarLink2Title = "LOG-IN/OUT";
	$navbarLink3 = "portal.php";
    $navbarLink3Title = "PORTAL";
    require_once("header.php");
    require_once("database.php");

    // if user is logged in...
    if (isset($_SESSION["logged_in"])) header("Location: logout.php");

    // check if form was submitted...
    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        //TODO: validation / error handling...
        if (!empty($username) && !empty($password)) {
            if (ctype_alnum($username) && strlen($username) <= 15) {
                $db = new Database();
                $result = $db->preparedQuery("SELECT * FROM USER WHERE username = ?", "s", array($username));
                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    $fetched_user_id = $row["user_id"];
                    $fetched_username = $row["username"];
                    $fetched_password_hash = $row["password_hash"];
                    if (password_verify($password, $fetched_password_hash)) {
                        //echo "TODO: goto member page based on user role. Will need to change query to also get user id and then join with roles table and get roles, etc.";
                        // set session variables...
                        $_SESSION["logged_in"] = true;
                        $_SESSION["user_id"] = $fetched_user_id;
                        $_SESSION["username"] = $fetched_username;
                        
                        // query user roles and set all session vars...
                        $result_roles = $db->query("SELECT ROLE.name FROM USER_ROLES, ROLE WHERE (USER_ROLES.user_id = ${fetched_user_id}) AND (USER_ROLES.role_id = ROLE.role_id)");
                        while ($result_roles_row = $result_roles->fetch_assoc()) {
                            $role_name = $result_roles_row["name"];
                            $_SESSION[$role_name] = true;
                        }

                        // redirect to portal...
                        header("Location: portal.php");
                    } else {
                        echo "WRONG PASSWORD! Please try again.";
                    }
                } else {
                    echo "INVALID CREDENTIALS! Please try again.";
                }
            }
        }
    }
?>

<div class="container">
    <!-- styling reference: https://getbootstrap.com/docs/4.0/components/forms/ -->
    <form action="" method="post">
    <div class="form-group">
        <label for="inputUsername">USERNAME</label>
        <input class="form-control" id="inputUsername" aria-describedby="usernameHelp" type="text" name="username" placeholder="Username">
        <small class="form-text text-muted" id="usernameHelp">Username must be alpha-numeric (1-15 chars).</small> 
    </div>
    <div class="form-group">
        <label for="inputPassword">PASSWORD</label>
        <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password">
    </div>
    <button class="btn btn-primary" type="submit" name=submit>SUBMIT</button>
    </form>
</div>

<?php
    require_once("footer.php");
?>