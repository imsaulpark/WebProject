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

   $user->edit_post($_GET['id'],$_SESSION['id'],$user->get_category($_SESSION['id'],$_POST['soje']),$_POST['soje'],$_POST['title'],$_POST['content']);
	 $user->redirect('post_list.php?day='.date("j", strtotime($userRow['timestamp'])));
}

if(isset($_POST['uploadBtn']))
{

   $user->write_post($_SESSION['id'],$user->get_category($_SESSION['id'],$_POST['soje']),$_POST['soje'],$_POST['title'],$_POST['content']);
	 $user->redirect('post_list.php?day='.date("j", strtotime("now")));
}


?>
<script>
function goBack() {
    window.history.go(-2);
}
</script>

<!doctype html>
<meta charset="utf-8">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/write.css">
	</head>
	<body>
		<div class="bodyInbox">
			<div class="header">
				<h1>글 쓰는 중...</h1>
			</div>

			<div class="content">
				<form method="post">
					<ul>
						<li><span>글 제목</span>
							<?php
								print '<input name="title" type="text" value="'.$userRow['title'].'" placeholder="글 제목을 입력하세요."> </li> '
							?>
						<li><span>카테고리 | 소제</span>
							<select name="soje" >
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
										}
								 ?>
							</select>
						</li>
						<div id="content"><span>글 내용</span></div>

						<div id="textarea"><textarea name="content"  placeholder="글 내용을 입력하세요."> <?php echo $userRow['content'] ?></textarea></div>
					</ul>
					<p>
						<?php
							 if(isset($_GET['id']))
							 {
									print '<button class="btn" name="editBtn" id="">수정하기</button>';

							 }else{
									print '<button class="btn" name="uploadBtn" id="">글 올리기</button>';
							 }
						?>
						<button class="btn" name="cancelBtn" a href="#" onclick="history.go(-1); return false id="">취소</button>
					</p>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
