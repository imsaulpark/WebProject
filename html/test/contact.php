<?php

//this php file only contains contact class.
class CONTACT
{
	private $db;

	//bring the object connected to db
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}

	//add new person to the db
	public function add($name,$phone,$email,$notes)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO contact(name,phone,email,notes) VALUES(:name,:phone,:email,:notes)");

			$stmt->bindparam(":name", $name);
			$stmt->bindparam(":phone", $phone);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":notes", $notes);
			$stmt->execute();

			return $stmt;
		}catch(PDOException $e){
			echo $e->getMessage();
		}

	}

	//modify the existing person information
	public function modify($id,$name,$phone,$email,$notes)
	{

		try{

			$stmt = $this->db->prepare("SELECT * FROM contact WHERE id=:id LIMIT 1");
			$stmt->execute(array(':id'=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			//check whether the is no person matching in the db
			if($stmt->rowCount() > 0)
			{
				$stmt = $this->db->prepare("UPDATE contact SET name=:name,phone=:phone,email=:email,notes=:notes WHERE id=:id");
				$stmt->bindparam(":id",$id);
				$stmt->bindparam(":name", $name);
				$stmt->bindparam(":phone", $phone);
				$stmt->bindparam(":email", $email);
				$stmt->bindparam(":notes", $notes);
				$stmt->execute();
			}
			else
				return false;

		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	//remove the person from the contact db.
	public function delete($id)
	{
		try{
			
			$stmt = $this->db->prepare("SELECT * FROM contact WHERE id=:id LIMIT 1");
			$stmt->execute(array(':id'=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			//check whether there is no matching person.
			if($stmt->rowCount() > 0)
			{
				$stmt = $this->db->prepare("DELETE FROM contact WHERE id=:id");
				$stmt->execute(array(':id'=>$id));

				//when delete the person, rearrange the auto increment id value.
				$stmt=$this->db->prepare("ALTER TABLE contact AUTO_INCREMENT=1; SET @COUNT = 0; UPDATE contact set contact.id = @COUNT:=@COUNT+1;");
				$stmt->execute();

			}
			else
				return false;

		}catch(PDOException $e){
			echo $e->getMessage();
		}	
	}

	//search person id by the name
	public function search($name)
	{
		try{

			$stmt = $this->db->prepare("SELECT id FROM contact WHERE name=:name");
			$stmt->execute(array(':name'=>$name));
			return $stmt;

		}catch(PDOException $e){
			echo $e->getMessage();
		}	
	
	}

	//bring all the list in the contact db.
	public function list()
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM contact");
			$stmt->execute();
			return $stmt;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}


}
?>



