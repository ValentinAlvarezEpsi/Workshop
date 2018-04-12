<?php 
	if(!isset($_SESSION["profil"])) header("Location: index.php?page=login");

	$idProject = $_GET["project"];
	$teams = array();
	$listUser = array();
	$teamRegister = null;
	$currentUser = unserialize($_SESSION["profil"]);



	// Set l'user dans une team -----------------------------
	if(isset($_GET["idTeam"])) {
		$stmt = $con->prepare('INSERT INTO appartenir (id, id_User) VALUES (:idTeam, :idUser)');
		$stmt->bindValue(':idTeam', $_GET["idTeam"]);
		$stmt->bindValue(':idUser', $currentUser->id, PDO::PARAM_INT);
		$stmt->execute();
	}
	// -------------------------------------------------------

	// Get le projet -----------------------------------------
	$stmt = $con->prepare('SELECT * FROM project WHERE id = :id');
	$stmt->bindValue(':id', $idProject, PDO::PARAM_STR);
	$stmt->execute();

	$project = $stmt->fetchObject();
	$stmt->closeCursor();

	// --------------------------------------------------------


	// Get les teams créées via un idProjet -------------------
	$stmt = $con->prepare('SELECT * FROM team WHERE id_Project = :id');
	$stmt->bindValue(':id', $idProject, PDO::PARAM_STR);
	$stmt->execute();

	while ($team = $stmt->fetchObject()) {
		array_push($teams, $team);
	}
	$stmt->closeCursor();
	// ---------------------------------------------------------


	// Get les Users des teams ---------------------------------

	foreach ($teams as $aTeam) {
		$stmt = $con->prepare('SELECT U.firstname, U.lastname FROM appartenir A, user U, student S WHERE U.id = S.id AND S.id = A.id_User AND A.id = :idTeam');
		$stmt->bindValue(':idTeam', $aTeam->id, PDO::PARAM_INT);
		$stmt->execute();

		while ($aUser = $stmt->fetchObject()) {
			$obj = (object) array('firstname' => $aUser->firstname, 'lastname' => $aUser->lastname, 'idTeam' => $aTeam->id);
			array_push($listUser, $obj);
		}	
		$stmt->closeCursor();
	}

	// -------------------------------------------------------------

	// Get les teams ou l'étudiant est inscrit ---------------------
	$stmt = $con->prepare('SELECT id FROM appartenir WHERE id_User = :idUser AND id = :idProject');
	$stmt->bindValue(':idUser', $currentUser->id, PDO::PARAM_STR);
	$stmt->bindValue(':idProject', $idProject, PDO::PARAM_STR);
	$stmt->execute();

	$teamRegister = $stmt->fetchObject();
	$stmt->closeCursor();


	// -------------------------------------------------------------


	require_once(dirname(__FILE__).'/../views/'.$_GET["page"].'.php');