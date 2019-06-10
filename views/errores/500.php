<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Error 500</title>
</head>
<body>
	<h1>500</h1>
	<?php if (isset($this->mensaje)): ?>
		<?php echo $this->mensaje ?>
	<?php endif ?>
</body>
</html>