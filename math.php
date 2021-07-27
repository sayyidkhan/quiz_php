<?php
  session_start();

  define('CSS_PATH', 'css/'); //define bootstrap css path
  define('IMG_PATH','./img/'); //define img path
  $main_css = 'main.css'; // main css filename
  $flex_css = 'flex.css'; // flex css filename
  $tableui_css = 'tableui.css'; // flex css filename

  define('CURRENT_FILENAME', 'math.php'); //filename of this file
?>

<!-- manage global variables -->
<?php
  function checkCurrentSection() {
      //if current page is not set, update current_section to 1 for page init
      if(!isset($_GET['current_section'])) {
          header("Location: " . CURRENT_FILENAME . '?current_section=1');
      }
      else {
          //set the current session into the global variable
          $GLOBALS['current_section'] = $_GET['current_section'];
      }

  }

  //set the current section
  checkCurrentSection();
  $current_section = $GLOBALS['current_section'];


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
        </div>

        <div id="content">

           <section id='login-section'>
            <h2 class="primarycolor" style='padding-left: 2em;'>Welcome to Math Quiz.</h2> 
           </section>


           <section id='quizsection-section'>
              <form name='quizsection-section' method='get' action='#quizsection-section'>
                <span class='lg-text' style='padding-left: 2.4em;'><b>section:</b></span>
                <button 
                <?php echo ($GLOBALS['current_section'] == '1') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: white;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value='1'>1</button>
                <button
                <?php echo ($GLOBALS['current_section'] == '2') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: white;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value='2'>2</button>
                <button
                <?php echo ($GLOBALS['current_section'] == '3') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: white;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value='3'>3</button>
                <button
                <?php echo ($GLOBALS['current_section'] == '4') ? 'disabled="true" style="background-color: lightblue;pointer-events: none;color: white;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value='4'>4</button>
                <p><?php echo $GLOBALS['current_section']; ?> </p>
              </form>
           </section>

           <section id="quizselection-section" style="<?php echo(empty($_SESSION['login']) ? 'display: none;' : '') ?>">
              <h2 class="centerText">
                Select the quiz you would like to take:
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