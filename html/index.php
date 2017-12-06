<?php

session_start();

require_once("user.php");

$user = new USER();

//로그인 되었다면 mypage로
if($user->is_loggedin()!="")
{
        $user->redirect('mypage.php');
}

//login버튼이 눌리면 id pw확인하고 맞으면 페이지 이동.
//해당페이지로 현재 시간 정보를 제공
if(isset($_POST['loginBtn']))
{

        $id = $_POST['id'];
        $pw = $_POST['pw'];

        if($user->login($id,$pw))
        {

            $_SESSION['count']=0;
            $_SESSION['last_day'] = date("t", time()); //총 요일 수
            $_SESSION['start_day'] = date("w", strtotime(date("Y-m")."-01")); //시작 요일
            $_SESSION['total_week'] = ceil(($_SESSION['last_day'] + $_SESSION['start_day'] )/7); // 총 요일
            $_SESSION['last_week'] = date('w',strtotime(date("Y-m")."-".$_SESSION['last_day'] ));
            $_SESSION['this_mon'] = date("m",strtotime(date("Y-m",strtotime('+0 month'))));
            $_SESSION['this_year'] = date("Y",strtotime(date("Y-m",strtotime('+0 month'))));

            $_SESSION["id"]=$id;
            $user->redirect('mypage.php');
        }
        else
        {
                echo '<script>alert("Wrong ID or Pasword!")</script>';
        }
}

?>

<!doctype html>
<meta charset="utf-8">
<html>
	<head>
    <!-- 부트스트랩 임포트 -->
		<link rel="stylesheet" type="text/css" href="../css/index.css?ver=1">
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

    @import url(http://fonts.googleapis.com/earlyaccess/kopubbatang.css);
    @import url(http://fonts.googleapis.com/earlyaccess/hanna.css);
    @import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);


    </style>

	</head>
	<body id="body">
    <!-- id와 pw를 입력하는 로그인창 및 회원가입과 id/pw찾기  -->
    <div class="text-center">
      <div class="row col-xs-offset-6 col-xs-6 right">
        <div class="content">
          <div class="upper">
          </div>
          <form class="form" method="post">
            <div class="row title">
              <p class="p1">Book Chef</p>
              <p class="p2">당신만의 책을 요리하세요!</p>
            </div>
            <div class="form-group login">
              <ul>
                <li><i class="fa fa-user" aria-hidden="true"></i><input class="id_input" style="font-family: 'Kopub Batang'" name="id" type="text" placeholder="ID"> </li>
                <li><i class="fa fa-key"></i><input class="pw_input" style="font-family: 'Kopub Batang'" name="pw" type="password" placeholder="Password"> </li>
              </ul>
              <p><button name="loginBtn" id="loginBtn">Log In</button></p>
              <div><a href="./join.php">회원가입</a> / <a href="./find_ID_PW.php">ID,PW찾기</a> </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    <!-- 자바스크립트를 통해 팝업창 띄우기 (id/pw찾기) -->
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
