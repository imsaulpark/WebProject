<?php

session_start();
require_once('user.php');
$user = new USER();

$id;

if(isset($_POST['idFindBtn']))
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


if(isset($_POST['pwFindBtn']))
{

	$id = $_POST['id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $phone = preg_replace("/[^0-9]/", "", $phone);

	$_SESSION['temp_id'] = $id;

	try
	{
        	$stmt = $user->runQuery("SELECT id FROM members WHERE id=:id and name=:name and phone=:phone ");
                $stmt->execute(array(':id'=>$id,':name'=>$name,':phone'=>$phone));
                if($stmt->rowCount()==0)
                {
                	$string = "There is no matching user.";
			            echo $string;
                }
                else
                {
			            $finding="true";
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
		 if(strlen($pw1)<4 || strlen($pw1)>12){
                        $alarm = "Password must be 4 ~ 12 characters.";
                }
                else if(strcmp($pw1, $pw2)){
                        $alarm = "Password and password-check is not matching each other.";
                }
		else{

			$pw=password_hash($pw1,PASSWORD_DEFAULT);


                        $stmt = $user->runQuery("update members set pw=:pw WHERE id=:id");
                        $stmt->execute(array(':pw'=>$pw,':id'=>$_SESSION['temp_id']));
			                  echo "<script>alert('Password is succesfully changed');</script>";
                        echo "<script>window.close();</script>";
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

            .wrap{
              margin-top: 3em;
            }

            *{
              font-family: 'Jeju Gothic', serif;
            }

            .type{

              font-size:2em;
              margin-bottom: 1em;
            }

            .btn{
              width:7em;
              margin-top : 1.5em;
            }

            </style>

	</head>
	<body>

    <div class="content wrap">
      <div class="col-xs-6">
      <form class="form-horizontal" method="post">
        <div class="type text-center">
          ID 찾기
        </div>
        <div class="form-group">
            <label for="name" class=" control-label col-xs-3">NAME</label>
            <div class=" col-xs-6" >
              <input class="form-control" type="text" name="name" >
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="control-label col-xs-3">TEL</label>
            <div class=" col-xs-6" >
              <input class="form-control" type="tel" name="phone" >
            </div>
        </div>
        <div class="col-xs-12 text-center">
          <button type="submit" name="idFindBtn" class="btn btn-primary btn-sm">FIND</button>
         <input type="button" class="btn btn-danger btn-danger btn-sm" onclick="window.close()" value="CANCEL">
        </div>
      </form>
    </div>
    <div class="col-xs-6">
      <?php
      if(!isset($finding)){
        ?>
        <div class="text-center type">
            PW 찾기
          </div>
        <form class="form-horizontal" method="post">
          <div class="form-group">
              <label for="id" class=" control-label col-xs-3">ID</label>
              <div class=" col-xs-6" >
                <input class="form-control" type="text" name="id" >
              </div>
          </div>
          <div class="form-group">
              <label for="name" class=" control-label col-xs-3">NAME</label>
              <div class=" col-xs-6" >
                <input class="form-control" type="text" name="name" >
              </div>
          </div>
          <div class="form-group">
              <label for="phone" class="control-label col-xs-3">TEL</label>
              <div class=" col-xs-6" >
                <input class="form-control" type="tel" name="phone" >
              </div>
          </div>
          <div class="col-xs-12 text-center">
            <button type="submit" name="pwFindBtn" class="btn btn-primary btn-sm">FIND</button>
         <input type="button" class="btn btn-danger btn-danger btn-sm" onclick="window.close()" value="CANCEL">
          </div>
        </form>

      <?php
    }else{
      ?>
      <div class="text-center type">
          비밀번호 변경
        </div>
      <form class="form-horizontal" method="post">
        <div class="form-group">
            <label for="name" class=" control-label col-xs-3">PASSWORD</label>
            <div class=" col-xs-6" >
              <input class="form-control" style="font-family: 'Kopub Batang'" type="password" name="pw1" >
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="control-label col-xs-3">PASSWORD CHECK</label>
            <div class=" col-xs-6" >
              <input class="form-control" style="font-family: 'Kopub Batang'" type="password" name="pw2" >
            </div>
        </div>
        <div class="col-xs-12 text-center">
          <button type="submit" name="confirm" class="btn btn-primary btn-sm">CONFIRM</button>
         <input type="button" class="btn btn-danger btn-danger btn-sm" onclick="window.close()" value="CANCEL">
        </div>
      </form>
      <?php
    }
      ?>
    </div>




		<script type="text/javascript" src="../js/find.js"></script>
	</body>
</html>
