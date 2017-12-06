<?php

require_once 'session.php';
require_once 'user.php';
$user = new USER();

// 구독자 삭제버튼 클릭시
if(isset($_GET['writer']))
{
  $user->delete_subscriber($_SESSION['id'],$_GET['writer']);
}

//소제 삭제 버튼 클릭시.
if(isset($_POST['keyDeleteBtn0']))
{
  $user->delete_soje($_SESSION['id'],$_POST['category'][0],$_POST['soje'][0]);
}

if(isset($_POST['keyDeleteBtn1']))
{
  $user->delete_soje($_SESSION['id'],$_POST['category'][1],$_POST['soje'][1]);
}

if(isset($_POST['keyDeleteBtn2']))
{
  $user->delete_soje($_SESSION['id'],$_POST['category'][2],$_POST['soje'][2]);
}

if(isset($_POST['keyDeleteBtn3']))
{
  $user->delete_soje($_SESSION['id'],$_POST['category'][3],$_POST['soje'][3]);
}

if(isset($_POST['keyDeleteBtn4']))
{
  $user->delete_soje($_SESSION['id'],$_POST['category'][4],$_POST['soje'][4]);
}

if(isset($_POST['keyDeleteBtn5']))
{
  $user->delete_soje($_SESSION['id'],$_POST['category'][5],$_POST['soje'][5]);
}

//소제 수정 버튼 클릭시
if(isset($_POST['sojeEditBtn']))
{
  $size = count($_POST['category']);
  $user->delete_all_soje($_SESSION['id']);
  if(strlen(trim($_POST['soje'][$size-1]))!=0)
    $max=$size;
  else {
      $max=$size-1;
  }
  for($i=0;$i<$max;$i++)
  {
    $user->add_soje($_SESSION['id'],$_POST['category'][$i],$_POST['soje'][$i]);
  }
}

//소제 카테고리 추가 버튼 클릭시
if(isset($_POST['keyAddBtn']))
{
  $size = count($_POST['category']);
  $user->add_soje($_SESSION['id'],$_POST['category'][$size-1],$_POST['soje'][$size-1]);
}


//해당 유저의 정보 가져오기
$stmt=$user->runQuery("SELECT * FROM members WHERE id=:id");
$stmt->execute(array(':id'=>$_SESSION['id']));
$member=$stmt->fetch(PDO::FETCH_ASSOC);
//전화번호에 - 넣기
$tel = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $member['phone']);

$stmt= $user->runQuery("SELECT * FROM subscription WHERE subscriber=:subscriber");
$stmt->execute(array(':subscriber'=>$member['id']));

//회원탈퇴 버튼 눌렸을 시
if(isset($_GET['signout']))
{
  $pw = $_POST['pw'];

  $stmt = $user->runQuery("SELECT * FROM members WHERE id=:id LIMIT 1");
  $stmt->execute(array(':id'=>$_SESSION['id']));
  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

  echo $pw;
//비밀번호 맞는지 확인
  if(password_verify($pw, $userRow['pw']))
  {
    $user->sign_out($_SESSION['id']);
    //$user->redirect('logout.php?logout=true');
  }
  else {
      $error[] = "Input correct password.";
  }


}

