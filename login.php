<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        // Verify the reCAPTCHA response
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => '6LfQ_xAmAAAAAMtbzchg2HwMdAykWdVPidgVzYK0', // Replace with your actual reCAPTCHA secret key
            'response' => $recaptchaResponse
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captchaSuccess = json_decode($verify)->success;

        // Proceed with login only if CAPTCHA verification is successful
        if ($captchaSuccess) {
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($con, $username);
            $password = stripslashes($_REQUEST['password']);
            $password = mysqli_real_escape_string($con, $password);
            // Check user exists in the database
            $query = "SELECT * FROM `users` WHERE username='$username'
                      AND password='" . md5($password) . "'";
            $result = mysqli_query($con, $query) or die(mysqli_connect_error());
            $rows = mysqli_num_rows($result);
            if ($rows == 1) {
                $_SESSION['username'] = $username;
                // Redirect to user dashboard page
                header("Location: dashboard.php");
            } else {
                echo "<div class='form'>
                      <h3>Incorrect Username/password.</h3><br/>
                      <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                      </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>CAPTCHA verification failed.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
   <form class="form" method="post" name="login">
    <h1 class="login-title">Conectare</h1>
    <input type="text" class="login-input" name="username" placeholder="Nume și Prenume" autofocus="true"/>
    <input type="password" class="login-input" name="password" placeholder="Parola"/>
    <div class="g-recaptcha" data-sitekey="6LfQ_xAmAAAAAC5JDOGi4X4RUnS8UsJab8dWnG0S"></div> 

    <input type="submit" value="Login" name="submit" class="login-button"/>
    <p class="link"><a href="registration.php">Inregistrare noua</a></p>
</form>

<?php
    }
?>
</body>
</html>