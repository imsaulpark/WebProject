<?php

        session_start();
        require_once('user.php');
        $user = new USER();


        if($user->is_loggedin()!="")
        {
                $user->redirect('mypage.php');
        }

        if(isset($_POST['joinBtn']))
        {
                $id = trim($_POST['id']);       //trim : remove blanks at the begin and end.
                $pw = trim($_POST['pw']);
                $pw2 = trim($_POST['pw2']);
                $phone = trim($_POST['phone']);
                $name = trim($_POST['name']);
                $nickname = trim($_POST['nickname']);
                $intro = trim($_POST['intro']);

                $phone = preg_replace("/[^0-9]/", "", $phone);





                if($id ==""){
                        $error[] = "provide ID !";
                }
                else if(strlen($id)<4 || strlen($id)>12){
                        $error[] = "ID must be 4 ~ 12 characters.";
                }
                else if($pw ==""){
                        $error[] = "provide password !";
                }
                else if(strlen($pw)<4 || strlen($pw)>12){
                        $error[] = "Password must be 4 ~ 12 characters.";
                }
                else if(strcmp($pw, $pw2)){
                        $error[] = "Password and password-check is not matching each other.";
                }
                else if($name ==""){
                        $error[] = "provide name !";
                }
                else if(strlen($name)<2 || strlen($name)>20){
                        $error[] = "Name must be 2 ~ 20 characters.";
                }
                else if($nickname ==""){
                        $error[] = "provide nickname !";
                }
                else if(strlen($nickname)<2 || strlen($nickname)>20){
                        $error[] = "Password must be 2 ~ 20 characters.";
                }

                else if($phone ==""){
                        $error[] = "provide phone number !";
                }

                else if(!preg_match("/^01[0-9]{8,9}$/",$phone)){
                        $error[] = "Invalid phone number (Must type without '-')";
                }
 	        else{
			try
                        {
                                $stmt = $user->runQuery("SELECT id FROM members WHERE id=:id");
                                $stmt->execute(array(':id'=>$id));
                                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                                if($stmt->rowCount() > 0)
                                {
                                        $error[] = "Sorry, ID is already taken by other person";
                                }
                                else
                                {

                                        if($user->register($id,$pw,$phone,$name,$nickname,$intro))
                                        {
                                                $user->redirect('join.php?joined');
                                        }
                                }

                        }
                        catch(PDOException $e)
                        {
                                echo $e->getMessage();
                        }
                }
        }

?>


<!doctype html>
<meta charset="utf-8">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/join.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
</head>
	<body>
		<div class="bodyInbox">
			<div class="header">
				<h1>회원가입</h1>
			</div>
			<div class="content">
				<form class="joinForm" method="post">

                                <?php
                                if(isset($error))
                                {
                                        foreach($error as $error)
                                        {
                                                ?>
                                                <div class="alert alert-danger">
                                                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                                                </div>
                                                <?php
                                        }
                                }
                                else if(isset($_GET['joined']))
                                {
                                        ?>
                                        <div class="alert alert-info">                                        <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                                        </div>
                                        <?php
                                }
                                ?>


					<ul>
						<li><span>ID</span><input name="id" type="text" text=""> </li>
						<li><span>PW</span><input name="pw" type="password" text=""> </li>
						<li><span>PW확인</span><input name="pw2" type="password" text=""> </li>
						<li><span>저자(이름)</span><input name="name" type="text" text=""> </li>
						<li><span>작명(닉네임)</span><input name="nickname" type="text" text=""> </li>
						<li><span>핸드폰번호</span><input name="phone" type="text" text=""> </li>
						<div id="book_intro"><span>책소개</span></div><div id="textarea"><textarea></textarea name="book_intro"></div>
					</ul>
					<p>
						<button type="submit" name="joinBtn" class="bottomBtn"><i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP</button>

						<button type="cancel" name="cancelBtn" class="bottomBtn"><i class="glyphicon glyphicon-open-file"></i>CANCEL</button>
					</p>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
