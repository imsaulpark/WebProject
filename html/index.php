<?php

session_start();

require_once 'dbconfig.php';



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
	</head>
	<body id="body">
		<div class="header">
			<div class="btnArea">
				<ul>
					<li><a href="">MAIN</a></li> 
					<li><a href="">MY</a></li>
				</ul>
			</div>
		</div>
		<div class="bodyInbox">
			<div class="content">
				<div class="leftBox">
					<form class="loginForm" method="post">
						<fieldset>
							<ul>
								<li><span>ID</span><input name="id" type="text"> </li>
								<li><span>PW</span><input name="pw" type="password"> </li>
							</ul>
							<p><button name="loginBtn" id="loginBtn"><a>로그인</a></button></p>
							<div><a href="./join.php">회원가입</a> / <a href="javascript:;" onclick="find_id_pw();">ID&PW찾기</a> </div>
							<a href="./find_ID_PW.php">ID&PW찾기</a>
						</fieldset>
					</form>
				</div>
				<div class="rightBox">
					<p class="p1">Book Chef</p>
					<p class="p2">당신만의 책을 <br/>요리하세요!</p>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
