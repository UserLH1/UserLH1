<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="Content-type" value="text/html; charset=UTF-8" />
    
    <title>Înregistrare</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('db.php');
    header('Content-type: text/html; charset=UTF-8');

    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $phone    = stripslashes($_REQUEST['phone']);
        $phone    = mysqli_real_escape_string($con, $phone);
        $context  = stripslashes($_REQUEST['academic_context']);
        $context  = mysqli_real_escape_string($con, $context);

        // Check if email already exists in the database
        $emailExistsQuery = "SELECT * FROM `users` WHERE email='$email'";
        $emailExistsResult = mysqli_query($con, $emailExistsQuery);
        $emailExists = mysqli_num_rows($emailExistsResult);

        if ($emailExists) {
            echo "<div class='form'>
                  <h3>Există deja o înregistrare cu această adresă de email.</h3><br/>
                  <a href='registration.php'>Click aici pentru a încerca din nou.</a>
                  </div>";
        }
        else {
            $query = "INSERT INTO `users` (username, password, email, academic_context, phone)
                      VALUES ('$username', '" . md5($password) . "', '$email', '$context', '$phone')";
            $result = mysqli_query($con, $query);
            
            if ($result) {
                echo "<div class='form'>
                      <h3>You are registered successfully.</h3><br/>
                     
                      </div>";
            } else {
                echo "<div class='form'>
                      <h3>Required fields are missing.</h3><br/>
                      <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                      </div>";
            }
        }
    } else {
?>
<style>
    select.login-input {
        height: 40px; /* Adjust the height as needed */
    }
</style>
    <form class="form" action="" method="post">
    <h1 class="login-title">Înregistrare</h1>
    <input type="text" class="login-input" name="username" placeholder="Nume și Prenume" required />
    <input type="email" class="login-input" name="email" placeholder="Adresa de e-mail" required>
    <input type="number" class="login-input" name="phone" placeholder="Telefon" required>
    <input type="password" class="login-input" name="password" placeholder="Parola" required>
    <select name="academic_context" class="login-input">
        <option value="licenta" selected>Licenta</option>
        <option value="masterat">Masterat</option>
    </select>
    <label>
        <input type="checkbox" name="terms" required> Accept termenii și condițiile
    </label>
    <input type="submit" name="submit" value="Înregistrare" class="login-button">
    <p class="link"><a href="login.php">Click aici pentru conectare</a></p>
</form>

<?php
    }
?>
</body>
</html>