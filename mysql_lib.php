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
function mysql_check_line($servername, $username, $password, $dbname, $table, $id){
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql="SELECT id FROM ".$table." WHERE id = '" . $id . "'";
	$req = mysqli_query($conn,$sql) or exit(mysql_error());
	if (mysqli_num_rows($req) == 1) {
	     echo 'Ok';
	     return 1;
	}
	else {
	     return 0;
	     echo 'Pas ok.';
	}
}


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
	mysqli_close($conn);
 	return $ligne;
	//echo $ligne;
	} else {
	    echo "0 results";
	}

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

//############### re order lines #############

function re_order($servername, $username, $password, $dbname,$table,$id_effacer){

$champs[1]="nom";
$champs[2]="prenom";
$champs[3]="statut";
$delimiteur=" ##-## ";

for($id=$id_effacer+1;$id<=10;$id++){
$line=mysql_get_line($servername, $username, $password, $dbname, $table, $id, $champs, $delimiteur);

$valeurs_premier=explode($delimiteur, $line);
$id_moinsun=$id-1;
$valeurs[2]=$valeurs_premier[0];
$valeurs[3]=$valeurs_premier[1];
$valeurs[4]=$valeurs_premier[2];
print_r($valeurs);
}
$champ="nom";
$valeur=$valeurs[2];
mysql_update_line($servername, $username, $password, $dbname,$table,$id_moinsun,$champ,$valeur);
/*
mysql_delete_line($servername, $username, $password, $dbname,$id,$table)
$champs=explode(" ", $line);
$id=$id_prochain
*/


//############### get number of lines #############
}

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
