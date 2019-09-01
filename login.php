<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Login</title>
	<link rel="stylesheet" href="./style.css">
</head>
<body>
	<?php require_once('./navbar.php') ?>
	<div class="container">
		<div class="form-wrapper">
			<form class="form" method="POST" action="./handle_login.php">
				<div class="form__row">
					帳號：<input type="text" name="username" />
				</div>
				<div class="form__row">
					密碼：<input type="password" name="password" />
				</div>
				<input type="submit" />
			</form>
		</div>
	</div>
</body>
</html>