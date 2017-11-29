<?php
require_once 'session.php';
require_once 'user.php';
$user = new USER();

$stmt=$user->runQuery("SELECT * FROM posts WHERE id=:id");
$stmt->execute(array(':id'=>$_GET['id']));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>

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
							<select name="soje" onchange="this.form.elements['save'].click();" >
								 <?php
										$soje_stmt=$user->get_soje($_SESSION['id']);
										for($i=0;$i<$soje_stmt->rowCount();$i++)
										{
											 $soje_row = $soje_stmt->fetch(PDO::FETCH_ASSOC);?>

											 <option value = <?php $soje_row['soje'] ?>  > <?php echo $soje_row['category']." | ".$soje_row['soje'] ?> </option>;
											 <?php
										}
								 ?>

							</select>
						</li>
						<div id="content"><span>글 내용</span></div>
						<div id="textarea"><textarea name="content" placeholder="글 내용을 입력하세요."></textarea></div>
					</ul>
					<p>
						<button class="btn" name="save" id="">글 올리기</button>
						<button class="btn" name="cancel" id="">취소</button>
					</p>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
