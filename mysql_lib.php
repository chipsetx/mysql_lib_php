<?php
/*
	
	brahimi.karim@hotmail.fr

        in the file you use it put
	require("mysql_lib.php");

	mysql_get_line()
	mysql_put_line()
	mysql_update_line()
	mysql_delete_line()
	mysql_get_nb_lines()


*/

//############### get line ###################
function mysql_get_line($servername, $username, $password, $dbname, $table, $id, $champs ,$delimiteur){
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$nb_champs = count($champs);
	for($i=1;$i<=$nb_champs;$i++){
	if ($i==1) {$champs_tous=$champs[1]; }
	else { $champs_tous=$champs_tous.','.$champs[$i]; }
	}
	//echo $champs_tous;
	//requette select un id
	
	$sql = "SELECT ".$champs_tous." FROM ".$table." where id=".$id;
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
		for($i=1;$i<=$nb_champs;$i++){
		  if ($i==1) {$ligne=$row[$champs[$i]]; }
                  else { $ligne=$ligne.$delimiteur.$row[$champs[$i]]; }
		}	
	    }
 	return $ligne;
	echo $ligne;
	} else {
	    echo "0 results";
	}
	mysqli_close($conn);
}

//############### put line ###################

function mysql_put_line($servername, $username, $password, $dbname, $table, $champs, $valeurs){
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$nb_champs = count($champs);
	for($i=1;$i<=$nb_champs;$i++){
		if ($i==1) {
			$champs_tous=$champs[1]; 
			$valeurs_tous="'".$valeurs[1]."'";
		}
		else { 
			$champs_tous=$champs_tous.','.$champs[$i]; 
			$valeurs_tous=$valeurs_tous.",'".$valeurs[$i]."'";
		}
	}
//echo $valeurs_tous;
	$sql = "INSERT INTO ".$table." (".$champs_tous.")
	VALUES (".$valeurs_tous.")";

	if (mysqli_query($conn, $sql)) {
	    echo "New record created successfully";
	} else {
	    return "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);
}

//############## update line ###############

function mysql_update_line($servername, $username, $password, $dbname,$table,$id,$champ,$valeur){
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "UPDATE ".$table." SET ".$champ."='".$valeur."' WHERE id=".$id;

	if (mysqli_query($conn, $sql)) {
	    echo "Record updated successfully";
	    return 1;
	} else {
	    echo "Error updating record: " . mysqli_error($conn);
	    return 0;
	}

	mysqli_close($conn);
}



//############## delete line ###############

function mysql_delete_line($servername, $username, $password, $dbname,$id,$table){
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection si fail
	if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
	// requette sql pour effacer un enregistrement
	$sql = "DELETE FROM ".$table." WHERE id=".$id;
        // execution requette et si erreur
	if (mysqli_query($conn, $sql)) {
	    echo "Record deleted successfully";
	    return 1;
	} else {
	    echo "Error deleting record: " . mysqli_error($conn);
	    return 0;
	}
	mysqli_close($conn);
}

//############### get number of lines #############

function mysql_get_nb_max_id($servername, $username, $password, $dbname, $table){
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql="SELECT MIN(id) AS min, MAX(id) AS max FROM ".$table;
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	echo "the last id is ". $row['max'] . "<br>";  

	mysqli_close($conn);
	return $row['max'];

}

?>
