<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

if(isset($_POST['postBtn']))
{
  $user->redirect('post.html');
}

$stmt=$user->runQuery("SELECT * FROM posts WHERE extract(YEAR_MONTH FROM timestamp)=:yearmonth AND extract(DAY FROM timestamp)=:day");
$stmt->execute(array(':yearmonth'=>$_SESSION['this_year'].$_SESSION['this_mon'],':day'=>$_GET['day']));

if($stmt->rowCount()<1)
{
  if($_SESSION['state']=='date')
    $user->redirect('mypage.php');
}
 ?>

<!doctype html>
<meta charset="utf-8">
<html>
   <head>
      <link rel="stylesheet" type="text/css" href="../css/post_list.css">
   </head>
   <body>
      <div class="header">
         <div class="btnArea">
            <ul>
               <li><a href="mypage.php">MY</a></li>
               <li><a href="mainpage.php">MAIN</a></li>
               <li><a href="index.html" onclick="logout()">LogOut</a></li>
            </ul>
         </div>
      </div>
      <div class="header" id="title">
         <?php
          if($_SESSION['state']=='date')
          {
            echo $_SESSION['this_year']."년 ".$_SESSION['this_mon']."월 ".$_GET['day']."일";
          }

          ?>
      </div>
      <div class="bodyInbox">
         <div class="content">
            <div class="leftBox">
              <?php
                for($i=0;$i<$stmt->rowCount();$i++)
                {
                  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                  print "<button class='btn' onclick=\"location.href='post.php?id=".$userRow['id']."'\" >";
                  print "<h1>";
                  print "<b>";
                  echo $userRow['title'];
                  print "</b>";
                  print "</h1>";
                  print "<br>";
                  echo $userRow['category'];
                  echo " ".$userRow['soje'];
                  print "<br>";
                  echo $_SESSION['id'];
                  print "</button>";
                }

               ?>
             </div>
            </div>
            <div class="rightBox">
              <?php
                  if($_GET['day'] == date("j",strtotime("now")))
                    print '<a class="write" href="./write.php">글 쓰기</a>';
               ?>
            </div>
         </div>
      </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
