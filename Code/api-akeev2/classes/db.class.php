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

			$conexao = mysqli_connect($host, $user, $pass, $base);

			mysqli_set_charset($conexao, 'utf8');

			if(mysqli_connect_errno()){
				echo 'Erro ao tentar se conectar com o BD MySQL: '.mysqli_connect_error();
			}

			return $conexao;
		}
	}
?>