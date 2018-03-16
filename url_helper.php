<?php
	//Redirecting page
	function redirect($page){
		header('location: ' . URLROOT . '/' . $page);
	}


?>