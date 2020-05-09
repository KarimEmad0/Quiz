<?php
require_once('pdo.php');
if(isset($_POST['submit'])){

  if(isset($_POST['question_number']) && isset($_POST['question_text']) ){
    $validate=0;
    if($_POST['question_text']==''){
      $_SESSION['fail']="Please enter the question text";
      header("location:admin.php");
      return;
    }
      $choices=array();
      if(isset($_POST['correct_choice'])){
        $correct_choice=$_POST['correct_choice'];
      }
    if(isset($_POST['choice1'])){
      $choices[0]=$_POST['choice1'];
      if($_POST['choice5']!=''){
      $validate++;
      }  }
  if(isset($_POST['choice2'])){
    $choices[1]=$_POST['choice2'];
    if($_POST['choice5']!=''){
    $validate++;
    }  }

if(isset($_POST['choice3'])){
  $choices[2]=$_POST['choice3'];
  if($_POST['choice5']!=''){
  $validate++;
  }}

if(isset($_POST['choice4'])){
$choices[3]=$_POST['choice4'];
if($_POST['choice5']!=''){
$validate++;
}}

if(isset($_POST['choice5'])){
$choices[4]=$_POST['choice5'];
if($_POST['choice5']!=''){
$validate++;
}
}
if($validate>1){
    $stmt=$db->prepare("insert into questions (question_number,text) values (:number,:text)");
    $stmt->execute(array(
      ":number"=>$_POST['question_number'],
      ":text"=>$_POST['question_text']
    ));

    if($stmt->rowcount()>0){
      foreach ($choices as $choice => $value) {
        if($value!=''){
            if($correct_choice==($choice+1)){
              $is_correct=1;
            }
            else {$is_correct=0;
            }
            $stmt=$db->prepare("insert into choices (question_number,is_correct,text) values(:number,:correct,:text)" );
            $stmt->execute(array(
              ":number"=>$_POST['question_number'],
              ":correct"=>$is_correct,
              ":text"=>$value
            ));
            if($stmt->rowcount()>0){
              continue;
            }
            else{
            $_SESSION['fail']="ERROR";
            header("location:admin.php");
            return;
           }
         }
      }
      $_SESSION['success']="Question has been added";
      header("location:admin.php");
      return;
      }
    }
    else{
        $_SESSION['fail']="ERROR number of chices is less than two";
        header("location:admin.php");
        return;
      }
  }
}
//get total of Questions
$stmt=$db->prepare("SELECT * FROM questions");
$stmt->execute();
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
$total=sizeof($row)+1;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PHP Quizzer</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
  </head>
  <body>
      <header>
        <div class="container">
          <h1>PHP Quizzer</h1>
        </div>
      </header>

      <main>
        <div class="container">
            <h2>Add A Question</h2>
            <?php
              if (isset($_SESSION['success'])) {
                  echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
                  unset($_SESSION['success']);
              }
              if (isset($_SESSION['fail'])) {
                echo "HELLO WORLD";
                  echo('<p style="color:red;">' . htmlentities($_SESSION['fail']) . "</p>\n");
                  unset($_SESSION['fail']);
              }
             ?>

            <form action="admin.php" method="post">
              <p>
                <label>Question Number: </label>
                <input type="number" value="<?php echo $total; ?>" name="question_number" >
              </p>
              <p>
                <label>Question Text: </label>
                <input type="text" name="question_text" >
              </p>
              <p>
                <label>Choice #1: </label>
                <input type="text" name="choice1" >
              </p>
              <p>
                <label>Choice #2: </label>
                <input type="text" name="choice2" >
              </p>
              <p>
                <label>Choice #3: </label>
                <input type="text" name="choice3" >
              </p>
              <p>
                <label>Choice #4: </label>
                <input type="text" name="choice4" >
              </p>
              <p>
                <label>Choice #5: </label>
                <input type="text" name="choice5" >
              </p>
              <p>
                <label>Corrrect Choice Number: </label>
                <input type="number" name="correct_choice" >
              </p>
              <p>
                <input type="submit" name="submit" value="Submit" >
              </p>
            </form>
        </div>

     </main>

    <footer>
      <div class="container">
            Copyright &copy: 2019 PHP Quizzer
      </div>
    </footer>
  </body>
</html>
