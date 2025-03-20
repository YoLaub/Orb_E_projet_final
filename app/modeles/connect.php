<?php

 //Singleton - Connexion base de donnée
	abstract class DbConnect {
		
		public static function connexion() {
			
			try {
				$dsn = 'mysql:host=' . DB_HOST .';dbname=' . DB_DATABASE;
				$pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $pdo;
			} catch (PDOException $e) {
				return $e->getMessage()."<br />Erreur de connexion PDO !";
			}		
		}
		
		// Exécute une requête SQL éventuellement paramétrée
		protected static function executerRequete($sql, $values = []) {

			try {

				$query = self::connexion()->prepare($sql); // requête préparée

				//Binding des valeurs
				if(!empty($values)){
					foreach ($values as $key => $value){
						$param = (strpos($key,":")===0) ? $key : ":". $key;
						if(is_int($value)){
							$query->bindValue($param,$value,PDO::PARAM_INT);
						}else{
							$query->bindValue($param,$value,PDO::PARAM_STR);
						}
						}
				
					
				}
				$query->execute();
				return $query;
			}
			catch(Exception $e) {
				return $e->getMessage()."<br />Impossible d'envoyer les données dans la base de données' !";
			}
		}	
	}
	