<?php
	header('Access-Control-Allow-Origin: *');
	
	if(!isset($_GET['path']))
		$page = '';

	if(isset($_GET['path']))
		$path = explode("/", $_GET['path']);

	if(isset($path[0]))
		$page = $path[0];
	
	if(isset($path[1]))
		$subpage = $path[1];

	$method = $_SERVER['REQUEST_METHOD'];
	include_once 'src/routes.php';
?>