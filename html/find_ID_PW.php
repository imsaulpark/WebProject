<?php

session_start();
require_once('user.php');
$user = new USER();

$id;

if(isset($_POST['find_id']))
{

        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $phone = preg_replace("/[^0-9]/", "", $phone);

	try
	{
		$stmt = $user->runQuery("SELECT id FROM members WHERE name=:name and phone=:phone ");
                $stmt->execute(array(':name'=>$name,':phone'=>$phone));
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount()==0)
              	{
                	$string = "There is no matching user.";
			echo $string;
              	}
                else
                {
			$string="Your Id is".$row['id'];
			echo $string;
                }
	}
        catch(PDOException $e)
        {
        echo $e->getMessage();
        }


}


if(isset($_POST['find_pw']))
{

	$id = $_POST['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $phone = preg_replace("/[^0-9]/", "", $phone);

	$_SESSION['temp_id'] = $id;

	try
	{
		echo $phone;
        	$stmt = $user->runQuery("SELECT id FROM members WHERE id=:id and name=:name and phone=:phone ");
                $stmt->execute(array(':id'=>$id,':name'=>$name,':phone'=>$phone));
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount()==0)
                {
                	$string = "There is no matching user.";
			echo $string;
                }
                else
                {
			$finding="true";
			//$user->redirect("find_ID_PW.php?findPW");
                }
         }
         catch(PDOException $e)
         {
         	echo $e->getMessage();
         }

}


if(isset($_POST['confirm']))
{

	$pw1 = $_POST['pw1'];
        $pw2 = $_POST['pw2'];
	try
	{
		echo $_SESSION['temp_id'];
		 if(strlen($pw1)<4 || strlen($pw1)>12){
                        $alarm = "Password must be 4 ~ 12 characters.";
                }
                else if(strcmp($pw1, $pw2)){
                        $alarm = "Password and password-check is not matching each other.";
                }
		else{

			$pw=password_hash($pw1,PASSWORD_DEFAULT);


                        $stmt = $DB_con->prepare("update members set pw=:pw WHERE id=:id");
                        $stmt->execute(array(':pw'=>$pw,':id'=>$_SESSION['temp_id']));
			$alarm="Password is successfully changed";
               	}
	}
          catch(PDOException $e)
          {
          	echo $e->getMessage();
          }

}



?>

<!doctype html>
<meta charset="utf-8">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/find_ID_PW.css">
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
			<div class="header">
			</div>
			<div class="content">
				<div class="leftBox">
					<form class="input" method="post">
						<ul>
							<li><span>이름</span><input name="name" type="text" text=""> </li>
							<li><span>핸드폰번호</span><input name="phone" type="tel" text=""> </li>
						</ul>
					<p><button class="find" id="find_id" name="find_id"><a>아이디찾기</a></button></p>
					</form>
				</div>
				<div class="rightBox">
					<form class="input", method="post">
						<ul>
							<li><span>ID</span><input name="id" type="text" text=""> </li>
							<li><span>이름</span><input name="name" type="text" text=""> </li>
							<li><span>핸드폰번호</span><input name="phone" type="tel" text=""> </li>
						</ul>
						<p><span><button class="find" name="find_pw"><a>비밀번호 찾기</a></button></span></p>
					</form>

					<?php
					if(isset($finding)){
						echo("<script>location.href='./newPW.php';</script>");
						?>


					<?php
					}

					if(isset($alarm))
                                	{

					echo $alarm;

                                	} ?>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="../js/find.js"></script>
	</body>
</html>
