<?php 
	class DB{
		public static function connect_posts_db(){
			$host = 'localhost';
			$user = 'root';
			$pass = '';
			$base = 'akee_posts';
	
			return new PDO("mysql: host={$host};
							dbname={$base};
							charset=UTF8;", $user, $pass);
		}

		public static function connect_users_db(){
			$host = 'localhost';
			$user = 'root';
			$pass = '';
			$base = 'akee_users';

			return new PDO("mysql: host={$host};
							dbname={$base};
							charset=UTF8;", $user, $pass);	
		}
	}
?> 