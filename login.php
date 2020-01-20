<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    session_start();
    
    $mysqli = new mysqli("localhost", "jbarrios2017", "4fechtyQXx", "jbarrios2017");
    if ($mysqli->connect_errno) {
      die("Failed to connect to MySQL: ($mysqli->connect_errno) $mysqli->connect_error");
    }
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $aSQL = "SELECT * FROM accounts WHERE username='" . $mysqli->real_escape_string($username) . "'";
    $result = $mysqli->query($aSQL);
    
    
    if (!$result) {
      die("Error executing query: ($mysqli->errno) $mysqli->error");
   }
   else {
      $row = $result->fetch_assoc();

      // See if submitted password matches the hash stored in the Users table 
      echo $row["password"];
      echo $password;
      if (password_verify($password, $row["password"])){
          echo "ITS TRUE";
      } else {
          echo "ITS FALSE";
      }
      if (password_verify($password, $row["password"])) {
         $_SESSION["username"] = $username;
         header("Location: index.php");
         die;
      } 
      else {
         echo "<p>Incorrect username or password.</p>";
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="stylesheet" href="weatherstyle.css">
    </head>
    <main class="container">
      <div class="row">
        <div class="offset-4">
          <h1>Login</h1>
        </div>
      </div>
      <form method="post" action="login.php">
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
          <div class="offset-4">
            <input type="submit" value="Login" class="btn btn-primary">
          </div>
        </div>
      </form>
      <div class="row">
        <div class="offset-4">
          <a href="signup.php">No account? Sign up</a>
        </div>
      </div>
    </main>
</html>