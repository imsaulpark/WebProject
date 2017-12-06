<?php

        session_start();
        require_once('user.php');
        $user = new USER();

        //로그인되어있다면 마이페이지로 이동
        if($user->is_loggedin()!="")
        {
                $user->redirect('mypage.php');
        }

        // 회원가입 버튼이 눌리면
        if(isset($_POST['joinBtn']))
        {
                $id = trim($_POST['id']);       //trim : remove blanks at the begin and end.
                $pw = trim($_POST['pw']);
                $pw2 = trim($_POST['pw2']);
                $phone = trim($_POST['phone']);
                $name = trim($_POST['name']);
                $nickname = trim($_POST['nickname']);
                $intro = trim($_POST['intro']);

                //핸드폰의 경우에는 '-'를 제거
                $phone = preg_replace("/[^0-9]/", "", $phone);




                //입력형식 맞는지 확인
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
                //핸드폰의 경우 핸드폰 형식 맞는지 확인
                else if(!preg_match("/^01[0-9]{8,9}$/",$phone)){
                        $error[] = "Invalid phone number (Must type without '-')";
                }
 	        else{
                    //입력 형식이 맞다면 id중복이 아니라면 회원 가입 성공
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

<script>

//introduction을 넣는 textarea 크기 자동으로 커지도록
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
    <link rel="stylesheet" type="text/css" href="../css/join.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- mobile reaction-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- 글씨체 임포트 -->
    <style>

			@import url(http://fonts.googleapis.com/earlyaccess/kopubbatang.css);
			@import url(http://fonts.googleapis.com/earlyaccess/hanna.css);
			@import url(http://fonts.googleapis.com/earlyaccess/jejugothic.css);

		</style>

</head>
	<body>
		<div class="bodyInbox">
			<div class="header text-center lead">
				<h1>회원가입</h1>
			</div>
			<div class="content">
				<form class="form-horizontal" method="post">
          <div class="text-center">
              <!-- 오류메세지 출력 -->
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
                      <div class="alert alert-info"><i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                      </div>
                      <?php
              }
              ?>
           </div>
					<ul>
            <!-- 회원가입 input form  -->
            <div class="form-group">
                <label for="id" class=" control-label col-xs-5">ID</label>
                <div class=" col-xs-2" >
                  <input class="form-control" type="text" name="id" >
                </div>
            </div>
            <div class="form-group">
                <label for="pw" class="col-xs-offset-4 control-label col-xs-1">Password</label>
                <div class="col-xs-2">
                  <input class="form-control" style="font-family: 'Kopub Batang'" type="password" name="pw" >
                </div>
            </div>
            <div class="form-group">
                <label for="pw2" class="col-xs-offset-4 control-label col-xs-1">Password-Check</label>
                <div class="col-xs-2">
                  <input class="form-control" style="font-family: 'Kopub Batang'" type="password" name="pw2" >
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
                  <textarea class ="form-control autosize" onkeydown="resize(this)" onkeyup="resize(this)" name="intro"></textarea>
                </div>
            </div>
            <div class="col-xs-12 text-center">
              <button type="submit" name="joinBtn" class="btn btn-primary btn-sm">SIGN UP</button>
         <input type="button" class="btn btn2 btn-danger btn-sm" onclick="history.back()" value="CA">
            </div>
					</ul>
					<p>
					</p>
				</form>
			</div>
		</div>
	</body>
</html>
