<?php
  session_start();

  define('CSS_PATH', 'css/'); //define bootstrap css path
  define('IMG_PATH','./img/'); //define img path
  $main_css = 'main.css'; // main css filename
  $flex_css = 'flex.css'; // flex css filename
  $tableui_css = 'tableui.css'; // flex css filename

  //define this current filename and quiz type
  define('CURRENT_FILENAME', 'literature.php'); //filename of this file
  define('QUIZ_TYPE','Literature'); //define quiz type

  //define alternate filename and quiz type
  define('ALT_CURRENT_FILENAME', 'math.php'); //filename of this file
  define('ALT_QUIZ_TYPE','Math');
?>

<!-- manage global variables -->
<?php

  //set the wrong and correct answer global variable
  $GLOBALS['correct_answer'] = 0;
  $GLOBALS['wrong_answer'] = 0;
  $GLOBALS['current_section_score'] = 0;
  
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
  $GLOBALS['question_type'] = ['Book (1)','Book (2)','Multiplication or Division'];

  //init overall score
  if(!isset($_SESSION['overallScore'])) {
     $_SESSION['overallScore'] = 0;
  } 
  else {
     //accumulate score here
     $_SESSION['overallScore'];
  }

  //reset overall score if reset button is click
  if(isset($_POST['reset'])) {
    $_SESSION['overallScore'] = 0;
  }

  //redirect to quiz page if true
  $quizType = QUIZ_TYPE; // <- specify quiz type here
  if($_GET['quit'] == 'TRUE') {
      $name = $_SESSION["login"];
      $overallScore = $_SESSION['overallScore'];
      header("Location: quizoutcome.php?name=$name&overallScore=$overallScore&quizType=$quizType");
  }

?>

<!-- set question here -->
<?php
  //1.set questions here
  $questions = [
    //first section
    [
      ["id-1","10 + 10",20], 
      ["id-2","20 + 20",40],
      ["id-3","30 + 30",60],
      ["id-4","40 + 40",80],
    ],
    //second section
    [
      ["id-5","10 - 10",0], 
      ["id-6","20 - 10",10],
      ["id-7","30 - 10",20],
      ["id-8","40 - 10",30],
    ],
    //third section
    [
      ["id-9","10 * 10",100], 
      ["id-10","20 * 10",200],
      ["id-11","30 / 10",3],
      ["id-12","40 / 10",4],
    ]
  ];

  //shuffle array
  shuffle($questions[0]);
  shuffle($questions[1]);
  shuffle($questions[2]);
  //assign back into variable
  $GLOBALS['questions'] = $questions;

  //2. extract the question id from questions_array
  // also map all post id as a value in this associative array where the key is the id of the question
  function getQuestionId($myArray) {
    $result = array();
    foreach ($myArray as $section) {
      foreach($section as $rows) {
        $myId = $rows[0];
        $value = $_POST[strval($myId)];
        $result[$myId] = $value;
      }
    }
    return $result;
  }
  $questionsID = getQuestionId($questions);
  $GLOBALS['questions_id'] = $questionsID;

  //see the stored value of POST request upon submission
  //echo print_r($questionsID);
?>


