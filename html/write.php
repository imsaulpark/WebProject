<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

// 만약 글 수정이라면 get id를 받아오며 원래 글의 정보를
// 만약 글 수정이 아니라면 빈칸으로 남겨 놓는다.
if(isset($_GET['id']))
{
	$stmt=$user->runQuery("SELECT * FROM posts WHERE id=:id");
	$stmt->execute(array(':id'=>$_GET['id']));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
}else {
	$userRow['title']="";
	$userRow['content']="";
	$userRow['soje']="";
	$userRow['category']="";
	$userRow['title']="";
}

//수정버튼이 눌리면 글을 수정한다.
//내용물은 엔터키가 제대로 적용이 안되므로 \r\n을 <br>로 고친다
if(isset($_POST['editBtn']))
{
	$_POST['content']= preg_replace("/\r\n/","<br>",$_POST['content']);
	$user->edit_post($_GET['id'],$_SESSION['id'],$user->get_category($_SESSION['id'],$_POST['soje']),$_POST['soje'],$_POST['title'],$_POST['content']);
	if($_SESSION['state']=='date')
	{
   $user->redirect('post_list.php?day='.date("j", strtotime($userRow['timestamp'])));
 }
 else if($_SESSION['state']=='category')
 {
	 $user->redirect('post_list.php?category='.$user->get_category($_SESSION['id'],$_POST['soje']));
 }
 else if($_SESSION['state']=='soje')
 {
	$user->redirect('post_list.php?soje='.$_POST['soje']);
 }
}

//글 수정이 아니라 글 추가인 경우이며 이 때도 마찬가지로 엔터키 수정.
if(isset($_POST['uploadBtn']))
{
	$_POST['content']= preg_replace("/\r\n/","<br>",$_POST['content']);
	$user->write_post($_SESSION['id'],$user->get_category($_SESSION['id'],$_POST['soje']),$_POST['soje'],$_POST['title'],$_POST['content']);
	if($_SESSION['state']=='date')
	{
   $user->redirect('post_list.php?day='.date("j", strtotime("now")));
 	}
 else if($_SESSION['state']=='category')
 	{
	 $user->redirect('post_list.php?category='.$user->get_category($_SESSION['id'],$_POST['soje']));
 	}
 else if($_SESSION['state']=='soje')
 	{
		$user->redirect('post_list.php?soje='.$_POST['soje']);
 	}
}


?>
<!-- 페이지 뒤로가기 기능  -->
<script>
function goBack()
  {
		<?php 	// $user->write_post($_SESSION['id'],$user->get_category($_SESSION['id'],$_POST['soje']),$_POST['soje'],$_POST['title'],$_POST['content']);
			 ?>
  window.history.back()
  }

// textarea 크기를 자동으로 늘어나게.
function resize(obj) {
obj.style.height = "1px";
obj.style.height = (12+obj.scrollHeight)+"px";
}

</script>


<!doctype html>
<meta charset="utf-8">
<html>
	<head>
		<!-- 부트스트랩 임포트 -->
		<link rel="stylesheet" type="text/css" href="../css/write.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
				<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<!-- mobile reaction-->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<style>
			@import url(http://fonts.googleapis.com/earlyaccess/kopubbatang.css);
			@import url(http://fonts.googleapis.com/earlyaccess/hanna.css);
			@import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);
			.service{
			  padding-right: 2em;
			  padding-top: 1em;
			}

			*{
			  font-family: 'Jeju Gothic', serif;
			  font-size:1.2em;
			}

			.form-control{
			  border-style: hidden;
			  box-shadow: none;

			}

			.title{
			  font-family: 'Hanna', serif;
			  font-size: 1.6em;
			  height:180;
			}

			textarea.autosize
			{
			min-height: 50px;
			max-height:500px;
			}
		</style>
	</head>
	<body>

		<div class="contatiner main text-center">

			<!-- 우측 상단의 메뉴바 -->
			<div class="row text-right service">
			 <a class= "btn btn-default" href="mypage.php">MY</a>
			 <a class= "btn btn-default"  href="mainpage.php">MAIN</a>
			 <a class= "btn btn-default" href="logout.php?logout=true">LogOut</a>
			</div>
				 <br><br>
				 <!-- 글 제목 -->
				 <form method="post" class="content">
					 <div class="form-group">
						 <div class="col-xs-offset-4 col-xs-4">
						 <?php
									print '<textarea class= "title form-control" row="2" cols="15" name="title" placeholder="글 제목을 입력하세요.">'.$userRow["title"].'</textarea>';
							?>

						</div>
					<div class="row">
						<br><br>
					</div>
					<br>
					<!-- 수정하기라면 기존 글에 있던 정보를 불러옴. -->
					<div class="form-group">
						<div class="col-xs-offset-4 col-xs-4">
							<select class="form-control" name="soje" >
								 <?php
										$soje_stmt=$user->get_soje($_SESSION['id']);
										$is_selected="";
										for($i=0;$i<$soje_stmt->rowCount();$i++)
										{
											 $soje_row = $soje_stmt->fetch(PDO::FETCH_ASSOC);?>
											 <?php// echo "<script>alert($userRow['soje']);</script>"; ?>
											 <?php if(!strcmp($userRow['soje'],$soje_row['soje'])) $is_selected="selected"; ?>
											 <option <?php echo $is_selected; ?> value = <?php echo $soje_row['soje'] ?>  > <?php echo $soje_row['category']." | ".$soje_row['soje'] ?> </option>;
											 <?php
											 $is_selected="";
										}
								 ?>
							</select>
					 </div>
				 </div>
<br>
					<!-- 내용물 가져오기 <br>은 다시 \r\n으로 바꿔준다. -->
					 <div class="form-group">
						 <div class="col-xs-offset-4 col-xs-4">
							 <textarea class ="form-control autosize" onkeydown="resize(this)" onkeyup="resize(this)" name="content"  placeholder="글 내용을 입력하세요."><?php
 	          			$userRow['content']= preg_replace("/<br>/","\r\n",$userRow['content']);
 									echo $userRow['content']
 								?></textarea>
						</div>
					</div>
					<br><br>
					<div class="form-group">
						<div class="col-xs-offset-4 col-xs-4">
							<br>
					<!-- 글 수정인지 글 쓰기인지에 따라 수정하기버튼 혹은 글 올리기 버튼. -->
					<?php
						 if(isset($_GET['id']))
						 {
								print '<button class="btn btn-primary" name="editBtn" id="">수정하기</button>';

						 }else{
								print '<button class="btn btn-primary" name="uploadBtn" id="">글올리기</button>';
						 }
					?>
					<input type="button" class="btn btn-danger" value="취소" onclick="history.back()">
				</div>
			</div>
				</form>
	</body>
</html>
