<?php
  session_start();

  define('CSS_PATH', 'css/'); //define bootstrap css path
  define('IMG_PATH','./img/'); //define img path
  $main_css = 'main.css'; // main css filename
  $flex_css = 'flex.css'; // flex css filename
  $tableui_css = 'tableui.css'; // flex css filename
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Takoko Quiz- Score It</title>
    <!-- main CSS-->
    <link rel="stylesheet" href='<?php echo (CSS_PATH . "$main_css"); ?>' type="text/css">
    <link rel="stylesheet" href='<?php echo (CSS_PATH . "$flex_css"); ?>' type="text/css">
    <link rel="stylesheet" href='<?php echo (CSS_PATH . "$tableui_css"); ?>' type="text/css">

  </head>
  <body>

      <div id="wrapper">

        <div id="header">
          <h1>Takoko Quiz</h1>
          <div id="nav">
            <ul>
              <li style='padding-right: 3em;'><a href="index.php">Back to Homepage</a></li>
            </ul>
          </div>
        </div>

        <div id="content">

           <section id='userinfo-section' style='margin-bottom: 5em;'>
            <h2 class="centerText primarycolor">
              <span>Good job </span><span style='color: darkblue;'><?php echo strtoupper($_GET['name']) ?></span><span> on attempting the questions</span>
            </h2>
            <h3 class="centerText">
              <span>Quiz Type: </span><span class="primarycolor"><?php echo strtoupper($_GET['quizType']) ?></span>
            </h3>
            <h2 class="centerText">
              <span>Your overall quiz score is: </span><span class="primarycolor"><?php echo strtoupper($_GET['overallScore']) ?></span>
            </h2>
           </section>

           <section id='logout-section'>

           </section>

            <section id="quizselection-section" style="<?php echo(empty($_SESSION['login']) ? 'display: none;' : '') ?>">
              <h2 class="centerText">
                Would you like to take the quiz again or try out other quiz ?
              </h2>

              <div style="padding-bottom: 2em;text-align: center;">

                  <a href='math.php'>
                    <button
                      name="submit"
                      style="height: 5em;width: 20em;display: inline-block;"
                      class="bgprimarycolor"
                      type="submit"
                      value="Save"
                    >
                      Math
                    </button>
                  </a>

                  <a href='literature.php'>
                    <button 
                     name="submit"
                     style="height: 5em;width: 20em;display: inline-block;"
                     class="bgprimarycolor"
                     type="submit"
                     value="Cancel" 
                     >
                      Literature
                     </button>
                  </a>

                  <p id="saved"></p>

               </div>
             </section>

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