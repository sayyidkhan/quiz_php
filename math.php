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

  //question type - set the title of the question type here
  $GLOBALS['question_type'] = ['Addition','Subtraction','Division','Multiplication'];

  //redirect to quiz page if true
  $overallScore = 0; // <- load the total score here
  $quizType = 'Math'; // <- specify quiz type here
  if($_GET['quit'] == 'TRUE') {
      $name = $_SESSION["login"];
      header("Location: quizoutcome.php?name=$name&overallScore=$overallScore&quizType=$quizType");
  }

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

           <!-- quiz selection section -->
           <section id='quizsection-section'>
              <form name='quizsection-section' method='get' action='#quizsection-section'>
                <span class='lg-text' style='padding-left: 2.4em;'><b>Section:</b></span>
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
              </form>
           </section>

           <!-- questions to student -->
           <section id='studentqn-section' style='margin-top:2.5em;margin-bottom:2.5em;'>
              <span class='lg-text' style='padding-left: 2.4em;'><b>Question Type:</b> <span><?php echo $GLOBALS['question_type'][intval($GLOBALS['current_section']) - 1] ?></span></span>
           </section>

           <!-- navigation section -->
           <section id='navigation-section'>
              <form name='navigation-section' method='get' action='#quizsection-section'>
                <span class='lg-text' style='padding-left: 2.4em;'><b>Navigation:</b></span>
                <button 
                <?php echo ($GLOBALS['current_section'] == '1') ? 'disabled="true" style="background-color: lightgrey;pointer-events: none;color: grey;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value=<?php echo ($GLOBALS['current_section'] > '1') ? intval($GLOBALS['current_section']) - 1  : '1' ?>>Back</button>
                <button
                <?php echo ($GLOBALS['current_section'] == '4') ? 'disabled="true" style="background-color: lightgrey;pointer-events: none;color: grey;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value=<?php echo ($GLOBALS['current_section'] < '4') ? intval($GLOBALS['current_section']) + 1  : '4' ?>>Next</button>
                <button
                type='submit' class='section-btn' name='current_section' value='3'>Submit</button>
                <button
                type='submit' class='section-btn' name='quit' value='TRUE'>Exit</button>
              </form>
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