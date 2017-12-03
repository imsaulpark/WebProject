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
</head>
	<body>
		<div class="bodyInbox">
			<div class="header text-center lead">
				<h1>회원가입</h1>
			</div>
			<div class="content">
				<form class="form-horizontal" method="post">

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
            <div class="form-group">
                <label for="id" class=" control-label col-xs-5">ID</label>
                <div class=" col-xs-2" >
                  <input class="form-control" type="text" name="id" >
                </div>
            </div>
            <div class="form-group">
                <label for="pw" class="col-xs-offset-4 control-label col-xs-1">Password</label>
                <div class="col-xs-2">
                  <input class="form-control" type="password" name="pw2" >
                </div>
            </div>
            <div class="form-group">
                <label for="pw2" class="col-xs-offset-4 control-label col-xs-1">Password-Check</label>
                <div class="col-xs-2">
                  <input class="form-control" type="password" name="pw2" >
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-xs-offset-4 control-label col-xs-1">Name</label>
                <div class=" col-xs-2" >
                  <input class="form-control" type="text" name="name" >
                </div>
            </div>
            <div class="form-group">
                <label for="nickname" class="col-xs-offset-4 control-label col-xs-1">Nick Name</label>
                <div class=" col-xs-2" >
                  <input class="form-control" type="text" name="nickname" >
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-offset-4 control-label col-xs-1">TEL</label>
                <div class=" col-xs-2" >
                  <input class="form-control" type="tel" name="phone" >
                </div>
            </div>
            <div class="form-group">
                <label for="intro" class="col-xs-offset-4 control-label col-xs-1">Introduction</label>
                <div class=" col-xs-2" >
                  <input class="form-control" type="text" name="book_intro" >
                </div>
            </div>
            <div class="col-xs-12 text-center">
              <button type="submit" name="joinBtn" class="btn btn-primary btn-sm">SIGN UP</button>
              <button type="cancel" name="cancelBtn" class="btn btn-danger btn-sm">CANCEL</button>
            </div>
					</ul>
					<p>
					</p>
				</form>
			</div>
		</div>
		<script type="text/javascript" src="../js/index.js"></script>
	</body>
</html>
