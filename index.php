<?php 
require('mysql_lib.php');
$servername="localhost";
$username="root";
$password="kilkil";
$dbname="test";


$table="famille_tbl";
$id=2;
$champs[1]="nom";
$champs[2]="prenom";
$champs[3]="statut";
$delimiteur=" ##-## ";
$valeurs[1]="brahimi";
$valeurs[2]="karim";
$valeurs[3]="fils";

// lit une ligne de la base en specifiant le id et les champs ainsi qun delimiteur pour le return
mysql_get_line($servername, $username, $password, $dbname, $table, $id, $champs, $delimiteur);

//renvois l id max de la table
mysql_get_nb_max_id($servername, $username, $password, $dbname, $table);


//efface la ligne specifier par l'id
mysql_delete_line($servername, $username, $password, $dbname,$id,$table);

//insere une ligne dans la table
mysql_put_line($servername, $username, $password, $dbname, $table, $champs, $valeurs);

$champ="nom";
$valeur="changer";
//met a jour une ligne dans la table
mysql_update_line($servername, $username, $password, $dbname,$table,$id,$champ,$valeur);
?>
