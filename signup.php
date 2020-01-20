<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $zip = $_POST["zip"];
    
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
    $mysqli = new mysqli("localhost", "jbarrios2017", "4fechtyQXx", "jbarrios2017");
    if ($mysqli->connect_errno) {
      die("Failed to connect to MySQL: ($mysqli->connect_errno) $mysqli->connect_error");
    }
    
    $aSQL = "INSERT INTO accounts VALUES('" . $mysqli->real_escape_string($username) . "', '$passwordHash', '$zip')";
    if (!$mysqli->query($aSQL)) {
      die("Error ($mysqli->errno) $mysqli->error<br>SQL = $aSQL\n");
    }
        $_SESSION["username"] = $username;

        // Should output 1
        echo "<p class='lead'>Inserted $mysqli->affected_rows row.</p>";
        echo "<p class='lead'>Successfully created new account.</p>";
        echo "<input type='button' value='Continue to Login' id='aContinue' class='btn btn-success'>";
}
?>
<!DOCTYPE html>    <!-- login.php -->
<html>
  <title>Sign Up</title>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="stylesheet" href="weatherstyle.css">
  </head>
  <main class="container">
    <div class="row">
      <div class="offset-4">
        <h1>Create Account</h1>
      </div>
    </div>
    <form method="post" action="signup.php">
      <div class="row">
            <div class="form-group offset-4">
              <input type="text" name="username" placeholder="Username" id="username" autofocus class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="form-group offset-4">
              <input type="password" name="password" placeholder="Password" id="password" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="form-group offset-4">
              <input type="text" name="zip" placeholder="Zip code" id="zip" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="offset-4">
              <input type="submit" value="Create" class="btn btn-primary">
            </div>
          </div>
    </form>
  </main>
    <script src="signup.js"></script>
</html>