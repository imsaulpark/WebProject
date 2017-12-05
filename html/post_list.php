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

if(isset($_GET['state']))
  $_SESSION['state']=$_GET['state'];

if($_SESSION['state']=='date')
{
  $stmt=$user->runQuery("SELECT * FROM posts WHERE extract(YEAR_MONTH FROM timestamp)=:yearmonth AND extract(DAY FROM timestamp)=:day AND memberid=:id ORDER BY timestamp DESC");
  $stmt->execute(array(':yearmonth'=>$_SESSION['this_year'].$_SESSION['this_mon'],':day'=>$_GET['day'],':id'=>$id));
}else if($_SESSION['state']=='category')
{
  $stmt=$user->runQuery("SELECT * FROM posts WHERE category=:category ORDER BY timestamp DESC");
  $stmt->execute(array(':category'=>$_GET['category']));
}else if($_SESSION['state']=='soje')
{

  $stmt=$user->runQuery("SELECT * FROM posts WHERE soje=:soje AND memberID=:id ORDER BY timestamp DESC");
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
  $query.=" ORDER BY timestamp DESC";
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
 		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
 				<!-- Latest compiled and minified CSS -->
 		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 		<!-- jQuery library -->
 		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 		<!-- Latest compiled JavaScript -->
 		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
 		<!-- mobile reaction-->
 		<meta name="viewport" content="width=device-width, initial-scale=1">

 		<style>

 			@import url(http://fonts.googleapis.com/earlyaccess/kopubbatang.css);
 			@import url(http://fonts.googleapis.com/earlyaccess/hanna.css);
 			@import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);
 			.service{
 				padding-right: 2em;
 				padding-top: 1em;
 			}

 			.list{
 				background-color : #F5F5F5;

 			}

      *{
        font-family: 'Jeju Gothic', serif;
      }

      h1{
        font-size: 2.5em;
        color:black;
      }

      h2{
        font-size: 1.5em;
        color:black;
      }

      h3{
        text-overflow: ellipsis;
        font-size:1.2em;
        line-height: 80%;
      }

      .post{
        background-color:rgba(0, 0, 0, 0);
        border-bottom: 1px solid #DCDCDC;
        text-align: left;
        color:	#696969;
      }

      .content{
         overflow: hidden;
         text-overflow: ellipsis;
         height : 4.5em;
         color:	#696969;
      }

 			</style>
   </head>
   <body>
     <div class="contatiner main text-center">

          <div class="row text-right service">
           <a class= "btn btn-default serviceBtn" href="mypage.php">MY</a>
           <a class= "btn btn-default serviceBtn"  href="mainpage.php">MAIN</a>
           <?php
               if( $_SESSION['state']=='date')
               {
                 if($_GET['day'] == date("j",strtotime("now")))
                   print '<a class="btn btn-default serviceBtn" href="./write.php">WRTIE</a>';
               }else {
                 print '<a class="btn btn-default serviceBtn" href="./write.php">WRITE</a>';
               }
            ?>
           <a class= "btn btn-default serviceBtn" href="logout.php?logout=true">LogOut</a>
          </div>


  				 <div class="row">
             <div class="col-xs-offset-4 col-xs-4">
               <?php
                if($_SESSION['state']=='date')
                {
                  print "<h1>";
                  echo $_SESSION['this_year']."년 ".$_SESSION['this_mon']."월 ".$_GET['day']."일";
                  print "</h1>";
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
                <br><br>
             </div>
          </div>
      </div>
      <div class="contatiner list text-center">
        <?php
          if(isset($empty))
            echo $empty;
          for($i=0;$i<$stmt->rowCount();$i++)
          {
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            print "<div class=\"row\">";
            print "<div class=\"col-xs-offset-3 col-xs-6\">";
            print "<div class=\"col-xs-offset-2 col-xs-8\">";
            print "<button class='btn btn-block post' onclick=\"location.href='post.php?id=".$userRow['id']."'\" >";
            print "<br>";
            print "<h2>";
            echo $userRow['title'];
            print "</h2>";
            print "<div class='content'>";
            print "<h3>";
            echo $userRow['content'];
            print "</h3>";
            print "</div>";
            print "<br>";
            echo $userRow['category']." ·";
            echo " ".$userRow['soje'];
            echo " · ".$userRow['hits']." hits";
            echo " · ".date("Y-m-d", strtotime($userRow['timestamp']));
            print "<br>";
            echo "By ".$userRow['memberID'];
            print "<br><br>";
            print "</button>";
            print "</div></div></div>";
          }

         ?>
      </div>

      <div class="header" id="title">

      </div>
      </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
