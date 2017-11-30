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
  $day = date("d",strtotime($userRow['timestamp']));
  $user->delete_post($userRow['id']);
  $user->redirect('post_list.php?day='.$day);
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
         <h1><?php echo $userRow['title']; ?></h1>
         <div class="cate"><?php echo $userRow['category']." ".$userRow['soje']; ?></div>
         <div class="count"><?php echo "조회수 : ".$userRow['hits']; ?></div>
         <br>
         <div class="time"><?php echo $userRow['timestamp']; ?></div>
      </div>
      <div class="bodyInbox">
         <div class="content">
            <div class="leftBox">
               <div class="context">
                  <?php echo $userRow['content']; ?>
               </div>
            </div>
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

               <?php
               if($_SESSION['id']!=$userRow['memberID'])
               {
                 print '<a class="btn" id="subscribe" name="subscribeBtn">구독하기</a>';
               }
               ?>
            </div>

         </div>
      </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
