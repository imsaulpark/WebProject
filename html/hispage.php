<?php


	require_once 'session.php';
	require_once 'user.php';
	$user = new USER();
	$id = $_GET['id'];

	$last_day = $_SESSION['last_day']; //총 날짜 수
	$start_day = $_SESSION['start_day']; //시작 요일
	$total_week = $_SESSION['total_week']; //총 몇주
	$last_week = $_SESSION['last_week']; //마지막주 끝나는 요일
	$this_mon = $_SESSION['this_mon']; //이번달
	$this_year = $_SESSION['this_year']; //이번년


	$_SESSION['state']='soje';

//로그인되어있지 않다면 login 페이지로
	if(!$user->is_loggedin())
	{
		$user->redirect('index.php');
	}

//해당페이지의 유저아이디와 내 아이디가 같다면 hispage가 아닌 mypage로 이동
	if($_GET['id'] == $_SESSION['id'])
		$user->redirect('mypage.php');

		function changeDate($user){

			$_SESSION['last_day']=date("t",strtotime("now ".$_SESSION['count']." month"));
		  $_SESSION['start_day']=date("w", strtotime(date("Y-m",strtotime("now".$_SESSION['count']."month") )."-01"));
		  $_SESSION['total_week'] =ceil(($_SESSION['last_day']+$_SESSION['start_day'])/7);
		  $_SESSION['last_week']=date("w",strtotime(date("Y-m",strtotime("now".$_SESSION['count']." month") )."-".$_SESSION['last_day'] ));
			$_SESSION['this_year'] = date("Y",strtotime("now ".$_SESSION['count']." month"));
		  $_SESSION['this_mon']= date("m",strtotime("now ".$_SESSION['count']." month"));

			$user->redirect('hispage.php?id='.$_GET['id']);
		}


		//달력 이전 버튼 클릭시
		if(isset($_POST['prevBtn']))
		{

			$_SESSION['count']--;
			changeDate($user);

		}
		//달력 다음 버튼 클릭시
		if(isset($_POST['nextBtn']))
		{

			$_SESSION['count']++;
			changeDate($user);

		}

	//구독 버튼 클릭시 해당 유저를 구독자 목록에 추가
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
		<!-- 부트스트랩 추가 -->
		<link rel="stylesheet" type="text/css" href="../css/hispage.css?ver=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
				<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<!-- mobile reaction-->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- 글씨체 추가 -->
		<style>

			@import url(http://fonts.googleapis.com/earlyaccess/kopubbatang.css);
			@import url(http://fonts.googleapis.com/earlyaccess/hanna.css);
			@import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);

		</style>

	</head>

		<body>
			<div class="contatiner main text-center">

					<!-- 유저의 정보 -->
					 <div class="row text-right service">
						<a class= "btn btn-default serviceBtn" href="mypage.php">MY</a>
						<a class= "btn btn-default serviceBtn"  href="mainpage.php">MAIN</a>
						<a class= "btn btn-default serviceBtn"  href="hispage.php?id=<?php echo $id ?>&subscription=true">SUBSCRIBE</a>
						<a class= "btn btn-default serviceBtn" href="logout.php?logout=true">LogOut</a>
					 </div>

					 <div class="row text-left">
	           <div class="col-xs-offset-4 col-xs-2">
	             <h1><?php echo $id; ?></h1>
	           </div>
	        </div>


				 <div class="row text-left">
						<div class="col-xs-offset-4 col-xs-4">
							<p class="p2">구독자 <?php echo $user->get_num_subscriber($id) ?> | 글 <?php echo $user->get_num_post($id) ?></p>
						</div>
				 </div>


	 			 <div class="row text-left">
	 					<div class="col-xs-offset-4 col-xs-4">
	 						<p class="p2"><?php echo $user->get_intro($id) ?> </p>
	 					</div>
	 			 </div>

				 <!-- 소제 목록 -->
				 <div class="row text-left soje">
	 					<div class="col-xs-offset-4 col-xs-4">
							<?php

								$stmt=$user->get_soje($id);
								for($i=0;$i<$stmt->rowCount();$i++)
								{
									$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
									if($userRow['soje']!=NULL){

										print "<button class='btn' onclick=\"location.href='post_list.php?state=soje&soje=".$userRow['soje']."'\" >";
										echo $userRow['soje'];
										print '</button>';
								   }
								}
							?>
	 					</div>
	 			 </div>
				</div>

				<br><br>

				<!-- 달력에 포스트 정보 출력 -->
				<div class="container">
					<div class="row">
						<div class="col-xs-push-2 col-xs-8">
				<table class="table table-bordered">
					 <tr>
								<td height="50" align="center" bgcolor="#FFFFFF" colspan="7">
									<form method="post">
										<button class="btn" name="prevBtn" id="calendar"><a><</a></button>
										<?php echo $_SESSION['this_year']."년 ".$_SESSION['this_mon']."월" ?>
									 <button class="btn" name="nextBtn" id="calendar"><a>></a></button>
									</form>
								</td>
						</tr>
					<tr>
								<td height="30" align="center" bgcolor="#DDDDDDD">일</td>
								<td align="center" bgcolor="#DDDDDDD">월</td>
								<td align="center" bgcolor="#DDDDDDD">화</td>
								<td align="center" bgcolor="#DDDDDDD">수</td>
								<td align="center" bgcolor="#DDDDDDD">목</td>
								<td align="center" bgcolor="#DDDDDDD">금</td>
								<td align="center" bgcolor="#DDDDDDD">토</td>
						</tr>

		<?php

		$day=1;
		// 6. 총 주 수에 맞춰서 세로줄 만들기
		for($i=1; $i <= $total_week; $i++){?>

				<tr>
				<?php
				// 7. 총 가로칸 만들기
				for ($j=0; $j<7; $j++){
				?>
				<td width="80" height="80" align="center" bgcolor="#FFFFFF">
				<?php
				// 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않아야하므로
				//    그 반대의 경우 -  ! 으로 표현 - 에만 날자를 표시한다.
				if (!(($i == 1 && $j < $start_day) || ($i == $total_week && $j > $last_week))){

						if($j == 0){
								// 9. $j가 0이면 일요일이므로 빨간색
							 print "<font color='#FF0000'>";
						}else if($j == 6){
								// 10. $j가 0이면 일요일이므로 파란색
								print "<font color='#0000FF'>";
						}else{
								// 11. 그외는 평일이므로 검정색
								echo "<font color='#000000'>";
						}

						// 12. 오늘 날짜면 굵은 글씨
						if($day == date("j")){
								print "<b>";
						}

						// 13. 날짜 출력
						echo $day;
						print "<br>";
						$stmt=$user->runQuery("SELECT * FROM posts WHERE extract(YEAR_MONTH FROM timestamp)=:yearmonth AND extract(DAY FROM timestamp)=:day AND memberID=:id");
						$stmt->execute(array(':yearmonth'=>$this_year.$this_mon,':day'=>$day,':id'=>$id));
						if($stmt->rowCount()!=0){
							print "<a href='./post_list.php?state=date&id=".$id."&day=".$day."'>";
							echo $stmt->rowCount()."posts";
							print "</a>";
						}
						else {
							print "<br>";
						}

						if($day == date("j")){
								print "</b>";
						}

						print "</font>";


						$day++;
				}
				?>
				</td>
				<?php } ?>
				</tr>
		<?php } ?>
			 </table>
		 </div>
		 </div>
		 </div>

		</body>
</html>
