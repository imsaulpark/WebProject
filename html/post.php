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
  $user->delete_post($userRow['id']);
  if($_SESSION['state']=='date')
  {
    $day = date("d",strtotime($userRow['timestamp']));

    $user->redirect('post_list.php?day='.$day);
  }
  else if($_SESSION['state']=='category')
  {
    $user->redirect('post_list.php?category='.$userRow['category']);
  }
  else if($_SESSION['state']=='soje')
  {
    $user->redirect('post_list.php?soje='.$userRow['soje']);
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

      <style>

        @import url(http://fonts.googleapis.com/earlyaccess/kopubbatang.css);
        @import url(http://fonts.googleapis.com/earlyaccess/hanna.css);
        @import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);

      .service{
          padding-right: 2em;
          padding-top: 1em;
        }

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
          font-size:1.2em;
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

           <div class="row text-right service">
                 <a class= "btn btn-default serviceBtn" href="mypage.php">MY</a>
                <a class= "btn btn-default serviceBtn"  href="mainpage.php">MAIN</a>
                 <a class= "btn btn-default serviceBtn"  href="index.html" onclick="logout()">LogOut</a>

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
          <?php
          echo $userRow['content'];
          ?>
         </div>
       </div>
       <br><br><br>
       <div class="row text-center">
         <form method="post">
           <?php
           if($_SESSION['id']==$userRow['memberID'])
           {
             print '<button class="btn btn-primary" name="editBtn">수정</button>';
             print " ";
             print '<button class="btn btn-danger" name="deleteBtn">삭제</button>';
           }
           ?>
           <br><br><br>
        </form>
       </div>
     </div>

      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
