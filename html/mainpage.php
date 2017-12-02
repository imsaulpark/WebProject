<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

$bestPosts = $user->get_best_post();
$allCategory = $user->get_all_category();

$_SESSION['state']='category';

?>

<!doctype html>
<meta charset="utf-8">
<html>
   <head>
      <link rel="stylesheet" type="text/css" href="../css/mainpage.css">

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
      @import url(//fonts.googleapis.com/earlyaccess/nanumpenscript.css);

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
      <div class="header">
         <div class="btnArea">
            <ul>
               <li><a href="mypage.php">MY</a></li>
               <li><a href="mainpage.php">MAIN</a></li>
 				       <li><a href="logout.php?logout=true">LogOut</a></li>
            </ul>
         </div>
      </div>
<br><br>
         <div>
           <div class="containe text-center">
            <div class="row">
               <h1>BEST POSTS</h1>
               <h2>BOOKCHEF의 최고의 게시물을 만나보세요!</h2>
                <br>
            </div>
              <div class="row">
            <?php
              print "<div class='col-xs-3'></div><div class='col-xs-6'>";
              for($i=0;$i<$bestPosts->rowCount();$i++)
              {
                $userRow=$bestPosts->fetch(PDO::FETCH_ASSOC);
                print "<div class='col-xs-3 text-center'>";
                print "<button class='circle' onclick=\"location.href='post.php?id=".$userRow['id']."'\" >";
                print "<a>";
                print "<b>";
                echo $userRow['title'];
                print "</b>";
                print "</a>";
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
           </div>
         </div>
         <br><br><br><br><br>
         <div class="container text-center">
               <h1>CATEGORY</h1>
               <h2>CATEGORY 별로 분류해 보세요!</h2>
               <br>
              <?php
                for($i=0;$i<$allCategory->rowCount();$i++)
                {
                  if($i%6==0) print '<div class="row"><div class="col-xs-2"></div><div class="col-xs-8">';
                  $userRow=$allCategory->fetch(PDO::FETCH_ASSOC);
                  print "<div class='col-xs-3 col-md-2 text-center' style='padding-right:0;padding-left:0;'>";
                  print "<button class='categoryBtn btn-block' onclick=\"location.href='post_list.php?category=".$userRow['category']."'\" >";
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
        </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
