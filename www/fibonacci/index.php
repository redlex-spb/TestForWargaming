<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	require_once("../Main.php");
	$main = new Main();
	$main->run($_POST['from'], $_POST['to']);
}
?>
<!-- www/public/index.html -->
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
	</head>
	<body>
		<form enctype="multipart/form-data">
			<input type="number" name="from" placeholder="Начальный элемент последовательности" required min="0">
			<input type="number" name="to" placeholder="Конечный элемент последовательности" required min="0">
			<input type="submit">
		</form>
		<script src="../assets/js/common.js"></script>
	</body>
</html>
