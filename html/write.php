<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

//$prevPage = $_SERVER['HTTP_REFERER'];

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

<script>
function goBack()
  {
		<?php 	// $user->write_post($_SESSION['id'],$user->get_category($_SESSION['id'],$_POST['soje']),$_POST['soje'],$_POST['title'],$_POST['content']);
			 ?>
  window.history.back()
  }

function resize(obj) {
obj.style.height = "1px";
obj.style.height = (12+obj.scrollHeight)+"px";
}

$("textarea.autosize").on('keydown keyup', function () {
  $(this).height(1).height( $(this).prop('scrollHeight')+12 );

	document.getElementById("textarea").scrollTop = document.getElementById("textarea").scrollHeight

});

</script>


<!doctype html>
<meta charset="utf-8">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/write.css">
		<link rel="stylesheet" type="text/css" href="../css/post.css">

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

			textarea.autosize { min-height: 50px;
			max-height:500px; }


			</style>
	</head>
	<body>

		<div class="contatiner main text-center">

			<div class="row text-right service">
			 <a class= "btn btn-default" href="mypage.php">MY</a>
			 <a class= "btn btn-default"  href="mainpage.php">MAIN</a>
			 <a class= "btn btn-default" href="logout.php?logout=true">LogOut</a>
			</div>
				 <br><br>
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
					 <div class="form-group">
						 <div class="col-xs-offset-4 col-xs-4">
							 <textarea class ="form-control autosize" onkeydown="resize(this)" onkeyup="resize(this)" name="content"  placeholder="글 내용을 입력하세요."><?php
 	          			$userRow['content']= preg_replace("/<br>/","\r\n",$userRow['content']);
 									echo $userRow['content']
 								?></textarea>
						</div>
					</div>
					<br>					<br>
					<div class="form-group">
						<div class="col-xs-offset-4 col-xs-4">
					<?php
						 if(isset($_GET['id']))
						 {
								print '<button class="btn" name="editBtn" id="">수정하기</button>';

						 }else{
								print '<button class="btn" name="uploadBtn" id="">글올리기</button>';
						 }
					?>
					<input type="button" class="btn" value="취소" onclick="history.back()">
				</div>
			</div>
				</form>


		<script type="text/javascript" src="../js/write.js"></script>
	</body>
</html>
