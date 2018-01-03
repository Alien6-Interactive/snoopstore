<?php
	
	require_once("Connection.php");//vérifie si le fichier Connection.php a déjà été inclus, et si c'est le cas, ne l'inclut pas une deuxième fois.

	
	/**
           * Cette fonction va permettre de lire un fichier csv.
		   * @param $fileName: Le chemin pour accéder au fichier csv.
		  * @param $nomTable: Le nom de la table dans laquelle on va stocker les différentes lignes du fichier csv.
	  
	*/
	
	function LireCSV($fileName,$nomTable)
	{
		// lecture intégrale d'un fichier.
		$contenu = fopen("$fileName",'r');# On ouvre le fichier $fileName en mode lecture.
		$i = 0; #variable permettant de différencier le nom des colonnes du corps du fichier csv.
		
		while ( !feof($contenu) )# tant que je n'est pas atteinds la fin du fichier $fileName.
		{
			$ligne = fgets($contenu);#je lis la prochaine ligne du fichier.
			$donnees = [];#tableau dans lequel je vais stoker les informations à insérer dans la table $nomTable.
			$ligne = explode(";",$ligne);#transformation de ma ligne en tableau dans lequel on supprime tous les points virgules.
			if ( $i != 0 )# si ce n'est pas le nom des colonnes de mon fichier csv.
			{
				
				
					foreach( $ligne as $cle => $valeur)#je parcour le tableau obtenus précédemment.
					{	
						
						if ($cle == 13 )# si $clé == 13.
						{
							if ($valeur == null)# si $valeur est null.
							{
								$donnees [] = 0; # on ajoute à $donnees la valeur 0 par défaut.
							}
							else
							{
								$donnees [] = (integer) $valeur;#le caste $valeur en integer.
							}
						}
						else if ($valeur == null)# pour toutes les autres valeurs NULL.
						{
							$donnees [] = "NULL"; # on ajoute à $donnees la valeur NULL par défaut.
						}
						else
						{
							
							$donnees [] = $valeur; #on ajoute à $donnees la valeur $valeur.
						}
						
					}
					if (count($donnees) == 16) # certains fichiers csv on une dernière ligne vide qui ne sert à rien.
					{
						unset($donnees[15]);# on efface cette dernière ligne.
					}				
				if (!feof($contenu))# si je n'est pas atteinds la fin du fichier.
				{
					InsertIntoTable($nomTable,$donnees);# j'insère dans la table $nomTable $donnees.
				}
				
			}
			$i += 1;# on incremente la valeur de controle.
		}
		
	}
	
	/**
          * Cette fonction va permettre d\'ouvir un repertoire et de le parcourir .
		  * @param $nomRepertoire: Le chemin du répertoire à analyser.
	  
	*/
		
	function ouvrirRepertoire($nomRepertoire)
	{
		if($dossier = opendir($nomRepertoire))# On Ouvre le dossier $nomRepertoire, et on récupère un pointeur dessus. 
		{
			
			while(false !== $fichier = readdir($dossier))# on vérifie que la lecture du dossier n'a pas retourné d'erreur.			
			{
				
				if( $fichier!= '.' && $fichier !='..')#on indique les fichiers à ignorer.
				{
					if (is_dir("$nomRepertoire$fichier"))#on teste si $nomRepertoire$fichier est un répertoire
					{
						ouvrirRepertoire("$nomRepertoire$fichier/");#on rapelle la fonction ouvrirRepertoire pour pouvoir analyser ce répertoire avant de passer à la suite du répertoire actuelle.
					}
					else # si $nomRepertoire$fichier est un fichier.
					{
						$nomTable =  str_replace('.csv', '', $fichier);# on supprime le .csv de la variable fichier.
						$nomTable = str_replace(' ', '_', $nomTable);# on remplace les espace par des '_'.
						$nomTable = str_replace('.', '_', $nomTable);# on remplace le point par un '_'.
						createTable($nomTable);# on créer une nouvelle table appellé $nomTable.
						$chemin = "$nomRepertoire$fichier";#variable stockant le chemin dy fichier csv à analyser.
						LireCSV($chemin,$nomTable);# on appelle la fonction LireCSV.
					}
				}
			}
			closedir($dossier);# on ferme le pointeur sur le dossier $nomRepertoire.
		}
	}
	ouvrirRepertoire("test/");#on appelle la fonction ouvrirRepertoire.
?>
