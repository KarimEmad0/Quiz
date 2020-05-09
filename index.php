<?php
require_once("pdo.php");
$stmt=$db->prepare("SELECT * FROM questions");
$stmt->execute();
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
$res=sizeof($row);
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
          <h2>Test Your PHP Knowledge</h2>
          <p>This is a multible choice quiz to test your Knowledge of PHP</p>
          <ul>
            <li> <strong>Number of Questions: </strong><?php echo $res;?></li>
            <li> <strong>Type: </strong>Multible choice</li>
            <li> <strong>Estimated Time: </strong>4 Minutes</li>
          </ul>
          <a href="question.php?n=1" class="start">Start Quiz</a>
        </div>

     </main>

    <footer>
      <div class="container">
            Copyright &copy: 2019 PHP Quizzer
      </div>
    </footer>
  </body>
</html>
