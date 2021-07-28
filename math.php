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
  $GLOBALS['question_type'] = ['Addition','Subtraction','Multiplication or Division'];

  //redirect to quiz page if true
  $overallScore = 0; // <- load the total score here
  $quizType = 'Math'; // <- specify quiz type here
  if($_GET['quit'] == 'TRUE') {
      $name = $_SESSION["login"];
      header("Location: quizoutcome.php?name=$name&overallScore=$overallScore&quizType=$quizType");
  }

?>

<!-- set question here -->
<?php
  //1.set questions here
  $questions = [
    //first section
    [
      ["10 + 10",20], 
      ["20 + 20",40],
      ["30 + 30",60],
      ["40 + 40",80],
    ],
    //second section
    [
      ["10 - 10",0], 
      ["20 - 10",10],
      ["30 - 10",20],
      ["40 - 10",30],
    ],
    //third section
    [
      ["10 * 10",100], 
      ["20 * 10",200],
      ["30 / 10",3],
      ["40 / 10",4],
    ]
  ];

  //shuffle array
  shuffle($questions[0]);
  shuffle($questions[1]);
  shuffle($questions[2]);
  //assign back into variable
  $GLOBALS['questions'] = $questions;
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
              </form>
           </section>

           <!-- questions to student -->
           <section id='studentqn-section' style='margin-top:2.5em;margin-bottom:2.5em;'>
              <span class='lg-text' style='padding-left: 2.4em;'><b>Question Type:</b> <span><?php echo $GLOBALS['question_type'][intval($GLOBALS['current_section']) - 1] ?></span></span>
              <?php 
              function renderQuestions($my_list_of_questions) {
                 $mylist = $my_list_of_questions;
                 $output = '';
                 $counter = 1;
                 foreach ($mylist as $value) {
                    $questionNo = $counter;
                    $questionHere = $value[0];
                    $answerHere = $value[1];
                    $test = $_POST["qn-$questionNo"];
                    $output .= 
                    "
                    <tr class='ei-table-row'>
                      <td style='width:3%;'>
                        <span style='font-size:20px;'>$questionNo.</span>
                      </td>
                      <td>
                        <span style='font-size:20px;'>$questionHere</span>
                      </td>
                      <td style='width: 7%;'>
                        <!-- <form action='#quizsection-section' method='post' > -->
                        <input style='margin-left: 1em;width: 170px;' type='number' name='qn-$questionNo' placeholder='answer for question $questionNo...'>
                        <!-- </form> -->
                      </td>
                      <td style='width:3%;'>
                        <span>CORRECT / INCORRECT</span>
                        <span>$test</span>
                      </td>
                    </tr>
                    
                   
                    <br><br>
                    ";

                    //increment counter
                    $counter += 1;
                 }
                 return $output;
              }

              //init variables here
              $currentSection = intval($GLOBALS['current_section']);
              $currentSection -= 1;
              $my_list_of_questions = $GLOBALS['questions'][$currentSection];
              $tableRows = renderQuestions($my_list_of_questions);

              echo
              "
              <div style='margin-left:4em;margin-top:-6em;margin-right: 5em;'>

               <table class='ei-table'>

                 <tr>
                  <th>No</th>
                  <th>Question</th>
                  <th>Answer</th>
                  <th>Result</th>  
                 </tr>

                 <!-- table rows rendered here -->
                 $tableRows
                 <!-- table rows rendered here -->
               </table>

              </div>
              ";
              ?>
           </section>

           <!-- score section -->
           <section id='score-section' style='padding-left: 3.5em;padding-bottom: 1em;'>
              <span>Current Section Score:&nbsp&nbsp</span><span class='primarycolor'><b></b></span>
              <span>&nbsp&nbsp</span>
              <span>Overall Score:&nbsp&nbsp</span><span class='primarycolor'><b><?php echo $GLOBALS['overallScore'] ?></b></span>
              <span>&nbsp&nbsp</span>
              <span>Correct Answer:&nbsp&nbsp</span><span class='primarycolor'><b>0</b></span>
              <span>&nbsp&nbsp</span>
              <span>Incorrect Answer:&nbsp&nbsp</span><span class='primarycolor'><b>0</b></span>
              <span>&nbsp&nbsp</span>
           </section>

           <!-- navigation section -->
           <section id='navigation-section'>
              <form name='navigation-section' method='get' action='#quizsection-section'>
                <span class='lg-text' style='padding-left: 2.4em;'><b>Navigation:</b></span>
                <button 
                <?php echo ($GLOBALS['current_section'] == '1') ? 'disabled="true" style="background-color: lightgrey;pointer-events: none;color: grey;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value=<?php echo ($GLOBALS['current_section'] > '1') ? intval($GLOBALS['current_section']) - 1  : '1' ?>>Back</button>
                <button
                <?php echo ($GLOBALS['current_section'] == '3') ? 'disabled="true" style="background-color: lightgrey;pointer-events: none;color: grey;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value=<?php echo ($GLOBALS['current_section'] < '3') ? intval($GLOBALS['current_section']) + 1  : '3' ?>>Next</button>
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