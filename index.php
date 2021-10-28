<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./images/favicon.png">
    <title>Ida Gundhammar CV</title>
</head>
<body>
<section class="content">
    <div class="heading"><h1>Logga in</h1></div>
    <div class="maincontent">
        <form method="post" action="index.php">
            <input type="text" name="username" id="username" placeholder="Användarnamn"><br>
            <input type="password" name="password" id="password" placeholder="Lösenord"><br>
            <input type="submit" name="login" value="Logga in">
        </form>
		<?php
        include_once 'classes/User.php';
        $user = new User();
		// Checks if login-button is clicked, runs logInUser method.
		if (isset ($_POST['login'])) {
			$user->logInUser();
		}
		?>
    </div>
</section>
</body>
</html>