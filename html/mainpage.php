<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

//상위 4개의 포스트를 가져옴
$bestPosts = $user->get_best_post();

//모든 카테고리 종류를 가져옴
$allCategory = $user->get_all_category();

$_SESSION['state']='category';

?>

<!doctype html>
<meta charset="utf-8">
<html>
   <head>
      <!-- 부트스트랩 임포트  -->
      <link rel="stylesheet" type="text/css" href="../css/mainpage.css?ver=2">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
          <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <!-- mobile reaction-->
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- 글씨체 임포트 -->
      <style>

      @import url(//fonts.googleapis.com/earlyaccess/nanumpenscript.css);
      @import url(http://fonts.googleapis.com/earlyaccess/kopubbatang.css);
      @import url(http://fonts.googleapis.com/earlyaccess/hanna.css);
      @import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);

      h1{
        font-family: 'Nanum Pen Script', cursive;
        font-size:5em;
        margin-bottom:0;
      }
      h2{
                margin-top:0;
        font-family: 'Nanum Pen Script', cursive;
        font-size:3em;
        color:gray;
      }

  		</style>

   </head>
   <body>
      <div class="containe text-center">
        <div class="row text-right service">
         <a class= "btn btn-default" href="mypage.php">MY</a>
         <a class= "btn btn-default"  href="mainpage.php">MAIN</a>
         <a class= "btn btn-default" href="logout.php?logout=true">LogOut</a>
        </div>

        <br><br>
          <div class="row heading">
               <h1>BEST POSTS</h1>
               <h2>BOOKCHEF의 최고의 게시물을 만나보세요!</h2>
                <br>
          </div>
          <!-- 상위 4개의 게시물을 나열. -->
          <div class="row">
                <br><br>
            <?php
              print "<div class='col-xs-3'></div><div class='col-xs-6'>";
              for($i=0;$i<$bestPosts->rowCount();$i++)
              {
                $userRow=$bestPosts->fetch(PDO::FETCH_ASSOC);
                print "<div class='col-xs-3 text-center'>";
                print "<button class='circle' onclick=\"location.href='post.php?state=\'category\'&id=".$userRow['id']."'\" >";
                print "<p>";
                echo $userRow['title'];
                print "</p>";
                print "<br>";
                echo $userRow['category'];
                echo " ".$userRow['soje'];
                print "<br>";
                print "</button>";
                print "</div>";
              }
                print "</div><div class='col-xs-2'></div>";
             ?>
          </div>
         <br><br><br><br><br>
         <div class="row heading">
               <h1>CATEGORY</h1>
               <h2>CATEGORY 별로 분류해 보세요!</h2>
               <br>
          </div>
          <br><br>
              <!-- 카테고리 24개를 4x6의 형태로 나눠서 정 -->
              <?php
                for($i=0;$i<$allCategory->rowCount();$i++)
                {
                  if($i%6==0) print '<div class="row"><div class="col-xs-2"></div><div class="col-xs-8"><div class="col-xs-3"></div>';
                  $userRow=$allCategory->fetch(PDO::FETCH_ASSOC);
                  print "<div class='col-md-1 text-center' style='padding-right:0;padding-left:0;'>";
                  print "<button class='categoryBtn btn-block' onclick=\"location.href='post_list.php?state=category&category=".$userRow['category']."'\" >";
                  print "<a>";
                  print "<b>";
                  echo $userRow['category'];
                  print "</b>";
                  print "</a>";
                  print "</button>";
                  print "</div>";
                  if(($i+1)%6==0) print '</div><div class="col-xs-2"></div></div>';
                }

               ?>
               <br><br> <br><br>
        </div>
   </body>
</html>
