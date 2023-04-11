<! doctype html>
<html lang = "en">
<head>
	<meta charset = "utf-8">
	<title> Connect to MySQL</title>
</head>
<body>

<?php
/*
The following Script will create the following the table: data
If the tables could not be created a error message will occur
*/
	//project4_database was created through phpMyAdmin
	if($database = @mysqli_connect('localhost','username','thepassword', 'project4_database')){//Establishes connection to database & assigns it to variable $database
		print "Connected!";
		$query = 'CREATE TABLE data(id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, first_name TEXT NOT NULL, last_name TEXT NOT NULL, age INT NOT NULL, game TEXT NOT NULL )';//Creates table for fruits
		if(@mysqli_query($database, $query)){//Checks if fruits table is created
			print "<h3>Table was sucessfully Created</h3>";
			
		}else{//Fruits table was not created
			print "<h3> Could not create fruits table because: ". mysqli_error($database);	
		}
		mysqli_close($database);//Closes the database
	}	
	
	else{//Could not establish connection to the database
		print"was not able to connect because of". mysqli_connect_error();
	}

?>

</body>
</html>