<!-- logic for sum -->
<?php


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
            <h2 class="primarycolor" style='padding-left: 2em;'>Welcome to <?php echo QUIZ_TYPE; ?> Quiz.</h2> 
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
                 function getValueFromPOST($id) {
                    $my_qn_id_list = $GLOBALS['questions_id'];
                    $my_value = $my_qn_id_list[$id];
                    if(empty($my_value)) {
                        return '-';
                    }
                    else {
                        return $my_value;
                    }
                 }
                 function displayCorrectOrWrong($user_response,$answer) {
                    //no input return -
                    if($user_response == '-') {
                        return '-';
                    }
                    //else display input
                    else {
                        //if correct display correct, else display wrong
                        if(strval($user_response) == strval($answer)) {
                           $GLOBALS['correct_answer'] += 1; // correct answer increment by 1
                           $GLOBALS['current_section_score'] += 5; // correct answer +5
                           return "CORRECT";
                        }
                        else {
                           $GLOBALS['wrong_answer'] += 1; // wrong answer increment by 1
                           $GLOBALS['current_section_score'] -= 3; // wrong answer -3
                           return "WRONG";
                        }
                    }
                 }
                 function computeMarks($user_response,$answer) {
                    //no input return 0
                    if($user_response == '-') {
                        return 0;
                    }
                    //else display input
                    else {
                        //if correct display correct, else display wrong
                        if(strval($user_response) == strval($answer)) {
                           return 5;
                        }
                        else {
                           return -3;
                        }
                    }
                 }

                 $mylist = $my_list_of_questions;
                 $output = '';
                 $counter = 1;
                 foreach ($mylist as $value) {
                    $questionNo = $counter;
                    $id = $value[0]; // id format: "id-1"
                    $questionHere = $value[1];
                    $answerHere = $value[2];
                    $valueInput = getValueFromPOST($id);
                    $outcomeOfAnswer = displayCorrectOrWrong($valueInput,$answerHere);
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
                        <input 
                        style='margin-left: 1em;width: 170px;'
                        type='number'
                        name='$id'
                        value='$valueInput'
                        placeholder='answer for question $questionNo...'>
                      </td>
                      <td style='width:3%;'>
                        <span>$outcomeOfAnswer</span>
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

              //update overall score (cummulative only)
              $_SESSION['overallScore'] += $GLOBALS['current_section_score'];

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

                 <form method='post' action='#quizsection-section'>
                   <!-- table rows rendered here -->
                   $tableRows
                   <!-- table rows rendered here -->

                   <!-- submit button here -->
                   <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>  
                      <button type='submit' class='section-btn' name='abc' value='submit'>Submit</button>
                    </td>
                   </tr>
                   <!-- submit button here -->
                  </form>

               </table>

              </div>
              ";
              ?>
           </section>

           <!-- score section -->
           <section id='score-section' style='padding-left: 3.5em;padding-bottom: 1em;'>
              <span>Current Section Score:&nbsp&nbsp</span><span class='primarycolor'><b><?php echo strval($GLOBALS['current_section_score']) ?></b></span>
              <span>&nbsp&nbsp</span>
              <span>Overall Score:&nbsp&nbsp</span><span class='primarycolor'><b><?php echo strval($_SESSION['overallScore']) ?></b></span>
              <span>&nbsp&nbsp</span>
              <span>Correct Answer:&nbsp&nbsp</span><span class='primarycolor'><b><?php echo strval($GLOBALS['correct_answer']) ?></b></span>
              <span>&nbsp&nbsp</span>
              <span>Incorrect Answer:&nbsp&nbsp</span><span class='primarycolor'><b><?php echo strval($GLOBALS['wrong_answer']) ?></b></span>
              <span>&nbsp&nbsp</span>
           </section>

           <!-- navigation section -->
           <section id='navigation-section'>
              <form method='get' action='#quizsection-section' class='removeCSS'>
                <span class='lg-text' style='padding-left: 2.4em;'><b>Navigation:</b></span>
                <button 
                <?php echo ($GLOBALS['current_section'] == '1') ? 'disabled="true" style="background-color: lightgrey;pointer-events: none;color: grey;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value=<?php echo ($GLOBALS['current_section'] > '1') ? intval($GLOBALS['current_section']) - 1  : '1' ?>>Back</button>
                <button
                <?php echo ($GLOBALS['current_section'] == '3') ? 'disabled="true" style="background-color: lightgrey;pointer-events: none;color: grey;" ' : ''; ?>
                type='submit' class='section-btn' name='current_section' value=<?php echo ($GLOBALS['current_section'] < '3') ? intval($GLOBALS['current_section']) + 1  : '3' ?>>Next</button>
              </form>

              <span>
                <a href='<?php echo ALT_CURRENT_FILENAME ?>'><button style='margin: 1em;height: 2em;width: 11em;'>Do <?php echo ALT_QUIZ_TYPE ?> Quiz</button></a>
              </span>

              <form method='post' action='#quizsection-section' class='removeCSS'>
                 <button
                 <?php echo ($_SESSION['overallScore'] == '0') ? 'disabled="true" style="background-color: lightgrey;pointer-events: none;color: grey;" ' : ''; ?>
                 style='margin: 1em;height: 2em;width: 11em;'
                 type='submit' name='reset' value='reset'>Reset Overall Score</button>
              </form>

              <form method='get' action='#quizsection-section' class='removeCSS'>
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