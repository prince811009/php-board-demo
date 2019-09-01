<?php
	include_once('check_login.php');
	require_once('conn.php');
	require_once('utils.php');

	if (
		isset($_POST['id']) &&
		!empty($_POST['id'])
		) {
			$id = $_POST['id'];			
			$sql = "DELETE FROM prince811009_comments where (id=? or parent_id=?) AND username =?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("iss", $id, $id, $user);
			if ($stmt->execute()) {
				// echo "success";
				echo json_encode(array(
				'result' => 'success',
				'message' => 'successfully deleted'
				));
			} else {
				// echo "fail"
				echo json_encode(array(
					'result' => 'failure',
					'message' => 'delete failed'
				));
			}
		} else {
			// echo "fail";
			echo json_encode(array(
				'result' => 'failure',
				'message' => 'delete failed'
		));
	}
?>