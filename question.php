<?php
session_start();
require_once("pdo.php");
//get total question
$stmt=$db->prepare("SELECT * FROM questions");
$stmt->execute();
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
$total=sizeof($row);
//GET Question
if(isset($_GET['n'])){
$stmt=$db->prepare("SELECT * FROM questions WHERE question_number=:question");
$stmt->execute(array(":question"=>$_GET['n']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
}
//GET  choices
if(isset($_GET['n'])){
$stmt=$db->prepare("SELECT * FROM choices WHERE question_number=:question");
$stmt->execute(array(":question"=>$_GET['n']));
}
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
          <div class="current">Question <?php echo $_GET['n']; ?> of <?php echo $total; ?> </div>
          <p class="question">
          <?php if(isset($row)){echo $row['text']; }?>
          </p>
           <form action="process.php" method="post">
             <ul class="choices">
               <?php while ($rows=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
               <li> <input type="radio" name="choice" value="<?php echo $rows['id'];?>"/><?php echo $rows['text'];  ?></li>
             <?php endwhile; ?>
             </ul>
             <input type="hidden" name="number" value="<?php echo $_GET['n'] ;?>">
             <input type="submit" name="submit" value="Submit">
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
