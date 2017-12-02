<?php

session_start();

require_once("user.php");

$user = new USER();

if($user->is_loggedin()!="")
{
        $user->redirect('mypage.php');
}

if(isset($_POST['loginBtn']))
{
        $id = $_POST['id'];
        $pw = $_POST['pw'];

        if($user->login($id,$pw))
        {
		            $_SESSION["id"]=$id;
                $user->redirect('mypage.php');
        }
        else
        {
                $error = "Wrong Details !";
        }
}

?>

<!doctype html>
<meta charset="utf-8">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/index.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- mobile reaction-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

	</head>
	<body id="body">

		<div class="bodyInbox">
			<div class="content">
				<div class="leftBox">
				</div>
				<div class="rightBox">
					<div class="header">
						<div class="btnArea">
							<ul>
								<li><a href="">MAIN</a></li>
							</ul>
						</div>
					</div>
					<div class="rightBody">
						<p class="p1">Book Chef</p>
						<p class="p2">당신만의 책을 <br/>요리하세요!</p>
						<br/><br/>
						<form class="loginForm" method="post">

								<ul>
									<li><i class="fa fa-user" aria-hidden="true"></i><input class="id_input" name="id" type="text" placeholder="ID"> </li>
									<li><i class="fa fa-key"></i><input class="pw_input" name="pw" type="password" placeholder="Password"> </li>
								</ul>
								<br/><br/>
								<p><button name="loginBtn" id="loginBtn">Log In</button></p>
								<div><a href="./join.php">회원가입</a> / <a href="javascript:;" onclick="find_id_pw();">ID&PW찾기</a> </div>

						</form>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
