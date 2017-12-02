<?php


	require_once 'session.php';
	require_once 'user.php';
	$user = new USER();

	$_SESSION['state']='soje';

	if(!$user->is_loggedin())
	{
		$user->redirect('index.php');
	}

	if($_GET['id'] == $_SESSION['id'])
		$user->redirect('mypage.php');

	if(isset($_GET['calendarBtn']))
	{

		$_SESSION['count']=0;
		$_SESSION['last_day'] = date("t", time()); //총 요일 수
		$_SESSION['start_day'] = date("w", strtotime(date("Y-m")."-01")); //시작 요일
		$_SESSION['total_week'] = ceil(($_SESSION['last_day'] + $_SESSION['start_day'] )/7); // 총 요일
		$_SESSION['last_week'] = date('w',strtotime(date("Y-m")."-".$_SESSION['last_day'] ));
		$_SESSION['this_mon'] = date("m",strtotime(date("Y-m",strtotime('+0 month'))));
		$_SESSION['this_year'] = date("Y",strtotime(date("Y-m",strtotime('+0 month'))));
		$user->redirect('calendar.php');
	}

  if(isset($_GET['subscription']))
  {
		$stmt=$user->runQuery("SELECT * FROM subscription WHERE subscriber=:subscriber AND writer=:writer");
		$stmt->execute(array(':subscriber'=>$_SESSION['id'],':writer'=>$_GET['id']));
		if($stmt->rowCount()<1)
			$user->add_subscriber($_SESSION['id'],$_GET['id']);
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
              <li><a href="mypage.php">MY</a></li>
              <li><a href="mainpage.php">MAIN</a></li>
                 <li><a href="logout.php?logout=true">LogOut</a></li>
           </ul>
        </div>
			</div>
			<div class="content">
				<div class="leftBox">
						<span>저자/작명 부분</span>
            <?php
            print "<button class='btn' onclick=\"location.href='hispage.php?subscription=true&id=".$_GET['id']."'\" >";
            echo "구독하기";
            print '</button>';

             ?>
						<form>
						<!--<button class="btn" name="calendarBtn" id="calendar"><a>달력</a></button> -->

						<div></div>
					</form>
						<?php

							$stmt=$user->get_soje($_GET['id']);
							for($i=0;$i<$stmt->rowCount();$i++)
							{
								$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
								if($userRow['soje']!=NULL){

									print "<button class='btn' onclick=\"location.href='post_list.php?soje=".$userRow['soje']."&id=".$_GET['id']."'\" >";
									echo $userRow['soje'];
									print '</button>';
							   }
							}
						?>
						<button class="btn" id="addCat"><a  href="addsoje.php" >추가</a></button>
				</div>
				<div class="rightBox">
					<p class="p1">책소개가<br/>들어가는 부분!</p>
					<p class="p2">구독자 수 <?php echo $user->get_num_subscriber($_GET['id']) ?>명<br/>작성글 수 <?php echo $user->get_num_post($_GET['id']) ?>개</p>

				</div>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
