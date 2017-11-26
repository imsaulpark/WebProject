<?php

	$keywords = array("keyword1", "keyword2", "keyword3", "keyword4", "keyword5", "keyword6");


class USER
{
	private $db;


	function __construct($DB_con)
	{
		$this->db = $DB_con;
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
	public function get_keyword($id)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM keyword WHERE id=:id LIMIT 1");
			$stmt->execute(array(':id'=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return $userRow;
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
			$stmt->execute(array(':id'=>$memberId,':soje'=$soje));
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

	public function add_soje($id, $soje)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM keyword WHERE id=:id");
			$stmt->execute(array(':id'=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			for($i=0;$i<6;$i++)
			{
				if($userRow[$keywords[$i]]==NULL)
				{
					$stmt = $this->db->prepare("UPDATE keyword SET :keyname=:soje WHERE id=:id");
					$stmt->execute(array(':id'=>$id,':soje'=>$soje,':keyname'=>$keywords[$i]));
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
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
