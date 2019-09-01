<?php
	session_start();
	// first, 從 cookie 裡面拿到 PHPSESSION
	include_once('./conn.php');
	include_once('./utils.php');
	$user = $_SESSION['username'];
	
	// 拿出 PHPSESSION 去查 username
	/*
		{
			'mu3b4k47bm2k7oif1k3m02c1d6': {
			username: $username
			}
		}
	*/
?>