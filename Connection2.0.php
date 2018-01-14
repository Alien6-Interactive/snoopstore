<?php
	
	
	/**
          * Cette fonction va permettre de creer une nouvelle table.
		  * @param $nom: Le nom de la nouvelle table à créer.
	  
	*/
	function createTable($nom)
	{
		$servername = "localhost";#le nom du serveur où se situe la base de données.
		$username = "root";#L'identifiant pour se connecter.
		$password = "";#Le mot de passe.
		$dbname = "mises_a_jours";#Le nom de la base de données.
		
		
		$conn = mysqli_connect($servername, $username, $password, $dbname);// Connection à la base de données.
		
		
		if (!$conn) {# On teste si la connection à échoué.
			die("La connection a échoué: " . mysqli_connect_error());
		}
		
		// Création de la table nommée $nom.
		$sql = "CREATE TABLE IF NOT EXISTS $nom (
				ID SERIAL,
				Product_Version  VARCHAR(128),
				Release_Category VARCHAR(128),
				Product_Instance VARCHAR(128),
				Database_Version VARCHAR(128),
				Database_Name VARCHAR(128),
				Database_Supported_Until DATE NULL DEFAULT NULL,
				Operating_System VARCHAR(128),
				Autre_Operating_System VARCHAR(128),
				Operating_System_Supported_Until DATE,
				Scope VARCHAR(128),
				Scope_Supported_Until DATE,
				Status VARCHAR(128),
				Valid_from Date,
				Additional_Information INTEGER, 
				Link_SAP VARCHAR(300),
				PRIMARY KEY(ID)
				
			)";

		if (mysqli_query($conn, $sql)) # on teste si la table a bien été crée.
		{
			echo "<p>La Table $nom à été créee avec succès </ p>";
		} else
		{
			echo "<p> Erreur dans la création de la table: " . mysqli_error($conn)."</p>";
		}
		
		// Suppression de tous les éléments de la table $nom.
		$sup = "DELETE FROM $nom";
		if (mysqli_query($conn, $sup)) {# on teste si la table a bien été vidé.
			echo "<p>La Table $nom à été vidée avec succès </ p>";
		} 
		else
		{
			echo "<p> Erreur dans la suppression de la table: " . mysqli_error($conn)."</p>";
		}

		mysqli_close($conn);# on ferme la connection.
	}
	
	
	/**
          * Cette fonction va permettre d'insérer un tuple à une table.
		  * @param $nom: Le nom de la table.
		  * @param $ligne: Les informations à insérer dans la table.
	  
	*/
	
	function InsertIntoTable($nom,$ligne)
	{
		
		
		$db = mysqli_connect("localhost", "root", "", "mises_a_jours");# on se connecte à la base de données.
		if (!$db) {# on teste si la connection à échoué.
			die("Connection failed: " . mysqli_connect_error());
		}
		// on écrit la requête sql 
		$sql = "INSERT INTO $nom(
					ID,
					Product_Version,
					Release_Category,
					Product_Instance,
					Database_Version,
					Database_Name,
					Database_Supported_Until,
					Operating_System,
					Autre_Operating_System,
					Operating_System_Supported_Until,
					Scope,
					Scope_Supported_Until,
					Status,
					Valid_from,
					Additional_Information,
					Link_SAP
				)
				VALUES(
					DEFAULT,'" . implode("','",$ligne) . "'							
				)";	
			
		// teste si la ligne à bien été ajouté. 
		if ($db->query($sql) === TRUE) 
		{
			echo "<p> une ligne à été ajouté à la table : $nom <p>";

		} 
		else
		{
			echo "<p>Erreur lors de l'insertion du tuple: " . $sql . "<br>" . $db->error."</p>";
		}
		
			
		
		
		mysqli_close($db);  // on ferme la connexion 
    } 
	function CreateDataBase($nom)
	{
		
			$servername = "localhost";#le nom du serveur où se situe la base de données.
			$username = "root";#L'identifiant pour se connecter.
			$password = "";#Le mot de passe.

			// Create connection
			$conn = new mysqli($servername, $username, $password);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 

			// Create database
			$sql = "CREATE DATABASE IF NOT EXISTS		 $nom";
			if ($conn->query($sql) === TRUE) {
				echo "Database created successfully";
			} else {
				echo "Error creating database: " . $conn->error;
			}

			$conn->close();

	}
	
?> 