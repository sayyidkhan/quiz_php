<?php
  define('CSS_PATH', 'css/'); //define bootstrap css path
  define('IMG_PATH','./img/'); //define img path
  $main_css = 'main.css'; // main css filename
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Takoko - Bike Shop</title>
    <!-- main CSS-->
    <link rel="stylesheet" href='<?php echo (CSS_PATH . "$main_css"); ?>' type="text/css">

  </head>
  <body>

      <div id="wrapper">

        <div id="header">
          <h1>Takoko</h1>
          <div id="nav">
            <ul>
              <li><a href="index.php">Home</a></li>
              <li><a href="addbikelisting.php">Add Listing</a></li>
              <li><a href="managelisting.php">Manage Listing</a></li>
              <li><a href="bikelisting.php">View Listing's</a></li>
            </ul>
          </div>
        </div>

        <div id="content">

           <div>
            <h3 class="centerText primarycolor">ONLINE MARKETPLACE TO BUY & SELL BIKES</h3>

            <div class="container">
              <img 
              src="<?php echo (IMG_PATH . 'mainpage-bicycle.jpg') ?>"
              alt="online bike marketplace"
              width="500"
              height="400"
              loading="lazy">
            </div>

            <h2 class="centerText">Welcome to Takoko ! Your one stop shop for all your bike needs.</h2>

            <div style="text-align:center; padding-bottom: 2em;">
              <a href="bikelisting.php"><button class="bgprimarycolor" style="height: 5em; width: 20em;">Visit Listing Today!</button></a>
            </div>
          </div>

        </div>

        <div id="footer">
          <p>
            &copy;
            <?php 
            $currentYear = date('Y'); 
            echo $currentYear; 
            ?>
            All rights reserved.
          </p>
        </div>

    </div>


  </body>
</html>