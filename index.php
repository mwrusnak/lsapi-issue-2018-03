<!doctype html>
<html>
<head></head>
<body>

<p>A form</p>
<form action="index.php" method="post">
	<input type="text" name="theText" id="theText">
	<input type="submit" value="Submit" name="submit">
</form>

<?php
	// these stat() calls aren't real files, but will show up in "strace" output, so you can see where php://input is used
	stat('/tmp/before_reading_php_input_stream');
	print_r(file_get_contents('php://input'));
	stat('/tmp/after_reading_php_input_stream');
?>

</body>
</html>
