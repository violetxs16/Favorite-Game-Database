<! doctype html>
<html lang = "en">
<head>
	<meta charset = "utf-8">
	<title>Favorite game database</title>
</head>
<body>
<h1>Favorite Game Database</h1>

<body>

Do you wish to enter a new entry?
<form action = "Violeta_Solorio_Project4_Script2.php" method = "POST" >
<input type= 'radio' name = 'answer3' value = 'Yes'> Yes
<input type = 'radio' name = 'answer3' value= 'No' checked = "checked">No
<p> Enter the following information to enter a new entry</p>
<p>First name <input type='text' name = 'first' size = '20' ></p>
<p>Last Name <input type = 'text' name ='last' size='20' ></p>
<p>Age     <input type = 'number' name='age' min = '0' max='100' size='20' ></p>
<p>Favorite Game <input type = 'text' name = 'favorite_game' size='20' ></p>
<p>Submit<input type = 'submit' name = 'submit' value = 'Click to submit form'></p>
</form>


<h2> Do you wish to delete an entry?</h2>
<form action = "Violeta_Solorio_Project4_Script2.php" method = "POST">
<input type= 'radio' name = 'answer4' value = 'Yes'> Yes
<input type = 'radio' name = 'answer4' value= 'No' checked = "checked">No
<p>Enter the first name, last name and age of the entry</p>

<p>First name<input type='text' name = 'del_first' size = '20' ></p>
<p>Last Name <input type = 'text' name ='del_last' size='20' ></p>
<p>Age     <input type = 'number' name='del_age' min = '0' max='100' size='20' ></p>
<p>Submit<input type = 'submit' name = 'submit' value = 'Click to submit form'></p>
</form>
<h2> Do you wish to update the game or age of a current setting?</h2>
<p>Enter the first name, last name and age of the entry along with designated age & game to be updated to</p>

<form action ="Violeta_Solorio_Project4_Script2.php" method ="POST">
<p>First name<input type = 'text' name = 'update_first' size='20'></p>
<p> Last name<input type = 'text' name = 'update_last' size='20'></p>
<p> Age <input type ='number' name = 'update_age' size ='20'></p>

Do you wish to update your favorite game?
<input type= 'radio' name = 'answer2' value = 'Yes'> Yes
<input type = 'radio' name = 'answer2' value= 'No'checked="checked" >No
<p>Favorite new game<input type='text' name='value_game' size='20'></p>
<p>Submit<input type = 'submit' name = 'submit' value = 'Click to submit form'></p>
</form>
<?php

