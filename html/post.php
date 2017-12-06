<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

//글의 정보를 표시하기 위해 db로부터 글의 정보를 담은 객체를 가져온다.
$stmt=$user->runQuery("SELECT * FROM posts WHERE id=:id");
$stmt->execute(array(':id'=>$_GET['id']));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['count']=0;
$_SESSION['last_day'] = date("t", time()); //총 요일 수
$_SESSION['start_day'] = date("w", strtotime(date("Y-m")."-01")); //시작 요일
$_SESSION['total_week'] = ceil(($_SESSION['last_day'] + $_SESSION['start_day'] )/7); // 총 요일
$_SESSION['last_week'] = date('w',strtotime(date("Y-m")."-".$_SESSION['last_day'] ));
$_SESSION['this_mon'] = date("m",strtotime(date("Y-m",strtotime('+0 month'))));
$_SESSION['this_year'] = date("Y",strtotime(date("Y-m",strtotime('+0 month'))));

//get id가 셋 되어있다면 해당 아이디를, 아니면 session id를 써서 해당 해당 글이 본인인지 확인함.
if(isset($_GET['id']))
{
  $id=$_GET['id'];
}
else {
    $id=$_SESSION['id'];
}

//해당글이 본인 글이 아니라면 조회수를 1을 추가시킴.
if($_SESSION['id']!=$userRow['memberID'])
{
  $user->add_hit($userRow['id']);
  $userRow['hits']+=1;
}

//get state정보를 가지고 있다면 session state 정보로도 넘겨준다.
if(isset($_GET['state']))
{
  $_SESSION['state']='category';
}

//삭제버튼이 눌리면 글을 삭제한다.
//그리고 원래 넘어왔던 페이지로 다시 넘어가게 된다.
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

//edit 버튼을 누르면 글을 수정하는 페이지로 넘어간다.
if(isset($_POST['editBtn']))
{
  $user->redirect('write.php?id='.$userRow['id']);
}

 ?>

<!doctype html>
<meta charset="utf-8">
<html>
   <head>
     <!-- 부트스트랩 임포트  -->
      <link rel="stylesheet" type="text/css" href="../css/post.css">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
          <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <!-- mobile reaction-->

      <!-- 글씨체 임포트 -->
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
            background-image: url("../img/post.jpg");

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

        <!-- 우측상단 메뉴버튼들 -->
        <div class="row text-right service">
         <a class= "btn btn-default" href="mypage.php">MY</a>
         <a class= "btn btn-default"  href="mainpage.php">MAIN</a>
         <a class= "btn btn-default" href="logout.php?logout=true">LogOut</a>
        </div>

           <br><br><br><br><br><br>
        <div class="row">
          <!-- 제목과 시간  -->
          <div class="col-xs-offset-2 col-xs-8">
            <h1><?php echo $userRow['title']; ?></h1> <h3><?php echo date("Y-m-d",strtotime($userRow['timestamp'])); ?></h3>
          </div>
       </div>
       <br>
       <div class="row">
         <!-- 카테고리와 소제 -->
         <div class="col-xs-offset-2 col-xs-8 catesoje">
           <?php echo $userRow['category']." ".$userRow['soje']; ?>
         </div>
       </div>
       <!-- 작가 이름. 작가이름을 누르면 해당 작가 페이지로 이동 -->
       <div class="row">
         <div class="col-xs-offset-2 col-xs-8">
           By <a href="hispage.php?id=<?php echo $userRow['memberID']; ?>"><?php echo $userRow['memberID']; ?></a>
         </div>
       </div>
       </div>
     </div>
       <br><br>
       <!-- 내용물 출력 -->
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
           <!-- 본인 글이라면 수정 및 삭제 가능  -->
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
   </body>
</html>
