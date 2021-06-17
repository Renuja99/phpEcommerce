<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="loginbox">
        <img src="login_avatar.png" class="avatar">
        <h1>Login Here</h1>
        <form action="" method="post">
            <p>Username</p>
            <input type="text" name="username" placeholder="Enter Username">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" value="Submit">

        </form>
        <?php if (!empty($errors)) {

            foreach ($errors as $error) {

                echo $error . '<br>';
            }
        } ?>

    </div>
</body>

</html>