if($_SERVER['REQUEST_METHOD']== 'POST'){
	$issue= false;//Will keep track of issues with adding to the database
	$issue2 = false;//Will keep track of issues with deleting from the database
	$issue3= false;//Will keep track of issues with updating the database
	
	//The answers will be used to ensure that no unnecesary messages are displayed to the user
	$entry_answer =$_POST['answer3'];
	$delete_answer = $_POST['answer4'];
	$game_answer = $_POST['answer2'];
	
	$database =  mysqli_connect('localhost','username','thepassword','project4_database');//Connects to database
	
	//Checks validity of answers submitted to add an entry
	if($entry_answer == "Yes"){
		if(!empty($_POST['first']) && !empty($_POST['last']) && !empty($_POST['age']) && !empty($_POST['favorite_game'])){//Checks that input is not empty

			//Uses mysqli_real_escape_string function to secure the input
			$first = mysqli_real_escape_string($database, trim(strip_tags($_POST['first'])));
			$last = mysqli_real_escape_string($database, trim(strip_tags($_POST['last'])));
			$favorite_game = mysqli_real_escape_string($database, trim(strip_tags($_POST['favorite_game'])));
			$age = $_POST['age'];
		}else{
			print"Enter all the information";
			$issue = true;
		}
	}else {
		print"<p>You did not wish to enter a new entry</p>";
		$issue = true;
	}
	
	//Checks validity of answers submitted to delete an entry
	if($delete_answer = "Yes"){//If the user answers yes to delete entry
		if(!empty($_POST['del_first']) && !empty($_POST['del_last']) && !empty($_POST['del_age'])){
			$del_first = mysqli_real_escape_string($database, trim(strip_tags($_POST['del_first'])));
			$del_last = mysqli_real_escape_string($database, trim(strip_tags($_POST['del_last'])));
			$del_age = $_POST['del_age'];
		}else{//There is an issue with deletion submission
			$issue2 = true;
		}
	}
	else{//There is no deletion submission
		print"<p> You did not wish to delete an entry</p>";
		$issue2 = true;
	}
	
	//Checks validity of answers submitted to update an entry
	if($game_answer == "Yes"){//If user answers yes to update age or game
		if(!empty($_POST['update_first']) && !empty($_POST['update_last']) && !empty($_POST['update_age'])){
			$update_first = mysqli_real_escape_string($database, trim(strip_tags($_POST['update_first'])));
			$update_last = mysqli_real_escape_string($database, trim(strip_tags($_POST['update_last'])));
			$update_age = $_POST['update_age'];
			if($game_answer == "Yes" && !empty($_POST['value_game'])){
				$new_game = mysqli_real_escape_string($database, trim(strip_tags($_POST['value_game'])));
			}
			else{//There is an issue with updating submission
			$issue3 = true;
			print"<p>Enter all the information to update the entry</p>";
			}
		}else{
			$issue3 = true;
			print"<p>Enter all the information to update the entry</p>";
		}
	}
	else{//There is no updating submission
		$issue3 = true;
	}
	
	if(!$issue){//If no issue is detected for insertion

		if( $database = @mysqli_connect('localhost','username','thepassword','project4_database')){//Connects to the database
			if($entry_answer == "Yes"){
				$query = "INSERT INTO data(id, first_name, last_name, age, game) VALUES(0,'$first','$last', '$age', '$favorite_game')";
				if(@mysqli_query($database, $query)){//Runs the query
					print"<p style ='color: green;'>The entry has been added has been added!</p>";
				}else{
					print "The data could not be added because: ". mysqli_error($database);
				}
				//Displays the other entrie's favorites games using SELECT
				$games = 'SELECT first_name,game FROM data';
				if($game = mysqli_query($database, $games)){//Runs the query
					print "<h2> These are peoples favorite games so far!";
					while($row = mysqli_fetch_array($game)){
						print "<h3>{$row['first_name']}'s favorite game is {$row['game']}";
					}
				}else{
					print"The data could not be retrived because".mysqli_error($database);
				}
			}
		}
		else{//Could not connect to the database
			print"Could not connect to database due to:". mysqli_connect_error();
		}
	}
	
	if(!$issue2){//If no issue is detected for deletion
		if($database= @mysqli_connect('localhost','username','thepassword','project4_database')){//Connects to the database
			if($delete_answer =="Yes"){
				$query = "DELETE FROM data WHERE first_name LIKE '%". $del_first."%' AND last_name LIKE '%".$del_last ."%' AND age LIKE '%".$del_age."%' LIMIT 1";
				$row = mysqli_query($database,$query);
				if(mysqli_affected_rows($database)== 1){//Checks if entry has been deleted
					print "<p style='color: green;'>The entry has been deleted</p>";
				}else{
					print "Could not delete the entry because:".mysqli_error($database);
				}
			}
		}else{
			print "Could not connect to database due to:". mysqli_connect_error();
		}
	}
	if(!$issue3){//If no issue is detected for updating
		if($database = @mysqli_connect('localhost','username','thepassword','project4_database')){//Connects to database
			
			if($game_answer == "Yes"){//If user answers yes to update game entry
				$query = "UPDATE data SET game = '$new_game' WHERE first_name LIKE '%".$update_first. "%' AND last_name LIKE '%". $update_last."%' AND age LIKE '%" .$update_age."%' LIMIT 1";
				$row = mysqli_query($database,$query);
				if(mysqli_affected_rows($database) ==1){//Checks if entry has been updated
					print"<p  style ='color: green;'>The entry has been updated!</p>";
				}else{
					print "Could not update entry because:". mysqli_error($database);
				}
			}
		}else{
			print"Could not connect to database due to:".mysqli_connect_error();
		}
	}

	 mysqli_close($database); // Close the connection
}


?>
</body>
</html>
