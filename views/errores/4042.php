<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Error 404</title>
</head>
<body>
	<h1>404</h1>
	<?php if (isset($this->mensaje)): ?>
		<?php echo $this->mensaje ?>
	<?php endif ?>
</body>
</html>