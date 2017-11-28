<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

$stmt=$user->runQuery("SELECT * FROM posts WHERE extract(YEAR_MONTH FROM timestamp)=:yearmonth AND extract(DAY FROM timestamp)=:day");
$stmt->execute(array(':yearmonth'=>$_SESSION['this_year'].$_SESSION['this_mon'],':day'=>$_GET['day']));

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
               <li><a href="mypage.html">MY</a></li>
               <li><a href="mainpage.html">MAIN</a></li>
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
                  print "<div class='list' onclick='gotolist();'";
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
                  print "</div>";
                }

               ?>
             </div>
            </div>
            <div class="rightBox">
               <a class="write" href="./write.html">글 쓰기</a>
            </div>
         </div>
      </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
