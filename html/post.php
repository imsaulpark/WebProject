<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();


$stmt=$user->runQuery("SELECT * FROM posts WHERE id=:id");
$stmt->execute(array(':id'=>$_GET['id']));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if($_SESSION['id']!=$userRow['memberID'])
{
  $user->add_hit($userRow['id']);
  $userRow['hits']+=1;
}

if(isset($_POST['deleteBtn']))
{
  if($_SESSION['state']=='date')
  {
    $day = date("d",strtotime($userRow['timestamp']));
    $user->delete_post($userRow['id']);
    $user->redirect('post_list.php?day='.$day);
  }
  else if($_SESSION['state']=='category')
  {
    $user->delete_post($userRow['id']);
    $user->redirect('post_list.php?category='.$userRow['category']);
  }
}

if(isset($_POST['editBtn']))
{
  $user->redirect('write.php?id='.$userRow['id']);
}

 ?>

<!doctype html>
<meta charset="utf-8">
<html>
   <head>
      <link rel="stylesheet" type="text/css" href="../css/post.css">

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
        .main{
          font-family: 'Jeju Gothic', serif;
          font-size:1.4em;
          color:#DCDCDC;
        }
        div a{
          color:#FFE4B5
        }
        h1{
          font-family: 'Hanna', serif;
          font-size: 2.4em;
          display: inline;
          color:white;
        }
        .catesoje{
          color:#DCDCDC;
        }
        h3{
          color:#DCDCDC;
          font-size:0.7em;
          display:inline;
        }
        body, html {
            height: 100%;
            margin: 0;
        }

        .content{
          font-family: 'Jeju Gothic', serif;
        }
        .bg {
            /* The image used */
            background-image: url("../img/christmas.jpg");

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
      </style>
   </head>
   <body>
     <div class="bg">


      <div class="contatiner main text-center">

           <div class="btnArea text-right">
              <ul>
                 <li><a href="mypage.php">MY</a></li>
                 <li><a href="mainpage.php">MAIN</a></li>
                 <li><a href="index.html" onclick="logout()">LogOut</a></li>
              </ul>
           </div>
           <br><br><br><br><br><br>
        <div class="row">
          <div class="col-xs-offset-2 col-xs-8">
            <h1><?php echo $userRow['title']; ?></h1> <h3><?php echo date("Y-m-d",strtotime($userRow['timestamp'])); ?></h3>
          </div>
       </div>
       <br>
       <div class="row">
         <div class="col-xs-offset-2 col-xs-8 catesoje">
           <?php echo $userRow['category']." ".$userRow['soje']; ?>
         </div>
       </div>
       <!--
       <div class="row">
         <div class="col-xs-offset-4 col-xs-4">
           <?php echo $userRow['hits']." HITS"; ?>
         </div>
       </div>

      <br>
       <div class="row">
         <div class="col-xs-offset-4 col-xs-4">
           <?php echo date("Y-m-d",strtotime($userRow['timestamp'])); ?>
         </div>
       </div>
-->
       <div class="row">
         <div class="col-xs-offset-2 col-xs-8">
           By <a href="hispage.php?id=<?php echo $userRow['memberID']; ?>"><?php echo $userRow['memberID']; ?></a>
         </div>
       </div>
       </div>
  </div>
       <br><br>
       <div class="container content">
       <div class="row">
         <div class="col-xs-offset-3 col-xs-6">
          <?php echo $userRow['content']; ?>
         </div>
       </div>
     </div>

      <div class="bodyInbox">
         <div class="content">
            <div class="rightBox">
              <form method="post">
                <?php
                if($_SESSION['id']==$userRow['memberID'])
                {
                  print '<button class="btn" name="editBtn"><a>수정</a></button>';
                  print '<button class="btn" name="deleteBtn"><a>삭제</a></button>';
                }
                ?>
             </form>
               <div class="empty"></div>

            </div>

         </div>
      </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
