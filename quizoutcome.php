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


          <section id='login-section'>
            <h3 class="centerText primarycolor">You can choose to logout here to change to a different user.</h3>

            <div class="container">
              <form 
              method='post'
              name='login-name'
              class="bikesearch boxsizing"
              action="#quizselection-section" 
              style="margin:auto;max-width:600px;margin-bottom: 2em;padding-left: 4em;padding-right: 2em;">
                <?php
                $login = $_SESSION["login"];
                $disabled = empty($_SESSION['login']) ? '' : 'disabled="true"';
                $bikesearchQuery =
                "<input class='boxsizing' type='text' placeholder='enter your name...' name='login' value='$login' $disabled >";
                echo $bikesearchQuery;
                ?>
                <button name='quiz-logout' class="boxsizing lightbluecolor" type="submit" value='logout'
                <?php echo empty($_SESSION['login']) ? 'disabled="true" style="background-color: #C0C0C0;pointer-events: none;"' : ''; ?>
                >logout</button>
                <button name='quiz-login' class="boxsizing" type="submit" value='submit'
                <?php echo empty($_SESSION['login']) ? '' : 'disabled="true" style="background-color: #C0C0C0;pointer-events: none;"'; ?>
                >login</button>
                <p class='required-text' style='padding-top: 1em;padding-right: 9em;'>
                  <?php
                    //for detecting empty value (search button clicked but query is empty)
                    if (isset($_POST['quiz-login']) && empty($_POST['login'])) {
                        $_SESSION["login"] = '';
                        session_unset();
                        echo '*login cannot be blank'; 
                    }
                    elseif(isset($_POST['quiz-login']) && !empty($_POST['login'])) {
                        $validateLogin = $_POST['login'];
                        $loginStatus = true;

                        //if login status is successful
                        if($loginStatus) { 
                           $_SESSION["login"] = $validateLogin;
                           //refresh UI to update session
                           header("Refresh: 0.1");
                        }
                        else {
                           $_SESSION["login"] = '';
                           session_unset();
                           echo '*name does not exist or not in system';
                        }
                    }
                    elseif(isset($_POST['quiz-logout'])) {
                        unset($_SESSION['overallScore']); // unset overall score
                        session_destroy();
                        header("Location: quizoutcome.php");
                    }
                  ?>
                </p>
              </form>
              <!-- login using name -->
            </section>


        <div id="content">

           <section id='userinfo-section' style="<?php echo(empty($_GET['name']) ? 'display: none;' : '') ?>">
            <div style='margin-bottom: 5em;'>
              <h2 class="centerText primarycolor">
                <span>Good job </span><span style='color: darkblue;'><?php echo strtoupper($_GET['name']) ?></span><span> on attempting the questions</span>
              </h2>
              <h2 class="centerText">
                <span>Your overall quiz score is: </span><span class="primarycolor"><?php echo strtoupper($_GET['overallScore']) ?></span>
              </h2>
            </div>
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