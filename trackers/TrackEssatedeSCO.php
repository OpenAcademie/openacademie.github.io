<?php

//Script pour alimenter le tableau de tracker de EssatédéSCO à.c. V1.6.

file_put_contents('test.txt', serialize($_GET));
$datas = [

//Ces lignes correspondent aux colonnes du tableau qui sera rempli
	'accessVersion',
	'runtime',
	'OS',
	'version',
	'RNE',
	'commune',
	'etablissement',
	'nbprocedures'
];

$dbhost = "openacqae1945.mysql.db";
$username = "openacqae1945";
$password = "OAajicop1";
$dbname = "openacqae1945";

$ip = isset( $_SERVER['REMOTE_ADDR'] )?$_SERVER['REMOTE_ADDR']:'?';
$sqlTitleFields = 'ip, date';
$sqlfields = ':ip, NOW()';
foreach($datas as $data){
	$sqlTitleFields .= ', '.$data;
	$sqlfields .= ', :'.$data;
}

try {
//Bien mettre le nom de la table après INSERT INTO
	$dbh = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $username, $password);
	$stmt = $dbh->prepare("INSERT INTO TrackEssatedeSCO ($sqlTitleFields) VALUES ($sqlfields)");
	$stmt->bindParam(':ip', $ip);
	foreach($datas as $data){
		$stmt->bindParam(':'.$data, $_GET[$data]);
	}
	$stmt->execute();
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$dbh = null;
?>
