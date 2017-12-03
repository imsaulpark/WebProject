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
				font-size: 2em;
				height:160;
			}

			</style>
	</head>
	<body>

		<div class="contatiner main text-center">

				 <div class="row text-right service">
							 <a class= "btn btn-default serviceBtn" href="mypage.php">MY</a>
							<a class= "btn btn-default serviceBtn"  href="mainpage.php">MAIN</a>
							 <a class= "btn btn-default serviceBtn"  href="index.html" onclick="logout()">LogOut</a>

				 </div>
				 <br><br>
				 <form method="post" class="content">
					 <div class="form-group">
						 <div class="col-xs-offset-4 col-xs-4">
						 <?php
								print '<input class=" title" rows="2" cols="10" name="title" type="textarea" value="'.$userRow['title'].'" placeholder="글 제목을 입력하세요.">  '
							?>
							<textarea rows="4" cols="50">
At w3schools.com you will learn how to make a website. We offer free tutorials in all web development technologies.
</textarea>

						</div>
					</div>

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

					 <div class="form-group">
						 <div class="col-xs-offset-4 col-xs-4">
							 <textarea class ="form-control" name="content"  placeholder="글 내용을 입력하세요.">
 								<?php
 	          			$userRow['content']= preg_replace("/<br>/","\r\n",$userRow['content']);
 									echo $userRow['content']
 								?>
 							</textarea>
						</div>
					</div>

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


		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
