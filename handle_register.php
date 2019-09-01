<?php
	session_start();
	require_once('conn.php');
	require_once('utils.php');

	if (
		isset($_POST['nickname']) &&
		isset($_POST['username']) &&
		isset($_POST['password']) &&
		!empty($_POST['nickname']) &&
		!empty($_POST['username']) &&
		!empty($_POST['password'])
		) {
			$nickname = $_POST['nickname'];
			$username = $_POST['username'];
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$sql = "INSERT INTO prince811009_users(nickname, username, password) VALUES (?, ?, ?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("sss", $nickname, $username, $password);
			if ($stmt->execute()) {
				$_SESSION['username'] = $username;
				printMessage('註冊成功', './index.php');
			} else {
				printMessage($conn->error, './register.php');
			}

		} else {
			printMessage('請輸入帳號或是密碼', './register.php');
	}
?>