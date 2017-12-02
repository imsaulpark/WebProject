<?php


	require_once 'session.php';
	require_once 'user.php';
	$user = new USER();
	$id = $_SESSION['id'];
	$_SESSION['state']='soje';

	$keywords = array("keyword1", "keyword2", "keyword3", "keyword4", "keyword5", "keyword6");

	if(!$user->is_loggedin())
	{
		$user->redirect('index.php');
	}

	if(isset($_GET['calendarBtn']))
	{

		$_SESSION['count']=0;
		$_SESSION['last_day'] = date("t", time()); //총 요일 수
		$_SESSION['start_day'] = date("w", strtotime(date("Y-m")."-01")); //시작 요일
		$_SESSION['total_week'] = ceil(($_SESSION['last_day'] + $_SESSION['start_day'] )/7); // 총 요일
		$_SESSION['last_week'] = date('w',strtotime(date("Y-m")."-".$_SESSION['last_day'] ));
		$_SESSION['this_mon'] = date("m",strtotime(date("Y-m",strtotime('+0 month'))));
		$_SESSION['this_year'] = date("Y",strtotime(date("Y-m",strtotime('+0 month'))));

  	//$_SESSION['last_day']=date("t",strtotime("now "."-12"." month"));
		//$_SESSION['start_day'] = date("w", strtotime(date("Y-m",strtotime("now"."-12"."month") )."-01"));
	  //$_SESSION['this_mon']= date("m",strtotime("now "."-12"." month"));
	  //$_SESSION['last_week'] = date("w",strtotime(date("Y-m",strtotime("now"."-12"." month") )."-".$_SESSION['last_day'] ));
		//echo $_SESSION['last_day'];
		//echo $_SESSION['start_day'];
		//echo $_SESSION['this_mon'];
		//echo strtotime('');
		//echo date("Y-m-d",strtotime("now -1 month"));
		//echo $_SESSION['this_year'];
		//echo $_SESSION['last_day'];
		//echo $_SESSION['start_day'];
		//echo $_SESSION['total_week'];
		//echo $_SESSION['last_week'];
		$user->redirect('calendar.php');
	}

	if(isset($_GET['subscriptionBtn']))
	{
		$_SESSION['state']='subscription';
		$user->redirect('post_list.php');
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
 				    <li><a href="logout.php?logout=true">LogOut</a></li>
						<li><a href="mainpage.php">MAIN</a></li>
						<li><a href="edit.php">수정</a></li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div class="leftBox">
						<span>저자/작명 부분</span>
						<form>
						<button class="btn" name="calendarBtn" id="calendar"><a>달력</a></button>
						<button class="btn" name="subscriptionBtn" id="calendar"><a>구독 글</a></button>
						<div></div>
					</form>
						<?php

							$stmt=$user->get_soje($_SESSION['id']);
							for($i=0;$i<$stmt->rowCount();$i++)
							{
								$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
								if($userRow['soje']!=NULL){

									print "<button class='btn' onclick=\"location.href='post_list.php?soje=".$userRow['soje']."'\" >";
									echo $userRow['soje'];
									print '</button>';
							   }
							}
						?>
						<button class="btn" id="addCat"><a  href="addsoje.php" >추가</a></button>
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
