<?php

	require_once 'dbconfig.php';	// bring db and contact class.

	if(isset($_POST['addBtn']))	//when the add button is clicked
	{
		$name = trim($_POST['name']);	//remove the blanks.
		$phone = trim($_POST['phone']);
		$email = trim($_POST['email']);
		$notes = trim($_POST['notes']);

                if($name ==""){		//handle the error when the client doesn't put the name.
                        $error.= "Provide Name !";
                }else{


                        try
                        {
                                $stmt = $DB_con->prepare("SELECT id FROM contact WHERE name=:name and phone=:phone");	//check whether there is already the same person
                                $stmt->bindparam(":name",$name);
				$stmt->bindparam(":phone",$phone);
				$stmt->execute();
                                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                                if($stmt->rowCount() > 0)	//when there is already same person
                                {
                                        $error = "There is already this person.";
                                }
                                else
                                {
             
					$contact->add($name,$phone,$email,$notes);	//add new person to my contact list.
                                }

                        }
                        catch(PDOException $e)
                        {
                               echo $e->getMessage();
                        }
		}
	}

	if(isset($_POST['modifyBtn']))	//when modify button is clicked
	{
		$id = trim($_POST['id']);	//remove the blank.
		$name = trim($_POST['name']);
		$phone = trim($_POST['phone']);
		$email = trim($_POST['email']);
		$notes = trim($_POST['notes']);
                        try
                        {
                                $stmt = $DB_con->prepare("SELECT id FROM contact WHERE id=:id");	//check whether the person exist with the id client input.
                                $stmt->bindparam(":id",$id);
				$stmt->execute();
                                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                                if($stmt->rowCount() < 1)	//If there is no person matching.
                                {
                                        $modify_error = "There is no id matching person";
                                }
                                else
                                {
					$contact->modify($id,$name,$phone,$email,$notes);	//modify the person info. from my contact list.
                                }

                        }
                        catch(PDOException $e)
                        {
                               echo $e->getMessage();
                        }

	}

	if(isset($_POST['deleteBtn']))		//when the delete button is clicked.
	{
		$id = trim($_POST['id']);	//remove the blank.

                        try
                        {
                                $stmt = $DB_con->prepare("SELECT id FROM contact WHERE id=:id");	//check whether the id is correct
                                $stmt->bindparam(":id",$id);
				$stmt->execute();
                                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                                if($stmt->rowCount() < 1)	//if there is no matching person.
                                {
                                        $delete_error = "There is no person matching this id.";
                                }
                                else
                                {
					$contact->delete($id);	//delete person from my contact list.
                                }

                        }
                        catch(PDOException $e)
                        {
                               echo $e->getMessage();
                        }

	}

	if(isset($_POST['searchBtn']))	//when the search button is clicked
	{
		$name = trim($_POST['name']);	//remove the blank.

                        try
                        {	
				$stmt=$contact->search($name);
                                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                                if($stmt->rowCount() < 1)	//when there is no matching person.
                                {
                                        $string = "There is no one matching this name.";
                                }
                                else
                                {
					$string="The ID what you are finding is ";
					$string.=$row['id'];
					for($i=1;$i<$stmt->rowCount();$i++)	//bring all the people who has the client input id from the contact list and show it to the client.
					{
						$row=$stmt->fetch(PDO::FETCH_ASSOC);
						$string.=", ";
						$string.=$row['id'];
					}	
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
		<link rel="stylesheet" type="text/css" href="index.css">
	</head>
	<body>
		<!-- Bring contact list -->
		<?php
		$stmt=$contact->list();
		?>
		

		<!-- contact will be shown in table form -->
		<table class="list">
			<!-- the caption explaining the table -->
			<caption style=font-size:2em>MY CONTACT</caption>
			<!-- the header -->
			<thead>
			<tr>
				<th scope="cols">ID</th>
				<th scope="cols">NAME</th>
				<th scope="cols">TEL</th>
				<th scope="cols">E-MAIL</th>
				<th scope="cols">NOTES</th>
			</tr>
			</thead>
			<!-- the body part will be made dynamically from the contact database -->
			<tbody>
				<?php
				//bring all the people from the contact database and show it as a table form.
				for($i=0;$i<$stmt->rowCount();$i++)
				{
					$userRow=$stmt->fetch(PDO::FETCH_ASSOC); ?>
					<tr>
						<th><?php echo $userRow['id']?></th>
						<th><?php echo $userRow['name']?></th>
						<th><?php echo $userRow['phone']?></th>
						<th><?php echo $userRow['email']?></th>
						<th><?php echo $userRow['notes']?></th>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	
		<!-- Add part. If there is input error, it will show the error message dynamically -->
		<form class="add" method="post">
			<fieldset>
				<?php
					if(isset($error))
					{ ?>
					  <span class="popuptext" id="myPopup"><?php echo $error ?></span>
					<?php } ?>
				

				<input name="name" placeholder = "NAME" type="text"> 
				<input name="phone" placeholder = "TEL" type="tel"> 
				<input name="email" placeholder = "E-MAIL" type="email">
				<input name="notes" placeholder = "NOTES" type="text"> 
				<p><button name="addBtn" id="addBtn"><a>Add</a></button></p>
			</fieldset>
		</form>

		<!-- Modify part. If there is input error, it will show the error message dynamically -->
		<form class="modify" method="post">
			<fieldset>
					<?php
				if(isset($modify_error))
				{ ?>
					  <span class="popuptext" id="myPopup"><?php echo $modify_error ?></span>
				<?php } ?>
	
					<input name="id" placeholder = "ID" type="text"> 
					<input name="name" placeholder = "NAME" type="text">
					<input name="phone" placeholder = "TEL" type="tel">
					<input name="email" placeholder = "E-MAIL" type="email">
					<input name="notes" placeholder = "NOTES" type="text">

				<p><button class="button_base" name="modifyBtn" id="modifyBtn"><a>Modify</a></button></p>
			</fieldset>
		</form>

		<!-- Delete part. If there is input error, it will show the error message dynamically -->
		<form class="delete" method="post">
			<fieldset>
					<?php
				if(isset($delete_error))
				{ ?>
					  <span class="popuptext" id="myPopup"><?php echo $delete_error ?></span>
				<?php } ?>
	

					<input name="id" placeholder="ID" type="text">
				<p><button name="deleteBtn" id="deleteBtn"><a>Delete</a></button></p>
			</fieldset>
		</form>

		<!-- Search part. If there is input error, it will show the error message dynamically -->
		<form class="search" method="post">
			<fieldset>
					<?php
				if(isset($string))
				{ ?>
					  <span class="popuptext" id="myPopup"><?php echo $string ?></span>
				<?php } ?>
				
					<input name="name" placeholder = "Name" type="text"> 
				<p><button name="searchBtn" id="searchBtn"><a>Search</a></button></p>
			</fieldset>
		</form>
	</body>
</html>