//프로필 수정 완료 버튼 눌렸을 때
if(isset($_POST['editBtn']))
{
        $pw = trim($_POST['pw']);    //trim : remove blanks at the begin and end.
        $pw2 = trim($_POST['pw2']);
        $phone = trim($_POST['phone']);
        $name = trim($_POST['name']);
        $nickname = trim($_POST['nickname']);
        $intro = trim($_POST['intro']);

        //전화번호의 '-' 빼기
        $phone = preg_replace("/[^0-9]/", "", $phone);

        // input value 틀렸는지 확인
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
        //핸드폰번호 입력형식 맞는지 확인
        else if(!preg_match("/^01[0-9]{8,9}$/",$phone)){
                $error[] = "Invalid phone number (Must type without '-')";
        }
        else{
              try
                {
                    //실제로 수정하고 mypage로 페이지 이동
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

     <link rel="stylesheet" type="text/css" href="../css/edit.css?ver=1">
     <!-- 부트스트랩 가져오기 -->
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


      </style>

   </head>
   <body>
     <!-- 우측상단의 메뉴버튼들 -->
     <div class="row text-right service">
      <a class= "btn btn-default serviceBtn" href="mypage.php">MY</a>
      <a class= "btn btn-default serviceBtn"  href="mainpage.php">MAIN</a>
      <a class= "btn btn-default serviceBtn" href="logout.php?logout=true">LogOut</a>
      <a class= "btn btn-default serviceBtn" href="logout.php?signout=true">SignOut</a>
     </div>
     <div class="header text-center lead">
       <h1>회원정보 수정</h1>
     </div>
     <div class="row text-center">
       <!-- 입력형식의 오류가 있을 경우 표시 -->
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
     </div>
     <!-- input form 형식을 부트스트랩으로 구현 -->
     <div class="content">
       <form class="form-horizontal" method="post">
         <div class="form-group">
             <label for="name" class="col-xs-offset-4 control-label col-xs-1">Name</label>
             <div class=" col-xs-2" >
               <input class="form-control" type="text" name="name" value= <?php echo $member['name'] ?> >
             </div>
         </div>
         <div class="form-group">
             <label for="nickname" class="col-xs-offset-4 control-label col-xs-1">Nick Name</label>
             <div class=" col-xs-2" >
               <input class="form-control" type="text" name="nickname"  value= <?php echo $member['nickname'] ?> >
             </div>
         </div>
         <div class="form-group">
             <label for="pw" class="col-xs-offset-4 control-label col-xs-1">Password</label>
             <div class="col-xs-2">
               <input class="form-control" type="password" style="font-family: 'Kopub Batang'"  name="pw" >
             </div>
         </div>
         <div class="form-group">
             <label for="pw2" class="col-xs-offset-4 control-label col-xs-1">Password-Check</label>
             <div class="col-xs-2">
               <input class="form-control" type="password" style="font-family: 'Kopub Batang'"  name="pw2" >
             </div>
         </div>
         <div class="form-group">
             <label for="phone" class="col-xs-offset-4 control-label col-xs-1">TEL</label>
             <div class=" col-xs-2" >
               <input class="form-control" type="tel" name="phone"  value= <?php echo $tel ?> >
             </div>
         </div>
         <div class="form-group">
             <label for="intro" class="col-xs-offset-4 control-label col-xs-1">INTRO</label>
             <div class=" col-xs-2" >
               <input class="form-control" type="text" name="intro" value = <?php echo $member['intro'] ?> >
             </div>
         </div>
         <br>
       <!-- 버튼 -->
       <div class="col-xs-12 text-center">
         <button type="submit" class="btn btn2 btn-primary btn-sm" name="editBtn">수정완료</button>
         <input type="button" class="btn btn2 btn-danger btn-sm" onclick="history.back()" value="취소">
      </div>
    </form>
    </div>
    <br><br><br>
    <div class="row text-center backg">
      <br><br>
      <div class="row text-center">
        <!-- 소제 관리하는 input form -->
        <h1>
          소제 관리
        </h2>
      </div>
      <br>
      <div class="content">
        <form class="form-horizontal" method="post">
          <div class="form-group">
            <!-- 현재 유저에게 등록된 소제/카테고리 목록을 가져옴 -->
            <!-- 소제 및 카테고리가 6개면 더이상 등록되지 않도록 -->
           <?php
              $soje_stmt=$user->get_soje($_SESSION['id']);
              $is_selected="";

              for($i=0;($i<6)&&($i<=$soje_stmt->rowCount());$i++)
              {
                print '<div class="col-xs-offset-4 col-xs-4 inputRow">';
                $soje_row = $soje_stmt->fetch(PDO::FETCH_ASSOC);
                $category = $user->get_category($_SESSION['id'],$soje_row['soje']);
                $categories = $user->get_all_category();
                ?>
                <div class="col-xs-5">
                  <select class="form-control" name="category[]" >
                    <?php for($j=0;$j<$categories->rowCount();$j++)
                    {
                      $category_row = $categories->fetch(PDO::FETCH_ASSOC);
                      ?>
                     <?php if(!strcmp($category_row['category'],$soje_row['category'])) $is_selected="selected"; ?>
                       <option <?php echo $is_selected; ?>  value = <?php echo $category_row['category']; ?>  > <?php echo $category_row['category']; ?> </option>;
                       <?php
                       $is_selected="";
                    }
                     ?>
                  </select>
                </div>
                <!-- 추가 및 삭제 버튼. name은 배열을 통해 접근 가능 -->
                <div class="col-xs-5">
                  <?php
                    print '<input class="form-control" name="soje[]" type="text name="soje" value=\''.$soje_row['soje'].'\'>';
                    print "</div>";
                    ?>
                <div class="col-xs-2">
                  <?php
                    if($i==$soje_stmt->rowCount())
                      print  '<button class="btn btn-primary btn-sm" name="keyAddBtn">추가</button>';
                    else {
                      print  '<button class="btn btn-danger btn-sm" name="keyDeleteBtn'.$i.'">삭제</button>';
                      }
                    print "</div>";
                  ?>
                </div>
                <?php

                }
                ?>
          </div>
          <br>
          <div class="col-xs-12 text-center">
            <button type="submit" class="btn btn2 btn-primary btn-sm" name="sojeEditBtn">수정완료</button>
            <button type="cancel" class="btn btn2 btn-danger btn-sm" name="cancelBtn">취소</button>
         </div>
         <br><br>
        </form>
       </div>
       <br><br>
   </div>

   <!-- 구독자를 확인하며 삭제할 수 있음. -->
    <div class="row text-center">
      <br><br><br>
      <div class="row text-center">
        <h1>
          구독자 관리
        </h2>
        <br>
      </div>
      <!-- 구독자들의 목록을 가져오고 삭제할 수 있음. -->
      <?php
        for($i=0;$i<$stmt->rowCount();$i++)
        {
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          print '<div class="row text-center">';
          print '<span>'.$userRow['writer'].'</span> <button class="btn btn-danger btn-sm" onclick="location.href=\'edit.php?writer='.$userRow['writer'].'\'">삭제</button>';
          print '</div>';
        }
       ?>
     </div>
   <br><br>


      <script type="text/javascript" src="../js/index.js"></script>
   </body>
</html>
