<?php

require_once 'session.php';
require_once 'user.php';
$user = new USER();


if(isset($_GET['writer']))
{
  $user->delete_subscriber($_SESSION['id'],$_GET['writer']);
}

$stmt=$user->runQuery("SELECT * FROM members WHERE id=:id");
$stmt->execute(array(':id'=>$_SESSION['id']));
$member=$stmt->fetch(PDO::FETCH_ASSOC);

$stmt= $user->runQuery("SELECT * FROM subscription WHERE subscriber=:subscriber");
$stmt->execute(array(':subscriber'=>$member['id']));

$tel = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $member['phone']);

if(isset($_POST['signoutBtn']))
{
  $pw = $_POST['pw'];

  $stmt = $user->runQuery("SELECT * FROM members WHERE id=:id LIMIT 1");
  $stmt->execute(array(':id'=>$_SESSION['id']));
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  if(password_verify($pw, $userRow['pw']))
  {
    $user->sign_out($_SESSION['id']);
    $user->redirect('logout.php?logout=true');
  }
  else {
      $error[] = "Input correct password.";
  }


}

if(isset($_POST['editBtn']))
{
        $pw = trim($_POST['pw']);    //trim : remove blanks at the begin and end.
        $pw2 = trim($_POST['pw2']);
        $phone = trim($_POST['phone']);
        $name = trim($_POST['name']);
        $nickname = trim($_POST['nickname']);
        $intro = trim($_POST['intro']);

        $phone = preg_replace("/[^0-9]/", "", $phone);

        if($pw ==""){
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
          echo "GG";
              try
                {
                    $user->edit_profile($_SESSION['id'],$pw,$phone,$name,$nickname,$intro);
                    $user->redirect('mypage.php');
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
      <link rel="stylesheet" type="text/css" href="../css/post_list.css">
   </head>
   <body>
      <div class="header">
         <div class="btnArea">
            <u
               <li><a href="mypage.php">MY</a></li>
               <li><a href="mainpage.php">MAIN</a></li>
               <li><a href="index.html" onclick="logout()">LogOut</a></li>
            </ul>
         </div>
      </div>
      <div class="header" id="title">
         <h1>회원 정보 수정</h1>
      </div>
      <div class="bodyInbox">
         <div class="content">
           <form method="post">
            <ul>
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
              ?>

                  <li><span>저자(이름)</span><input name="name" type="text" value= <?php echo $member['name']; ?>> </li>
                  <li><span>작명(닉네임)</span><input name="nickname" type="text" value= <?php echo $member['nickname']; ?>> </li>
                  <li><span>핸드폰 번호</span><input name="phone" type="tel" value= <?php echo $tel; ?>> </li>
                  <li><span>패스워드</span><input name="pw" type="password" text=""> </li>
                  <li><span>패스워드 확인</span><input name="pw2" type="password" text=""> </li>
                  <div id="book_intro"><span>책소개</span></div><div id="textarea"><textarea name="intro"> <?php echo $member['intro']; ?> </textarea></div>


               </ul>
               <button type="submit" name="signoutBtn" id="del_ID">회원 탈퇴</button>
               <p>
                  <button type="submit" name="editBtn">수정완료</button>
                  <button type="cancel" name="cancelBtn">취소</button>
               </p>
            </form>
            <?php
              for($i=0;$i<$stmt->rowCount();$i++)
              {
                $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                print '<li><span>'.$userRow['writer'].'</span><button onclick="location.href=\'edit.php?writer='.$userRow['writer'].'\'">삭제</button> </li>';
              }
             ?>
         </div>
      </div>
      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
