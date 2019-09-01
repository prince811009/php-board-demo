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
	<title>Home</title>
	<link rel="stylesheet" href="./style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
	<script>
		$(document).ready(function() {
			// console.log($) //check whether jQuery is imported
			$('.comments').on('click', '.delete-comment', function(e) {				
				if (!confirm('是否確定刪除 ?')) return
				const id = $(e.target).attr('data-id')

				// console.log('---Defining ajax operation')
				$.ajax({
					method: "POST",
					url: "./delete_comment.php",
					data: {
						id
					}
				}).done(function(response) {
					const msg = JSON.parse(response)
					console.log('msg:', msg)
					const subComment = $(e.target).parent('.sub-comment')
					if (subComment.length === 0) {
						$(e.target).parent('.comment').hide(200)
					} else {
						subComment.hide(200)
					}
				}).fail(function() {
					alert('刪除失敗')
				});
				// console.log('---ajax operation is defined')
			})
		})
	</script>
<body>
	<?php include_once('./navbar.php') ?>
	<?php
		$page = 1;
		if (isset($_GET['page']) && !empty($_GET['page'])) {
			$page = (int) $_GET['page'];
		}
		$size = 20;
		$start = $size * ($page - 1);
		$sql = "SELECT c.id, c.content, c.created_at, c.username, u.nickname FROM prince811009_comments as c LEFT JOIN prince811009_users as u ON c.username = u.username WHERE c.parent_id = 0 ORDER BY c.id DESC LIMIT ?, ?";
		
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ii", $start, $size);
		$is_success = $stmt->execute();
		$result = $stmt->get_result();
	?>
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
		<h1>來留言吧~</h1>
		<form class="form" method="POST" action="./add_comment.php">
			<input type="hidden" value="0" name="parent_id" />
			<div class="form__row">
				內容：
				<div>
					<textarea name="content" rows="10" cols="90"></textarea>
				</div>			
			</div>
			<?php if ($user) { ?>
				<input type="submit" />
			<?php } else { ?>
				<div>請先註冊或登入</div>
			<?php } ?>
		</form>
	</div>
	<?php
		$count_sql = "SELECT count(*) as count FROM prince811009_comments where parent_id=0";
		$count_result = $conn->query($count_sql);	
		if ($count_result && $count_result->num_rows > 0) {
			$count = $count_result->fetch_assoc()['count'];
			$total_page = ceil($count / $size);
			echo '<div class="page">';
			for($i=1; $i<=$total_page; $i++) {
				echo "<a href='./index.php?page=$i'>$i</a>";
			}
			echo '</div>';
		}
	
	?>

	<div class="comments">
		<?php
			if ($is_success) {
				while($row = $result->fetch_assoc()) {
					?>
						<div class="comment">
							<div class="comment__author">作者：<?= escape($row['nickname']) ?></div>
							<div class="comment__content"><?= escape($row['content']) ?></div>
							<div class="comment__time">發言時間：<?= $row['created_at'] ?></div>
													
								<?php
									if ($user === $row['username']) {
										echo renderEditBtn($row['id']);
										echo renderDeleteBtn($row['id']);
									};
								?>
							
							<div class="sub-comments">
								<?php
									$parent_id = $row['id'];
									$sql_sub = "SELECT c.id, c.content, c.created_at, c.username, u.nickname FROM prince811009_comments as c LEFT JOIN prince811009_users as u ON c.username = u.username WHERE c.parent_id = ? ORDER BY c.id DESC";
									$stmt_sub = $conn->prepare($sql_sub);
									$stmt_sub->bind_param("i", $parent_id);
									$is_sub_success = $stmt_sub->execute();
									$result_sub = $stmt_sub->get_result();

									if ($is_sub_success) {
										while($row_sub = $result_sub->fetch_assoc()) {
								?>
									<div class="sub-comment">
										<div class="sub-comment__author">作者：<?= escape($row_sub['nickname']) ?></div>
										<div class="sub-comment__content"><?= escape($row_sub['content']) ?></div>
										<div class="sub-comment__time">發言時間：<?= $row_sub['created_at'] ?></div>
										<?php
											if ($user === $row_sub['username']) {
												echo renderEditBtn($row_sub['id']);
												echo renderDeleteBtn($row_sub['id']);
											};
										?>
									</div>
								<?php
										}
									}
								?>
								<div class="add-sub-comment">
									<h3>新增留言</h3>
									<form method="POST" action="./add_comment.php">
									<input type="hidden" value="<?php echo $parent_id; ?>" name="parent_id" />
										<div class="form__row">
											內容：
											<div>
												<textarea name="content" style="margin: 0px; width: 492px; height: 126px;"></textarea>
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
						</div>
					<?php
				}
			}
		?>
		</div>
	</div>
</body>
</html>