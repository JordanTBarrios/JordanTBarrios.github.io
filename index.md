<?php
session_start();
if (!isset($_SESSION["username"])){
    header("Location: login.php");
    die;
} else {
if (isset($_POST["zipcode"])){
  if($_POST["fav"] == "yes"){
      $mysqli = new mysqli("localhost", "jbarrios2017", "4fechtyQXx", "jbarrios2017");
      $_SESSION["fav_zip"] = $_POST["zipcode"];
      $newZip = $_SESSION["fav_zip"];
      $username = $_SESSION["username"];
      $zipSQL = "UPDATE accounts SET fav_zip = $newZip WHERE accounts.username = '$username'";
      if (!$mysqli->query($zipSQL)) {
        die("Error ($mysqli->errno) $mysqli->error<br>SQL = $zipSQL\n");
      }
  }
}
}
?>

<!DOCTYPE html>
<html lang="en">
  <title>Weather API</title>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="stylesheet" href="weatherstyle.css">
  </head>
  <body class="container shadow">
    <main>
<?php
      if ($_SERVER["REQUEST_METHOD"] == "GET"){
          echo "<div>
                  <h1>Weather based on zipcode</h2>
                </div>";
      } else {
          $zip = $_POST["zipcode"];
          echo "<div>
                  <h1>Weather for $zip</h2>
                </div>";
      }
?>
    <div class="row">
      <div class="offset-4">
        <form method="post" action="index.php">
            
          <div class="row">
            <label for="zipcodeBox">Type Zip Code</label>
            <input type="text" name="zipcode" maxlength="5" autofocus id="zipcodeBox" class="form-control" placeholder="Zip Code" list="default-zips">
            <datalist id="default-zips">
              <option value="90210">Beverly Hills</option>
              <option value="33065">Pompano Beach</option>
              <option value="33101">Miami</option>
              <option value="33431">Boca Raton</option>
              <option value="10001">New York</option>
            </datalist>
          </div>
            
          <div class="row">
            <div class="col-sm-8">
              <span>Favorite?
                  <label class="radio-inline">
                    <input type="radio" name="fav" value="yes">Yes
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="fav" value="no" checked>No
                  </label>
              </span>
            </div>  
            <div class="col-sm-4">
              <input type="submit" value="Submit" class="btn btn-primary">
            </div>
          </div>
            
        </form>
        <a href="/~jbarrios2017/p7/login.php" class="btn btn-link">Back to Login</a>
      </div>
    </div>
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather";
        $queryString = "zip=$zip&units=imperial&appid=4c608881bab7a0f22b82e79721f0011b";

        // Make HTTP request and wait for the response
        $response = file_get_contents("$apiUrl?$queryString");
 
        if ($response === FALSE) {
           die("Error contacting the web API");
        } else {
         // Convert JSON response into PHP object
          $style = "class=\"info\"";
          $obj = json_decode($response);

          $name = $obj->name;
          $currentTemp = $obj->main->temp;
          $description = $obj->weather[0]->description;
          $humidity = $obj->main->humidity;
          $pressure = $obj->main->pressure;
          $wind = $obj->wind->speed;
          echo "<p>$name</p>";
          echo "<p $style>Current temp: $currentTemp &deg;F</p>";
          echo "<p $style>Description: $description</p>";
          echo "<p $style>Humidity: $humidity%</p>";
          echo "<p $style>Pressure: $pressure</p>";
          echo "<p $style>Wind Speed: $wind mph</p>";
        }
     }
      
    ?>
    </main>
  </body>
</html>