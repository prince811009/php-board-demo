<?php
	function printMessage($msg, $redirect) {
		echo '<script>';
		echo "alert('" . htmlentities($msg, ENT_QUOTES) . "');";
		echo "window.location = '" . $redirect . "'";
		echo '</script>';
	}

	function escape($str) {
		return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
	}

	function setToken($conn, $username) {
		$token = uniqid();
		$sql = "DELETE FROM prince811009_certificates where username='$username'";
		$conn->query($sql);

		$sql = "INSERT INTO prince811009_certificates(username, token) VALUES('$username', '$token')";
		$conn->query($sql);
		setcookie("token", $token, time()+3600*24);
	}

	// function getUserByToken($conn, $token) {
	// 	if (isset($token) && !empty($token)) {
	// 		$sql = "SELECT * from prince811009_certificates where token ='$token'";
	// 		$result = $conn->query($sql);
	// 		if (!$result || $result->num_rows <= 0) {
	// 			return null;
	// 		}
	// 		$row = $result->fetch_assoc();
	// 		return $row['username'];
	// 	} else {
	// 		return null;
	// 	}
	// }

	function renderDeleteBtn($id) {
		return "
		<div class='btn delete-comment' data-id='$id'>
			刪除
		</div>
		";
	}

	function renderEditBtn($id) {
		return "
		<div class='edit-comment'>
			<form method='GET' action='./edit_comment.php'>
				<input type='hidden' name='id' value='$id' />
				<input type='submit' value='編輯' />		
			</form>
		</div>
		";
	}
?>