<?php
require_once("pdo.php");
session_start();
//check for score
if(!isset($_SESSION['score'])){
  $_SESSION['score']=0;
}
if(isset($_POST['submit'])&&isset($_POST['number'])&&isset($_POST['choice'])){
  $number=$_POST['number'];    //get question number
  $selected_choice=$_POST['choice']; // get selected choice
  $next=$number+1; //to get next question
  $true=1;
  //get correct choice
  $stmt=$db->prepare("SELECT * FROM choices WHERE question_number=:question AND is_correct=:num");
  $stmt->execute(array(":question"=>$_POST['number'] , ":num"=>$true) );
  $row=$stmt->fetch(PDO::FETCH_ASSOC);
  if($row['id']==$selected_choice){
    $_SESSION['score']+=1;
  }
  //get total of Questions
  $stmt=$db->prepare("SELECT * FROM questions");
  $stmt->execute();
  $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
  $total=sizeof($row);
  //last question so redirect
  if($number==$total){
    header("location:final.php");
    return;
  }
  else{header("location:question.php?n=".$next."");}
}
 ?>
