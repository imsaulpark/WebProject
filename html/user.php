<?php

	$keywords = array("keyword1", "keyword2", "keyword3", "keyword4", "keyword5", "keyword6");
	require_once('dbconfig.php');


class USER
{
	private $db;

//생성자로서 db와 연동
	public function __construct()
	{
		$database = new Database();
		$conn = $database->dbConnection();
		$this->db = $conn;
    }

//sql 부르는 함수
		public function runQuery($sql)
		{
			$stmt = $this->db->prepare($sql);
			return $stmt;
		}

//회원등록
	public function register($id,$pw,$phone,$name,$nickname,$intro)
	{

		try
		{
			$hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

			$stmt = $this->db->prepare("INSERT INTO members(id,pw,phone,name,nickname,intro)
					VALUES(:id,:pw,:phone,:name,:nickname,:intro)");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":pw", $hashed_pw);
			$stmt->bindparam(":phone", $phone);
			$stmt->bindparam(":name", $name);
			$stmt->bindparam(":nickname", $nickname);
			$stmt->bindparam(":intro", $intro);
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

//회원정보수정
	public function edit_profile($id,$pw,$phone,$name,$nickname,$intro)
	{
		try
		{
			$hashed_pw = password_hash($pw, PASSWORD_DEFAULT);

			$stmt = $this->db->prepare("UPDATE members SET pw=:pw, phone=:phone, name=:name, nickname=:nickname, intro=:intro WHERE id=:id");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":pw", $hashed_pw);
			$stmt->bindparam(":phone", $phone);
			$stmt->bindparam(":name", $name);
			$stmt->bindparam(":nickname", $nickname);
			$stmt->bindparam(":intro", $intro);
			$stmt->execute();

			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

//로그인함수
	public function login($id,$pw)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM members WHERE id=:id LIMIT 1");
			$stmt->execute(array(':id'=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() > 0)
			{
				if(password_verify($pw, $userRow['pw']))
				{
					$_SESSION['id'] = $userRow['id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

//유저의 모든 소제 가져오기
	public function get_soje($id)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM keyword WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

//유저의 모든 소제 삭제
	public function delete_all_soje($id)
	{
		try
		{
			$stmt = $this->db->prepare("DELETE FROM keyword WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

//소제 추가
	public function add_soje($id, $category, $soje)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM keyword WHERE id=:id");
			$stmt->execute(array(':id'=>$id));

			if($stmt->rowCount()<6)
			{
				$stmt = $this->db->prepare("INSERT INTO keyword VALUES (:id, :category, :soje)");
				$stmt->execute(array(':id'=>$id,':category'=>$category,':soje'=>$soje));
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 소제 수정
	public function edit_soje($id, $oldcategory,$oldsoje,$newcategory, $newsoje)
	{
		try
		{
			$stmt = $this->db->prepare("UPDATE keyword SET category=:newcategory, soje=:newsoje WHERE id=:id and category=:oldcategory and soje=:oldsoje");
			$stmt->execute(array(':id'=>$id,':newcategory'=>$newcategory,':newsoje'=>$newsoje,':oldcategory'=>$oldcategory,':oldsoje'=>$oldsoje));

			//posts에 있던 자료들도 수정해줘야함.
			$stmt = $this->db->prepare("UPDATE posts SET category=:newcategory, soje=:newsoje WHERE memberID=:memberID and category=:oldcategory and soje=:oldsoje");
			$stmt->execute(array(':memberID'=>$id,':newcategory'=>$newcategory,':newsoje'=>$newsoje,':oldcategory'=>$oldcategory,':oldsoje'=>$oldsoje));

		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 소제 삭제
	public function delete_soje($id,$category,$soje)
	{
		try
		{
			$stmt = $this->db->prepare("DELETE FROM keyword WHERE id=:id AND category=:category AND soje=:soje");
			$stmt->execute(array(':id'=>$id,':category'=>$category,':soje'=>$soje));
			$stmt = $this->db->prepare("DELETE FROM posts WHERE memberID=:id AND soje=:soje");
			$stmt->execute(array(':id'=>$id,':soje'=>$soje));
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

// 카테고리 가져오기
	public function get_category($id,$soje)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM keyword WHERE id=:id AND soje=:soje");
			$stmt->execute(array(':id'=>$id,':soje'=>$soje));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return $userRow['category'];
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 카테고리 모두 가져오기
	public function get_all_category()
	{
			try
			{
				$stmt = $this->db->prepare("SELECT * FROM category");
				$stmt->execute();
				return $stmt;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}

	}

// introduction 가져오기
	public function get_intro($id)
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM members WHERE id=:id LIMIT 1");
			$stmt->execute(array(':id'=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return $userRow['intro'];
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

// 게시물 개수 가져오기
	public function get_num_post($id)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM posts WHERE memberId=:id");
			$stmt->execute(array(':id'=>$id));
			return $stmt->rowCount();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 유저의 게시물 가져오기
	public function get_user_post($memberId, $soje)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM posts WHERE memberId=:memberId and soje=:soje");
			$stmt->execute(array(':id'=>$memberId,':soje'=>$soje));
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 유저의 모든 게시물 가져오기
	public function get_post($id)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM posts WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return $userRow;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 상위 4위 게시물 가져오기
	public function get_best_post()
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM posts ORDER BY hits DESC LIMIT 4");
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 게시물 쓰기
	public function write_post($memberID, $category, $soje, $title, $content)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO posts(memberID,category,soje,title,content) VALUES (:memberID, :category, :soje, :title,:content)");
			$stmt->execute(array(':memberID'=>$memberID,':category'=>$category,':soje'=>$soje,':title'=>$title,':content'=>$content));
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 게시물 수정하기
	public function edit_post($id, $memberID, $category, $soje, $title, $content)
	{
		try
		{
			$stmt = $this->db->prepare("UPDATE posts SET memberID=:memberID,category=:category,soje=:soje,title=:title,content=:content WHERE id=:id");
			$stmt->execute(array(':id'=>$id,':memberID'=>$memberID,':category'=>$category,':soje'=>$soje,':title'=>$title,':content'=>$content));
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 게시물 삭제
	public function delete_post($id)
	{
		try
		{
			$stmt = $this->db->prepare("DELETE FROM posts WHERE id=:id");
			$stmt->execute(array(':id'=>$id));

		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

// 구독자수 가져오기
	public function get_num_subscriber($id)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM subscription WHERE writer=:id");
			$stmt->execute(array(':id'=>$id));
			return $stmt->rowCount();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 구독자 추가
	public function add_subscriber($subscriber, $writer)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO subscription VALUES(:subscriber,:writer)");
			$stmt->execute(array(':subscriber'=>$subscriber,':writer'=>$writer));
			return $stmt->rowCount();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 구독자 삭제
	public function delete_subscriber($subscriber, $writer)
	{
		try
		{
			$stmt = $this->db->prepare("DELETE FROM subscription WHERE subscriber=:subscriber AND writer=:writer");
			$stmt->execute(array(':subscriber'=>$subscriber,':writer'=>$writer));
			return $stmt->rowCount();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

// 조회수 추가
	public function add_hit($id)
	{
		$stmt = $this->db->prepare("UPDATE posts SET hits=hits+1 WHERE id=:id");
		$stmt->execute(array(':id'=>$id));

	}

// 회원탈퇴
	public function sign_out($id){

			$stmt = $this->db->prepare("DELETE FROM members WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
			$stmt = $this->db->prepare("DELETE FROM keyword WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
			$stmt = $this->db->prepare("DELETE FROM subscription WHERE writer=:id OR subscriber=:id");
			$stmt->execute(array(':id'=>$id));
			$stmt = $this->db->prepare("DELETE FROM posts WHERE memberID=:id");
			$stmt->execute(array(':id'=>$id));
		}

// 로그인 되어있는지
	public function is_loggedin()
	{
		if(isset($_SESSION['id']))
		{
			return true;
		}
	}

// 페이지 이동
	public function redirect($url)
	{
		header("Location: $url");
	}

// 로그아웃
	public function logout()
	{
		session_destroy();
		unset($_SESSION['id']);
		return true;
	}
}
?>
