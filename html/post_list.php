<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

if(isset($_POST['postBtn']))
{
  $user->redirect('post.html');
}

if(isset($_GET['id']))
{
  $id=$_GET['id'];
}
else {
    $id=$_SESSION['id'];
}
if($_SESSION['state']=='date')
{
  $stmt=$user->runQuery("SELECT * FROM posts WHERE extract(YEAR_MONTH FROM timestamp)=:yearmonth AND extract(DAY FROM timestamp)=:day AND memberID=:id");
  $stmt->execute(array(':yearmonth'=>$_SESSION['this_year'].$_SESSION['this_mon'],':day'=>$_GET['day'],':id'=>$id));
}else if($_SESSION['state']=='category')
{
  $stmt=$user->runQuery("SELECT * FROM posts WHERE category=:category");
  $stmt->execute(array(':category'=>$_GET['category']));
}else if($_SESSION['state']=='soje')
{

  $stmt=$user->runQuery("SELECT * FROM posts WHERE soje=:soje AND memberID=:id");
  $stmt->execute(array(':soje'=>$_GET['soje'],':id'=>$id));
}else if($_SESSION['state']=='subscription')
{
  $stmt=$user->runQuery("SELECT * FROM subscription WHERE subscriber=:subscriber");
  $stmt->execute(array(':subscriber'=>$_SESSION['id']));

  $query="SELECT * FROM posts WHERE id='-1'" ;

  for($i=0;$i<$stmt->rowCount();$i++)
  {
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
    $query.=" OR memberID=\"".$userRow['writer']."\"";
  }

  $stmt=$user->runQuery($query);
  $stmt->execute();
}

if($stmt->rowCount()<1)
{
  $empty = "There is no post here.";
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
 				          <li><a href="logout.php?logout=true">LogOut</a></li>
            </ul>
         </div>
      </div>
      <div class="header" id="title">
         <?php
          if($_SESSION['state']=='date')
          {
            echo $_SESSION['this_year']."년 ".$_SESSION['this_mon']."월 ".$_GET['day']."일";
          }
          else if($_SESSION['state']=='category')
          {
            print "<h1>";
            echo $_GET['category'];
            print "</h1>";
          }else if($_SESSION['state']=='soje')
          {

              print "<h1>";
              echo $_GET['soje'];
              print "</h1>";
          }else if($_SESSION['state']=='subscription')
          {

              print "<h1>";
              echo "구독하는 글";
              print "</h1>";
          }
          ?>
      </div>
      <div class="bodyInbox">
         <div class="content">
            <div class="leftBox">
              <?php
                if(isset($empty))
                  echo $empty;
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
                  echo $userRow['memberID'];
                  print "</button>";
                }

               ?>
             </div>
            </div>
            <div class="rightBox">
              <?php
                  if( $_SESSION['state']=='date')
                  {
                    if($_GET['day'] == date("j",strtotime("now")))
                      print '<a class="write" href="./write.php">글 쓰기</a>';
                  }else {
                    print '<a class="write" href="./write.php">글 쓰기</a>';
                  }
               ?>
            </div>
         </div>
      </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
