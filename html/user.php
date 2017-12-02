<?php

	$keywords = array("keyword1", "keyword2", "keyword3", "keyword4", "keyword5", "keyword6");
	require_once('dbconfig.php');


class USER
{
	private $db;

	public function __construct()
	{
		$database = new Database();
		$conn = $database->dbConnection();
		$this->db = $conn;
    }

		public function runQuery($sql)
		{
			$stmt = $this->db->prepare($sql);
			return $stmt;
		}

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

	public function delete_soje($id,$category,$soje)
	{
		try
		{
			$stmt = $this->db->prepare("DELETE FROM keyword WHERE id=:id AND category=:category AND soje=:soje");
			$stmt->execute(array(':id'=>$id,':category'=>$category,':soje'=>$soje));
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}

	}

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

	public function get_num_post($id)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM posts WHERE memberId=:id LIMIT 1");
			$stmt->execute(array(':id'=>$id));
			return $stmt->rowCount();
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

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

	public function add_hit($id)
	{
		$stmt = $this->db->prepare("UPDATE posts SET hits=hits+1 WHERE id=:id");
		$stmt->execute(array(':id'=>$id));

	}

	public function sign_out($id){

			$stmt = $this->db->prepare("DELETE FROM members WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
	}

	public function is_loggedin()
	{
		if(isset($_SESSION['id']))
		{
			return true;
		}
	}

	public function redirect($url)
	{
		header("Location: $url");
	}

	public function logout()
	{
		session_destroy();
		unset($_SESSION['id']);
		return true;
	}
}
?>
