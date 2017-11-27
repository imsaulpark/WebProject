<?php


	require_once 'session.php';
	require_once 'user.php';
	$user = new USER();
	$id = $_SESSION['id'];

	$keywords = array("keyword1", "keyword2", "keyword3", "keyword4", "keyword5", "keyword6");

	if(!$user->is_loggedin())
	{
		$user->redirect('index.php');
	}

?>

<!doctype html>
<meta charset="utf-8">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/mypage.css">
	</head>
	<body id="body">
		<div class="bodyInbox">
			<div class="header">
				<div class="btnArea">
					<ul>
 				                <li><a href="logout.php?logout=true">Sign Out</a></li>
						<li><a href="">MAIN</a></li>
						<li><a href="">수정</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="leftBox">
					<form class="loginForm">
						<span>저자/작명 부분</span><button class="btn" id="calendar"><a>달력</a></button>
						<div></div>
						<?php

							$stmt=$user->get_soje($_SESSION['id']);
							for($i=0;$i<$stmt->rowCount();$i++)
							{
								$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
								if($userRow['soje']!=NULL){
								?>
								<button class="btn" name="cat<?php echo $i ?>"><a><?php echo $userRow['soje'] ?></a></button>
							<?php   }
							}
						?>
						<button class="btn" id="addCat" name="logoutBtn"><a>추가</a></button>
					</form>
				</div>
				<div class="rightBox">
					<p class="p1">책소개가<br/>들어가는 부분!</p>
					<p class="p2">구독자 수 <?php echo $user->get_num_subscriber($_SESSION['id']) ?>명<br/>작성글 수 <?php echo $user->get_num_post($_SESSION['id']) ?>개</p>

				</div>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
