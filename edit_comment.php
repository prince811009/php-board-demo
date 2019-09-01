<?php
	include_once('./check_login.php');
	include_once('./conn.php');
	include_once('./utils.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>編輯留言</title>
	<link rel="stylesheet" href="./style.css">
</head>
<body>
	<?php include_once('./navbar.php') ?>
	<div class="container">
		<?php
			if ($user) {
				echo '<h1>Hello, ' . $user . '</h1>';
			} else {
				echo 'Please login or register';
			}
		?>

	<div class="form-wrapper">
		<p>「本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼」</p>
		<h1>編輯留言~</h1>
		<form class="form" method="POST" action="./handle_edit_comment.php">
			<input type="hidden" value="<?php echo $_GET['id'] ?>" name="id" />
			<div class="form__row">
				內容：
				<div>
					<textarea name="content" rows="10" cols="80"></textarea>
				</div>			
			</div>
			<?php if ($user) { ?>
				<input type="submit" />
			<?php } else { ?>
				<div>請先註冊或登入</div>
			<?php } ?>
		</form>
	</div>
	</div>
</body>
</html>